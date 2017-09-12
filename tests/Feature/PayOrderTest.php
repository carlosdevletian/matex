<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Design;
use App\Models\Status;
use App\Models\Address;
use App\Models\Product;
use App\Models\Category;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;
use Illuminate\Support\Facades\Mail;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PayOrderTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        Mail::fake();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
        factory(\App\Models\CurrencyRate::class)->create(['currency_code' => 'cop']);
    }

    private function makeOrderThings()
    {
        $category = factory(Category::class)->create();
        factory(Pricing::class)->create(['category_id' => $category->id, 'min_quantity' => 50]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);

        factory(Status::class)->create(['name' => 'Payment Pending']);
        factory(Status::class)->create(['name' => 'Payment Approved']);
        $user = factory(User::class)->create();
        $address = factory(Address::class)->states('with-user')->create(['user_id' => $user->id]);
        $design = factory(Design::class)->create();
        $items = factory(Item::class, 2)->create(['product_id' => $product->id, 'quantity' => 75]);
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
        $category = factory(Category::class)->create();
        factory(Pricing::class)->create(['category_id' => $category->id, 'min_quantity' => 50]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        factory(Status::class)->create(['name' => 'Payment Pending']);
        factory(Status::class)->create(['name' => 'Payment Approved']);
        $items = factory(Item::class, 3)->make(['product_id' => $product->id, 'quantity' => 75]);

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
