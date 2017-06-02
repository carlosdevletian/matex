<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Accessory;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TogglingAccessoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_admin_can_enable_an_accessory()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);
        $accessory = factory(Accessory::class)->create(['is_active' => false]);

        $response = $this->get(route('accessories.enable', $accessory));

        $response->assertStatus(200);
        $this->assertTrue($accessory->fresh()->isActive());
    }

    /** @test */
    public function an_admin_can_disable_an_accessory()
    {
        $admin = factory(User::class)->states('admin')->create();
        $this->signIn($admin);
        $accessory = factory(Accessory::class)->create(['is_active' => true]);

        $response = $this->get(route('accessories.disable', $accessory));

        $response->assertStatus(200);
        $this->assertFalse($accessory->fresh()->isActive());
    }

    /** @test */
    public function a_regular_user_cannot_enable_an_accessory()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);
        $accessory = factory(Accessory::class)->create(['is_active' => false]);

        $response = $this->get(route('accessories.enable', $accessory));

        $response->assertRedirect(route('home'));
        $this->assertFalse($accessory->fresh()->isActive());
    }

    /** @test */
    public function a_regular_user_cannot_disbable_an_accessory()
    {
        $user = factory(User::class)->create();
        $this->signIn($user);
        $accessory = factory(Accessory::class)->create(['is_active' => true]);

        $response = $this->get(route('accessories.disable', $accessory));

        $response->assertRedirect(route('home'));
        $this->assertTrue($accessory->fresh()->isActive());
    }
}
