<?php

namespace App\Billing;

use Stripe\Error\Base;
use Stripe\Error\Card;
use Stripe\Error\RateLimit;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;
use Stripe\Error\InvalidRequest;
use App\Billing\InvalidTokenException;
use App\Billing\PaymentFailedException;

class StripePaymentGateway implements PaymentGateway
{
    const TEST_CARD_NUMBER = '4242424242424242';
    private $apiKey;

    function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function charge($amount, $token)
    {
        try {
            $stripeCharge = \Stripe\Charge::create([
                'amount' => $amount,
                'source' => $token,
                'currency' => 'usd',
            ], ['api_key' => $this->apiKey]);

            return new Charge([
                'amount' => $stripeCharge['amount'],
                'card_last_four' => $stripeCharge['source']['last4']
            ]);
        } catch (Card $e) {
            $this->throwException($e);
        } catch (RateLimit $e) {
            $this->throwException($e);
        } catch (InvalidRequest $e) {
            $this->throwException($e);
        } catch (Authentication $e) {
            $this->throwException($e);
        } catch (ApiConnection $e) {
            $this->throwException($e);
        } catch (Base $e) {
            $this->throwException($e);
        }
    }

    public function getValidTestToken($cardNumber = self::TEST_CARD_NUMBER)
    {
        return \Stripe\Token::create([
            "card" => [
                "number" => $cardNumber,
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
        return $this->newChargesSince($latestCharge)->map(function($stripeCharge) {
            return new Charge([
                'amount' => $stripeCharge['amount'],
                'card_last_four' => $stripeCharge['source']['last4']
            ]);
        });
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

    private function throwException($e)
    {
        $error = $e->getJsonBody()['error'];
        if(! array_key_exists('charge', $error)) throw new InvalidTokenException ;

        $stripeCharge = \Stripe\Charge::retrieve(
            $error['charge'], 
            ['api_key' => $this->apiKey]
        );

        $charge = new Charge([
            'amount' => $stripeCharge['amount'],
            'card_last_four' => $stripeCharge['source']['last4']
        ]);
        throw new PaymentFailedException($charge);
    }
}
