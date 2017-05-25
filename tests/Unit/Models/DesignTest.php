<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DesignTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_all_preexisting_designs()
    {
        $preexisting = factory(Design::class)->create([
            'is_predesigned' => true,
        ]);
        $regular = factory(Design::class)->create([
            'is_predesigned' => false,
        ]);

        $queried = Design::preexisting()->get();

        $this->assertEquals($queried->first()->id, $preexisting->id);
    }

    /** @test */
    function can_get_all_designs_where_category_is_active()
    {
        $activeCategory = tap(factory(Category::class)->create(), function($category) {
            factory(Product::class)->create(['category_id' => $category->id]);
            $category->enable();
        });
        $inactiveCategory = factory(Category::class)->create(['is_active' => false]);

        $activeDesign = factory(Design::class)->create([
            'category_id' => $activeCategory->id,
        ]);
        $inactiveDesign = factory(Design::class)->create([
            'category_id' => $inactiveCategory->id,
        ]);

        $queried = Design::categoryActive()->get();

        $this->assertEquals(1, $queried->count());
        $this->assertEquals($queried->first()->id, $activeDesign->id);
    }

    /** @test */
    function can_filter_designs_by_active_category_and_take_limited_amount_from_each_category()
    {
        $category1 = tap(factory(Category::class)->create(['name' => 'category1']), function($category) {
            factory(Product::class)->create(['category_id' => $category->id]);
            $category->enable();
        });
        $category2 = tap(factory(Category::class)->create(['name' => 'category2']), function($category) {
            factory(Product::class)->create(['category_id' => $category->id]);
            $category->enable();
        });
        $inactiveCategory = factory(Category::class)->create(['name' => 'inactive','is_active' => false]);

        $designsForCategory1 = factory(Design::class, 6)->create([
            'category_id' => $category1->id,
            'is_predesigned' => true
        ]);
        $designsForCategory2 = factory(Design::class, 6)->create([
            'category_id' => $category2->id,
            'is_predesigned' => true
        ]);
        $inactiveDesign = factory(Design::class)->create([
            'category_id' => $inactiveCategory->id,
        ]);

        $queried = Design::selectForShop(5);

        $this->assertArrayHasKey('category1', $queried);
        $this->assertEquals(5, $queried['category1']->count());
        $this->assertArrayHasKey('category2', $queried);
        $this->assertEquals(5, $queried['category2']->count());
        $this->assertArrayNotHasKey('inactive', $queried);
    }
}
