<?php

use App\Models\User;
use App\Models\Design;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CreateOrderTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function user_can_view_categories()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create(['name' => 'Bracelets']);
        $category2 = factory(Category::class)->create(['name' => 'Calendars']);

        $this->actingAs($user)
             ->json('GET','/categories');

        $this->see('Bracelets');
        $this->see('Calendars');
    }

    /** @test */
    function design_page_has_category()
    {
        $category = factory(Category::class)->create(['name' => 'Bracelets']);

        $this->json('GET',"/categories/{$category->id}/designs/create");

        $this->see('Bracelets');
    }

    /** @test */
    function view_products_for_design()
    {
        $category = factory(Category::class)->create(['name' => 'Bracelets']);
        $design = factory(Design::class)->create(['image_name' => 'test_filename.jpg']);
        $product = factory(Product::class)->create(['name' => 'small bracelet', 'category_id' => $category->id]);
        $product2 = factory(Product::class)->create(['name' => 'medium bracelet', 'category_id' => $category->id]);

        $this->json('GET', "categories/{$category->id}/designs/{$design->id}/products/select");

        $this->see('Bracelets');
        $this->see('test_filename.jpg');
        $this->see('small bracelet');
        $this->see('medium bracelet');
    }
}
