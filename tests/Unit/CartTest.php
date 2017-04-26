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

        $item1 = factory(Item::class)->create(['total_price' => 100, 'cart_id' => $user->cart->id]);
        $item2 = factory(Item::class)->create(['total_price' => 200, 'cart_id' => $user->cart->id]);
        $item3 = factory(Item::class)->create(['total_price' => 300, 'cart_id' => $user->cart->id]);

        $total = $user->cart->orderTotal();

        $this->assertEquals(600, $total);
    }
}
