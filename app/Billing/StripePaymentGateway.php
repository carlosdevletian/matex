<?php

namespace App\Billing;

use Stripe\Charge;
use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\RateLimit;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\InvalidRequest;
use App\Billing\PaymentFailedException;

class StripePaymentGateway implements PaymentGateway
{
    private $apiKey;

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function charge($amount, $token)
    {
        try {
            Charge::create([
                'amount' => $amount,
                'source' => $token,
                'currency' => 'usd',
            ], ['api_key' => $this->apiKey]);
        } catch (Card $e) {
            throw new PaymentFailedException;
        } catch (RateLimit $e) {
            throw new PaymentFailedException;
        } catch (InvalidRequest $e) {
            throw new PaymentFailedException;
        } catch (Authentication $e) {
            throw new PaymentFailedException;
        } catch (ApiConnection $e) {
            throw new PaymentFailedException;
        } catch (Base $e) {
            throw new PaymentFailedException;
        }
    }

    public function getValidTestToken()
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => "4242424242424242",
                "exp_month" => 1,
                "exp_year" => date('Y') + 1,
                "cvc" => "123"
            ]
        ], ['api_key' => $this->apiKey])->id;
    }

    public function newChargesDuring($callback)
    {
        $latestCharge = $this->lastCharge();
        $callback($this);
        return $this->newChargesSince($latestCharge)->pluck('amount');
    }

    private function lastCharge()
    {
        return \Stripe\Charge::all(
            ['limit' => 1],
            ['api_key' => $this->apiKey]
        )['data'][0];
    }

    private function newChargesSince($charge = null)
    {
        $newCharges = \Stripe\Charge::all(
            [
                'ending_before' => $charge ? $charge->id : null,
            ],
            ['api_key' => $this->apiKey]
        )['data'];

        return collect($newCharges);
    }
}
