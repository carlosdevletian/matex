<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Accessory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TogglingAccessoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_admin_can_enable_an_accessory()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);
        $accessory = factory(Accessory::class)->create(['is_active' => false]);

        $response = $this->get(route('accessories.enable', $accessory));

        $response->assertStatus(200);
        $this->assertTrue($accessory->fresh()->isActive());
    }

    /** @test */
    public function an_admin_can_disable_an_accessory()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);
        $accessory = factory(Accessory::class)->create(['is_active' => true]);

        $response = $this->get(route('accessories.disable', $accessory));

        $response->assertStatus(200);
        $this->assertFalse($accessory->fresh()->isActive());
    }

    /** @test */
    public function a_regular_user_cannot_enable_an_accessory()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);
        $accessory = factory(Accessory::class)->create(['is_active' => false]);

        $response = $this->get(route('accessories.enable', $accessory));

        $response->assertRedirect(route('home'));
        $this->assertFalse($accessory->fresh()->isActive());
    }

    /** @test */
    public function a_regular_user_cannot_disbable_an_accessory()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);
        $accessory = factory(Accessory::class)->create(['is_active' => true]);

        $response = $this->get(route('accessories.disable', $accessory));

        $response->assertRedirect(route('home'));
        $this->assertTrue($accessory->fresh()->isActive());
    }

    /** @test */
    public function unpaid_items_are_made_unavailable_when_accessories_are_disabled()
    {
        $accessory = factory(Accessory::class)->create(['is_active' => true]);
        $unpaidOrder = factory(Order::class)->states(['for-guest', 'unpaid'])->create();
        $paidOrder = factory(Order::class)->states(['for-guest', 'paid'])->create();
        $paidItem = factory(Item::class)->create([
            'order_id' => $paidOrder->id,
            'accessory_id' => $accessory->id,
            'available' => 1
        ]);
        $unpaidItem = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'accessory_id' => $accessory->id,
            'available' => 1
        ]);

        $accessory->disable();

        $this->assertFalse($accessory->fresh()->isActive());
        $this->assertEquals(1, $paidItem->fresh()->available);
        $this->assertEquals(0, $unpaidItem->fresh()->available);
    }

    /** @test */
    public function unpaid_items_are_made_available_when_accessories_are_enabled()
    {
        $accessory = factory(Accessory::class)->create(['is_active' => true]);
        $unpaidOrder = factory(Order::class)->states(['for-guest', 'unpaid'])->create();
        $unpaidItem = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'accessory_id' => $accessory->id,
            'available' => 0
        ]);

        $accessory->enable();

        $this->assertEquals(1, $unpaidItem->fresh()->available);
    }

    /** @test */
    public function items_in_carts_are_made_unavailable_when_accessories_are_disabled()
    {
        $accessory = factory(Accessory::class)->create(['is_active' => true]);
        $cartItem = factory(Item::class)->create([
            'order_id' => null, 
            'cart_id' => 1, 
            'accessory_id' => $accessory->id,
            'available' => 1
        ]);

        $accessory->disable();

        $this->assertEquals(0, $cartItem->fresh()->available);
    }

    /** @test */
    public function items_in_carts_are_made_available_when_accessories_are_enabled()
    {
        $accessory = factory(Accessory::class)->create(['is_active' => false]);
        $cartItem = factory(Item::class)->create([
            'order_id' => null, 
            'cart_id' => 1, 
            'accessory_id' => $accessory->id,
            'available' => 0
        ]);

        $accessory->enable();

        $this->assertEquals(1, $cartItem->fresh()->available);
    }

    /** @test */
    public function an_order_is_canceled_when_all_its_items_accessories_are_unavailable()
    {
        $accessory = factory(Accessory::class)->create(['is_active' => true]);
        $unpaidOrder = factory(Order::class)->states(['for-guest', 'unpaid'])->create();
        $unpaidItem = factory(Item::class, 2)->create([
            'order_id' => $unpaidOrder->id,
            'accessory_id' => $accessory->id,
            'available' => 1
        ]);

        $accessory->disable();

        $this->assertTrue($unpaidOrder->fresh()->isCanceled());
    }

    /** @test */
    public function an_order_is_not_canceled_when_some_items_accessories_are_unavailable()
    {
        $accessory1 = factory(Accessory::class)->create(['is_active' => true]);
        $accessory2 = factory(Accessory::class)->create(['is_active' => true]);

        $unpaidOrder = factory(Order::class)->states(['for-guest', 'unpaid'])->create();
        $item1 = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'accessory_id' => $accessory1->id,
            'available' => 1
        ]);
        $item2 = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'accessory_id' => $accessory2->id,
            'available' => 1
        ]);

        $accessory2->disable();

        $this->assertEquals(1, $item1->fresh()->available);
        $this->assertEquals(0, $item2->fresh()->available);
        $this->assertFalse($unpaidOrder->fresh()->isCanceled());
    }
}
