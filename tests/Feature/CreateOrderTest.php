<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateOrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_categories()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['name' => 'Bracelet', 'is_active' => 1]);
        $product = factory(Product::class)->create(['category_id' => $category->id, 'is_active' => 1]);
        $category2 = factory(Category::class)->create(['name' => 'Calendar', 'is_active' => 1]);
        $product = factory(Product::class)->create(['category_id' => $category2->id, 'is_active' => 1]);

        $response = $this->actingAs($user)->json('GET','/categories');

        $response->assertSee('bracelet');
        $response->assertSee('calendar');
    }

    /** @test */
    function design_page_has_category()
    {
        $category = factory(Category::class)->create(['name' => 'Bracelet', 'is_active' => 1]);
        $product = factory(Product::class)->create(['category_id' => $category->id, 'is_active' => 1]);

        $response = $this->json('GET',"/design/{$category->slug_name}");

        $response->assertSee('bracelet');
    }
}
