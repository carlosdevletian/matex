<?php

namespace App\Billing;

class PaymentFailedException extends \RuntimeException 
{
    public $charge;
    
    function __construct($charge)
    {
        $this->charge = $charge;
    }
}