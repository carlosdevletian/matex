<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Design;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    function it_generates_new_items_from_request_data()
    {
       $newItems = factory(Item::class, 3)->make();

       $items = Item::generate($newItems->toArray());

       $this->assertEquals(3, Item::count());
    }

    /** @test */
    function it_creates_new_items_from_request_data_for_a_given_design()
    {
       $requestData = factory(Item::class, 3)->make(['quantity' => 10]);
       $design = factory(Design::class)->create(['id' => 99]);

       $items = Item::generate($requestData->toArray(), $design);

       $this->assertEquals($items->first()->design_id, 99);
       $this->assertEquals(3, Item::count());
    }

    /** @test */
    function it_does_not_create_new_items_if_items_already_exist()
    {
        $existingItem = factory(Item::class)->create(['id' => 99]);

        $requestData = collect([
            $existingItem
        ]);

        $items = Item::generate($requestData->toArray());

        $this->assertEquals(1, Item::count());
        $this->assertEquals(99, Item::first()->id);
    }

    /** @test */
    function it_only_generates_items_with_a_valid_quantity()
    {
        $invalidItem1 = factory(Item::class)->make(['quantity' => -1]);
        $validItem = factory(Item::class)->make(['quantity' => 10]);
        $invalidItem2 = factory(Item::class)->make(['quantity' => 0]);

        $requestData = collect(
            [$invalidItem1,$validItem, $invalidItem2]
        );

        $items = Item::generate($requestData->toArray());

        $this->assertEquals(1, Item::count());
        $this->assertEquals(1, $items->count());
        $this->assertEquals(10, Item::first()->quantity);
    }

    /** @test */
    function it_correctly_asigns_all_fields_to_items_excluding_loaded_relationships()
    {
        $product = factory(Product::class)->create();
        $validItem = factory(Item::class)->make([
            'quantity' => 10,
            'unit_price' => 10,
            'product_id' => $product->id
        ]);

        $requestData = collect([$validItem->load('product')]);

        $items = Item::generate($requestData->toArray());

        $this->assertEquals(1, Item::count());
        $this->assertEquals(1, $items->count());
        $this->assertEquals(10, Item::first()->quantity);
    }
}
