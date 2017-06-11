<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_category_has_pricings()
    {
        $category = factory('App\Models\Category')->create();
        $pricing = factory('App\Models\CategoryPricing')->create([
            'category_id' => $category->id
        ]);

        $this->assertCount(1, $category->pricings);
        $this->assertInstanceOf('App\Models\CategoryPricing', $category->pricings->first());
    }
}
