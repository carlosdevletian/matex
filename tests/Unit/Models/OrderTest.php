<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use App\Models\Address;
use Facades\App\OrderReferenceNumber;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function creating_an_order_from_items_and_address_for_a_guest()
    {
        $status = factory(Status::class)->create(['name' => 'Payment Pending']);
        $items = factory(Item::class, 3)->create(['total_price' => 1000, 'available' => true]);
        $address = factory(Address::class)->create(['email' => 'john@example.com']);
        OrderReferenceNumber::shouldReceive('generate')->andReturn('ORDERREFERENCENUMBER1234');

        $order = Order::forItems($items, $address); 

        $this->assertDatabaseHas('orders', [
            'user_id' => null,
            'email' => 'john@example.com',
            'address_id' => $address->id,
            'status_id' => $status->id,
            'reference_number' => 'ORDERREFERENCENUMBER1234',
            'subtotal' => 3000
        ]);
        $this->assertEquals(3, $order->items()->count());
    }

    /** @test */
    function creating_an_order_from_items_and_address_for_a_user()
    {
        $status = factory(Status::class)->create(['name' => 'Payment Pending']);
        $user = factory(User::class)->create(['email' => 'not-important@email.com']);
        $items = factory(Item::class, 3)->create(['total_price' => 1000, 'cart_id' => $user->cart->id]);
        $address = factory(Address::class)->create(['user_id' => $user->id]);
        OrderReferenceNumber::shouldReceive('generate')->andReturn('ORDERREFERENCENUMBER1234');

        $order = Order::forItems($items, $address); 

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'email' => null,
            'address_id' => $address->id,
            'status_id' => $status->id,
            'reference_number' => 'ORDERREFERENCENUMBER1234',
            'subtotal' => 3000
        ]);
        $this->assertEquals(3, $order->items()->count());
        $this->assertNull($items->first()->cart_id);
    }
}
