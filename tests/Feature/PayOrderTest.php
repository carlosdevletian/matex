<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Billing\PaymentGateway;
use App\Billing\FakePaymentGateway;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PayOrderTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $this->paymentGateway = new FakePaymentGateway;
        $this->app->instance(PaymentGateway::class, $this->paymentGateway);
    }

    /** @test */
    public function customer_can_pay_an_order()
    {

        $order = factory(Order::class)->create(['total' => 20000]);

        $response = $this->json('POST', "/pay", [
            'order_id' => $order->id,
            'payment_token' => $this->paymentGateway->getValidTestToken(),
        ]);

        $response->assertStatus(200);
        $this->assertEquals(20000, $this->paymentGateway->totalCharges());
        // Queremos revisar tambien que el estatus de la orden sea pagada
    }

    /** @test */
    public function an_exception_is_thrown_if_payment_fails()
    {
        // Queremos revisar tambien que el estatus de la orden sea no pagada
        $order = factory(Order::class)->create(['total' => 20000]);

        $response = $this->json('POST', "/pay", [
            'order_id' => $order->id,
            'payment_token' => 'invalid-payment-token',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, $this->paymentGateway->totalCharges());
    }
}
