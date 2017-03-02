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
        $category = factory(Category::class)->create(['name' => 'Bracelets']);
        $category2 = factory(Category::class)->create(['name' => 'Calendars']);

        $response = $this->actingAs($user)->json('GET','/categories');

        $response->assertSee('Bracelets');
        $response->assertSee('Calendars');
    }

    /** @test */
    function design_page_has_category()
    {
        $category = factory(Category::class)->create(['name' => 'Bracelets']);

        $response = $this->json('GET',"/categories/{$category->id}/designs/create");

        $response->assertSee('Bracelets');
    }
}
