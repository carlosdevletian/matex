<?php

namespace Tests\Unit\Models;

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

    /** @test */
    function a_cart_is_created_when_a_user_is_created()
    {
        $user = factory(User::class)->create();
        $this->assertNotNull($user->cart);
    }

    /** @test */
    function a_cart_is_not_created_when_an_admin_is_created()
    {
        $user = factory(User::class)->states('admin')->create();
        $this->assertNull($user->cart);
    }

    /** @test */
    function a_cart_is_not_created_when_an_owner_is_created()
    {
        $user = factory(User::class)->states('owner')->create();
        $this->assertNull($user->cart);
    }
}
