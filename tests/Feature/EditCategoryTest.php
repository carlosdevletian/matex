<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EditCategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function regular_users_may_not_edit_a_category()
    {
        $this->signIn();
        $category = factory('App\Models\Category')->create();

        $response = $this->put("/categories/{$category->id}", [
            'some' => 'data'
        ]);

        $response->assertRedirect('/');
    }

    /** @test */
    public function it_updates_an_existing_category()
    {
        $this->signInAdmin();

        $this->post('');

    }
}
