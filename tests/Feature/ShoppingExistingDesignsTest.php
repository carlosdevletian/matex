<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Design;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShoppingExistingDesignsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function getting_preexisting_designs_for_active_categories()
    {
        $product = factory(Product::class)->create();
        $product->category->enable();
        $preexistingDesigns = factory(Design::class)->create([
            'is_predesigned' => true,
            'image_name' => 'should-show.png',
            'category_id' => $product->category->id,
        ]);
        $regularDesigns = factory(Design::class)->create([
            'is_predesigned' => false,
            'category_id' => $product->category->id,
            'image_name' => 'should-not-show.png'
        ]);

        $response = $this->get('/shop');

        $response->assertStatus(200);
        $response->assertSee('should-show.png');
        $response->assertDontSee('should-not-show.png');
    }

    /** @test */
    public function getting_all_preexisting_designs_for_a_given_category()
    {
        $product = factory(Product::class)->create();
        $product->category->enable();
        $preexistingDesigns = factory(Design::class)->create([
            'is_predesigned' => true,
            'image_name' => 'should-show.png',
            'category_id' => $product->category->id,
        ]);
        $regularDesigns = factory(Design::class)->create([
            'is_predesigned' => false,
            'category_id' => $product->category->id,
            'image_name' => 'should-not-show.png'
        ]);

        $response = $this->get(route('shop-category.index', $product->category->slug_name));

        $response->assertStatus(200);
        $response->assertSee('should-show.png');
        $response->assertDontSee('should-not-show.png');
    }
}
