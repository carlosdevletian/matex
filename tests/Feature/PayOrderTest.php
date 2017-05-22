<?php

namespace Tests\Feature;

use App\Billing\FakePaymentGateway;
use App\Billing\PaymentGateway;
use App\Models\Address;
use App\Models\Design;
use App\Models\Item;
use App\Models\Order;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PayOrderTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    private function makeOrderThings()
    {
        factory(Status::class)->create(['name' => 'Payment Pending']);
        factory(Status::class)->create(['name' => 'Payment Approved']);
        $user = factory(User::class)->create();
        $address = factory(Address::class)->states('with-user')->create(['user_id' => $user->id]);
        $design = factory(Design::class)->create();
        $items = factory(Item::class, 2)->create();
        foreach ($items as $item) {
            $item->calculate()->save();
        }

        $order = factory(Order::class)->states('for-user')->create(['address_id' => $address->id]);
        $order->items()->saveMany($items);
        $order->calculatePricing();
        $order->save();

        return [
            'user' => $user,
            'address' => $address,
            'design' => $design,
            'design' => $design,
            'items' => $items,
            'items' => $items,
            'order' => $order,
        ];
    }

    private function getTotalPrice($items)
    {
        return $items->each->calculate()->sum('total_price');
    }

    /** @test */
    public function guest_can_pay_order()
    {
        factory(Status::class)->create(['name' => 'Payment Pending']);
        factory(Status::class)->create(['name' => 'Payment Approved']);
        $items = factory(Item::class, 3)->make();

        $this->assertEquals(Order::count(), 0);

        session(['design' => 'image_name.png']);
        $response = $this->json('POST', "/pay", [
            'payment_token' => $this->paymentGateway->getValidTestToken(),
            'newAddress' => factory(Address::class)->make(),
            'selectedAddress' => 0,
            'items' => $items,
            'design' => 'image_name.png',
            'category_id' => 1,
            'total_price' => $this->getTotalPrice($items)
        ]);

        $response->assertStatus(200);
        $this->assertEquals(Order::count(), 1);
        $this->assertEquals(Address::count(), 1);
        $this->assertEquals(Item::count(), 3);
    }

    /** @test */
    public function registered_user_can_pay_an_order()
    {
        Mail::fake();
        $orderInformation = $this->makeOrderThings();

        $response = $this->actingAs($orderInformation['user'])->json('POST', "/pay", [
            'email' => $orderInformation['user']->email,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
            'selectedAddress' => $orderInformation['address']->id,
            'items' => $orderInformation['items'],
            'design' => $orderInformation['design']->id,
            'total_price' => $orderInformation['order']->total,
        ]);

        $response->assertStatus(200);
        $this->assertEquals($orderInformation['order']->total, $this->paymentGateway->totalCharges());
        $response->assertJson(['status' => 'Payment Approved']);
    }

    /** @test */
    public function an_exception_is_thrown_if_payment_fails()
    {
        Mail::fake();
        $orderInformation = $this->makeOrderThings();

        $response = $this->actingAs($orderInformation['user'])->json('POST', "/pay", [
            'email' => $orderInformation['user']->email,
            'payment_token' => 'invalid-payment-token',
            'selectedAddress' => $orderInformation['address']->id,
            'items' => $orderInformation['items'],
            'design' => $orderInformation['design']->id,
            'total_price' => $orderInformation['order']->total,
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }
}
