<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    function it_adds_calculates_order_total()
    {
        $user = factory(User::class)->create();
        $cart = factory(Cart::class)->create(['user_id' => $user->id]);

        $item1 = factory(Item::class)->create(['cart_id' => $cart->id,'total_price' => 100]);
        $item2 = factory(Item::class)->create(['total_price' => 200, 'cart_id' => $cart->id]);
        $item3 = factory(Item::class)->create(['total_price' => 300, 'cart_id' => $cart->id]);

        $total = $cart->orderTotal();

        $this->assertEquals(600, $total);
    }
}
