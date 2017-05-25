<?php

namespace App\Http\Controllers;

use App\Models\Design;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop.index', [
            'categories' => Design::selectForShop(4)
        ]);
    }
}
