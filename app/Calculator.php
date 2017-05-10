<?php

namespace App;

class Calculator
{
    public function shipping($zipCode)
    {
        return 1100;
    }

    public function tax($zipCode)
    {
        return 0.10;
    }
}
