<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class OwnerTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_owners_can_view_admin_listing()
    {
        $this->get('/admins')->assertRedirect('/');

        $this->signIn(factory(User::class)->states('admin')->create());
        $this->get('/admins')->assertRedirect('/');

        $this->signIn(factory(User::class)->states('owner')->create());
        $this->get('/admins')->assertStatus(200);
    }

    /** @test */
    function only_owners_can_view_manage_admins()
    {
        $this->signIn(factory(User::class)->states('admin')->create());
        $this->get('/dashboard')->assertDontSee('Manage administrators');

        $this->signIn(factory(User::class)->states('owner')->create());
        $this->get('/dashboard')->assertSee('Manage administrators');
    }

    /** @test */
    function only_owners_can_view_delete_users()
    {
        $admin = factory(User::class)->states('admin')->create();
        
        $this->signIn($admin);
        $this->get("/users/{$admin->id}")->assertDontSee('Delete this administrator');

        $this->signIn(factory(User::class)->states('owner')->create());
        $this->get("/users/{$admin->id}")->assertSee('Delete this administrator');
    }

    /** @test */
    function owners_cannot_delete_other_owners()
    {
        $owner1 = factory(User::class)->states('owner')->create();
        $owner2 = factory(User::class)->states('owner')->create();

        $this->signIn($owner1);
        $this->get("/users/{$owner2->id}")->assertDontSee('Delete this administrator');
    }

    /** @test */
    function owners_cannot_delete_common_users()
    {
        $owner = factory(User::class)->states('owner')->create();
        $user = factory(User::class)->states('user')->create();

        $this->signIn($owner);
        $this->get("/users/{$user->id}")->assertDontSee('Delete this administrator');
    }

    /** @test */
    function owners_can_delete_admins()
    {
        $owner = factory(User::class)->states('owner')->create();
        $admin = factory(User::class)->states('admin')->create([
            'id' => 99
        ]);
        $this->assertDatabaseHas('users', ['id' => 99]);

        $this->signIn($owner);
        $this->delete("/admins/99");

        $this->assertDatabaseMissing('users', ['id' => 99]);
    }
}
