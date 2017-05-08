<?php 

namespace App;

class OrderReferenceNumber
{
    public function generate()
    {
        return uniqid();
    }
}