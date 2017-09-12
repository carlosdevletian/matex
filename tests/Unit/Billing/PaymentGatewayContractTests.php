<?php

namespace Tests\Unit\Billing;

use App\Billing\InvalidTokenException;

trait PaymentGatewayContractTests
{
    abstract protected function getPaymentGateway();

    /** @test */
    function charges_with_a_valid_payment_token_are_successful()
    {
        $paymentGateway = $this->getPaymentGateway();

        $newCharges = $paymentGateway->newChargesDuring(function($paymentGateway) {
            $paymentGateway->charge(2500000, $paymentGateway->getValidTestToken());
        });

        $this->assertCount(1, $newCharges);
        $this->assertEquals(2500000, $newCharges->map->amount()->sum());
    }

    /** @test */
    function can_get_details_about_a_successful_charge()
    {
        $paymentGateway = $this->getPaymentGateway();

        $charge = $paymentGateway->charge(2500000, $paymentGateway->getValidTestToken($paymentGateway::TEST_CARD_NUMBER));

        $this->assertEquals(substr($paymentGateway::TEST_CARD_NUMBER, -4), $charge->cardLastFour());
        $this->assertEquals(2500000, $charge->amount());
    }

    /** @test */
    function charges_with_an_invalid_payment_token_fail()
    {
        $paymentGateway = $this->getPaymentGateway();

        $newCharges = $paymentGateway->newChargesDuring(function($paymentGateway) {
            try {
                $paymentGateway->charge(2500000, 'invalid-payment-token');
            } catch (InvalidTokenException $e) {
                return;
            }

            $this->fail("Charging with an invalid payment token did not throw a InvalidTokenException");
        });

        $this->assertCount(0, $newCharges);
    }

    /** @test */
    function can_fetch_charges_created_during_a_callback()
    {
        $paymentGateway= $this->getPaymentGateway();
        $paymentGateway->charge(2000000, $paymentGateway->getValidTestToken());
        $paymentGateway->charge(3000000, $paymentGateway->getValidTestToken());

        $newCharges = $paymentGateway->newChargesDuring(function($paymentGateway) {
            $paymentGateway->charge(4000000, $paymentGateway->getValidTestToken());
            $paymentGateway->charge(5000000, $paymentGateway->getValidTestToken());
        });

        $this->assertCount(2, $newCharges);
        $this->assertEquals([5000000, 4000000], $newCharges->map->amount()->all());
    }
}