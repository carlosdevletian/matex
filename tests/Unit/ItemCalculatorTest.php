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

    /** @test */
    public function it_gets_a_base_price_from_its_category_based_on_quantity()
    {
        $category = factory(Category::class)->create();
        $correctPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'max_quantity' => 199,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $incorrectPricing = factory(Pricing::class)->create([
            'min_quantity' => 200,
            'max_quantity' => 299,
            'unit_price' => 110,
            'category_id' => $category->id,
        ]);
        $product = factory(Product::class)->create(['category_id' => $category->id]);
        $item = factory(Item::class)->make([
            'quantity' => 100,
            'product_id' => $product->id
        ]);

        $basePrice = (new ItemCalculator($item))->basePrice()->getCalculatedPrice();

        $this->assertEquals(130, $basePrice);
    }

    /** @test */
    public function it_calculates_the_price_correctly()
    {
        $accessory = factory(Accessory::class)->create(['price' => 15]);
        $category = factory(Category::class)->create();
        $correctPricing = factory(Pricing::class)->create([
            'min_quantity' => 50,
            'max_quantity' => 199,
            'unit_price' => 130,
            'category_id' => $category->id,
        ]);
        $incorrectPricing = factory(Pricing::class)->create([
            'min_quantity' => 200,
            'max_quantity' => 299,
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

        // unit_price = 130 ($basePrice) + 15($accessoryPrice) = 145
        // total_price = 145*100 (unit_price * quantity)

        $this->assertEquals(145, $item->unit_price);
        $this->assertEquals(14500, $item->total_price);
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
