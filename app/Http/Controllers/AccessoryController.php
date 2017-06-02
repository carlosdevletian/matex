<?php

namespace App\Http\Controllers;

use App\Models\Accessory;
use Illuminate\Http\Request;

class AccessoryController extends Controller
{
    public function enable(Accessory $accessory)
    {
        return $accessory->enable();
    }

    public function disable(Accessory $accessory)
    {
        return $accessory->disable();
    }
}
