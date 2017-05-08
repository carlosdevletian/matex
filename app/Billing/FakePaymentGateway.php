<?php

namespace App\Billing;

class FakePaymentGateway implements PaymentGateway
{
    const TEST_CARD_NUMBER = '4242424242424242';
    private $charges;
    private $tokens;

    function __construct()
    {
        $this->charges = collect();
        $this->tokens = collect();
    }
    public function getValidTestToken($cardNumber = self::TEST_CARD_NUMBER)
    {
        $token = 'fake-tok_'.str_random(24);
        $this->tokens[$token] = $cardNumber;
        return $token;
    }

    public function charge($amount, $token)
    {
        if(! $this->tokens->has($token)) {
            throw new PaymentFailedException;
        }
        return $this->charges[] = new Charge([
             'amount' => $amount,
             'card_last_four' => substr($this->tokens[$token], -4)
        ]);
    }

    public function newChargesDuring($callback)
    {
        $chargesFrom = $this->charges->count();
        $callback($this);
        return $this->charges->slice($chargesFrom)->reverse()->values();
    }

    public function totalCharges()
    {
        return $this->charges->map->amount()->sum();
    }
}