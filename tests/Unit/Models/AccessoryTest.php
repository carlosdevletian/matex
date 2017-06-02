<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AccessoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_accessory_belongs_to_a_category()
    {
        $accessory = factory('App\Models\Accessory')->create();

        $this->assertInstanceOf('App\Models\Category', $accessory->category);
    }

    /** @test */
    public function an_accessory_can_be_assigned_to_an_item()
    {
        $item = factory('App\Models\Item')->create();

        $this->assertInstanceOf('App\Models\Accessory', $item->accessory);
    }

    /** @test */
    public function can_get_all_active_accessories_for_a_category()
    {
        $category = factory('App\Models\Category')->create();
        $activeAccessory = factory('App\Models\Accessory')->create([
            'name' => 'active',
            'is_active' => true,
            'category_id' => $category->id
        ]);
        $inactiveAccessory = factory('App\Models\Accessory')->create([
            'name' => 'not-active',
            'is_active' => false,
            'category_id' => $category->id
        ]);

        $results = $category->activeAccessories();

        $this->assertEquals(1, $results->count());
        $this->assertEquals('active', $results->first()->name);
    }

    /** @test */
    public function an_accessory_can_be_enabled()
    {
        $accessory = factory('App\Models\Accessory')->create([
            'is_active' => false,
        ]);
        $this->assertFalse($accessory->isActive());

        $accessory->enable();

        $this->assertTrue($accessory->isActive());
    }

    /** @test */
    public function an_accessory_can_be_disabled()
    {
        $accessory = factory('App\Models\Accessory')->create([
            'is_active' => true,
        ]);
        $this->assertTrue($accessory->isActive());

        $accessory->disable();

        $this->assertFalse($accessory->isActive());
    }
}
