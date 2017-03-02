<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Billing\StripePaymentGateway;

/**
 * @group integration
 */
class StripePaymentGatewayTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->lastCharge = $this->lastCharge();
    }

    private function lastCharge()
    {
        return \Stripe\Charge::all(
            ['limit' => 1],
            ['api_key' => config('services.stripe.secret')]
        )['data'][0];
    }

    private function newCharges()
    {
        return \Stripe\Charge::all(
            [
                'limit' => 1,
                'ending_before' => $this->lastCharge->id
            ],
            ['api_key' => config('services.stripe.secret')]
        )['data'];
    }

    private function validToken()
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => config('services.stripe.secret')])->id;
    }

    /** @test */
    function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = new StripePaymentGateway(config('services.stripe.secret'));

        $token = $this->validToken();

        $paymentGateway->charge(2500, $token);

        $this->assertCount(1, $this->newCharges());
        $this->assertEquals(2500, $this->lastCharge()->amount);
    }
}
