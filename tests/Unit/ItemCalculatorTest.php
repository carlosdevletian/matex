<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\ItemCalculator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Accessory;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ItemCalculatorTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        factory(\App\Models\CurrencyRate::class)->create(['currency_code' => 'cop', 'to_dollar' => 2]);
    }

    /** @test */
    public function it_gets_a_base_price_from_its_category_based_on_quantity()
    {
        $category = factory(Category::class)->create();
        $correctPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $incorrectPricing = factory(Pricing::class)->create([
            'min_quantity' => 200,
            'unit_price' => 110,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 100,
            'product_id' => $product->id
        ]);

        $basePrice = (new ItemCalculator($item))->productPrice()->getCalculatedPrice();

        $this->assertEquals(130, $basePrice);
    }

    /** @test */
    public function the_quantity_corresponds_to_a_pricings_min_quantity()
    {
        $category = factory(Category::class)->create();
        $correctPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $incorrectPricing = factory(Pricing::class)->create([
            'min_quantity' => 200,
            'unit_price' => 110,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 200,
            'product_id' => $product->id
        ]);

        $basePrice = (new ItemCalculator($item))->productPrice()->getCalculatedPrice();

        $this->assertEquals(110, $basePrice);
    }

    /** @test */
    public function it_calculates_the_price_correctly()
    {
        $accessory = factory(Accessory::class)->create(['price' => 15]);
        $category = factory(Category::class)->create();
        $correctPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $incorrectPricing = factory(Pricing::class)->create([
            'min_quantity' => 200,
            'unit_price' => 110,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 100,
            'unit_price' => 0,
            'total_price' => 0,
            'accessory_id' => $accessory->id,
            'product_id' => $product->id
        ]);

        $item = (new ItemCalculator($item))->calculate();

        $this->assertEquals(290, $item->unit_price);
        $this->assertEquals(29000, $item->total_price);
    }

    /** @test */
    public function the_items_quantity_is_lower_than_the_minimum_quantity()
    {
        $category = factory(Category::class)->create();
        $lowestQuantityPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 49,
            'unit_price' => 0,
            'total_price' => 0,
            'accessory_id' => '',
            'product_id' => $product->id
        ]);

        $item = (new ItemCalculator($item))->calculate();

        $this->assertEquals(50, $item->quantity);
        $this->assertEquals(260, $item->unit_price);
    }

    /** @test */
    public function the_items_quantity_is_higher_than_the_pricing_with_highest_min_quantity()
    {
        $category = factory(Category::class)->create();
        $lowestQuantityPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $highestQuantityPricing = factory(Pricing::class)->create([
            'min_quantity' => 100,
            'unit_price' => 90,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 200,
            'unit_price' => 0,
            'total_price' => 0,
            'accessory_id' => '',
            'product_id' => $product->id
        ]);

        $basePrice = (new ItemCalculator($item))->productPrice()->getCalculatedPrice();

        $this->assertEquals(90, $basePrice);
    }

    /** @test */
    public function an_items_accessorys_price_is_taken_into_account()
    {
        $accessory = factory(Accessory::class)->create(['price' => 999]);
        $item = factory(Item::class)->create(['accessory_id' => $accessory->id]);

        $accessoryPrice = (new ItemCalculator($item))->accessoryPrice()->getCalculatedPrice();

        $this->assertEquals(999, $accessoryPrice);
    }
}
