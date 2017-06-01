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
}
