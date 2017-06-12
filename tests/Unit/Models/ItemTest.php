<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use App\Models\Accessory;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();
        $category = factory(Category::class)->create();
        factory(Pricing::class)->create(['category_id' => $category->id, 'min_quantity' => 50, 'max_quantity' => 100]);
        $this->product = factory(Product::class)->create(['category_id' => $category->id]);
    }
    
    /** @test */
    function it_generates_new_items_from_request_data()
    {
        $newItems = factory(Item::class, 3)->make(['product_id' => $this->product->id, 'quantity' => 75]);

        $items = Item::generate($newItems->toArray());

        $this->assertEquals(3, Item::count());
    }

    /** @test */
    function it_creates_new_items_from_request_data_for_a_given_design()
    {
       $requestData = factory(Item::class, 3)->make([
            'product_id' => $this->product->id, 
            'quantity' => 75
        ]);
       $design = factory(Design::class)->create(['id' => 99]);

       $items = Item::generate($requestData->toArray(), $design);

       $this->assertEquals($items->first()->design_id, 99);
       $this->assertEquals(3, Item::count());
    }

    /** @test */
    function it_does_not_create_new_items_if_items_already_exist()
    {
        $existingItem = factory(Item::class)->create([
            'id' => 99,
            'product_id' => $this->product->id, 
            'quantity' => 75, 
        ]);

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
        $invalidItem1 = factory(Item::class)->make([
            'product_id' => $this->product->id, 
            'quantity' => -1, 
        ]);
        $validItem = factory(Item::class)->make([
            'product_id' => $this->product->id, 
            'quantity' => 75, 
        ]);
        $invalidItem2 = factory(Item::class)->make([
            'product_id' => $this->product->id, 
            'quantity' => 0, 
        ]);

        $requestData = collect(
            [$invalidItem1,$validItem, $invalidItem2]
        );

        $items = Item::generate($requestData->toArray());

        $this->assertEquals(1, Item::count());
        $this->assertEquals(1, $items->count());
        $this->assertEquals(75, Item::first()->quantity);
    }

    /** @test */
    function it_correctly_asigns_all_fields_to_items_excluding_loaded_relationships()
    {
        $design = factory(Design::class)->create();
        $accessory = factory(Accessory::class)->create();
        $validItem = factory(Item::class)->make([
            'quantity' => 75,
            'unit_price' => 10,
            'product_id' => $this->product->id,
            'design_id' => $design->id,
            'accessory_id' => $accessory->id
        ]);

        $requestData = collect([$validItem->load('product')]);

        $items = Item::generate($requestData->toArray());

        $this->assertEquals(1, Item::count());
        $this->assertEquals(1, $items->count());
        $this->assertEquals(75, Item::first()->quantity);
    }

    /** @test */
    public function an_item_has_pricings_associated_with_its_category()
    {
        $category = factory(Category::class)->create();
        $pricing = factory(Pricing::class)->create(['category_id' => $category->id]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Pricing::class, $item->pricings()->first());
    }
    
    /** @test */    
    public function an_items_minimum_quantity_is_the_minimum_quantity_of_the_lowest_associated_pricins()
    {
        $category = factory(Category::class)->create();
        $lowestPricing = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'max_quantity' => 99,
            'category_id' => $category->id
        ]);
        $highestPricing = factory(Pricing::class)->create([
            'min_quantity' => 100,
            'max_quantity' => 199,
            'category_id' => $category->id
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->create(['product_id' => $product->id]);

        $this->assertEquals(10, $item->minimumQuantity());
    }
}
