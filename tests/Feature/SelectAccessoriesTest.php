<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SelectAccessoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function can_select_from_all_active_accessories_for_a_given_category()
    {
        $category = factory('App\Models\Category')->create();
        $activeAccessory = factory('App\Models\Accessory')->create([
            'name' => 'hook',
            'category_id' => $category->id,
            'is_active' => true
        ]);
        $inactiveAccessory = factory('App\Models\Accessory')->create([
            'name' => 'clamp',
            'category_id' => $category->id,
            'is_active' => false
        ]);

        $response = $this->get(route('category-accessories.index', $category));

        $response->assertStatus(200);
        $response->assertSee('hook');
        $response->assertDontSee('clamp');
    }
}
