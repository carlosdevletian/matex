<?php

namespace Tests\Feature;

use App\Models\Design;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use App\Models\RegisterToken;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ViewOrderTest extends TestCase
{
    use DatabaseMigrations;

    private function createOrder($user = null, $email = null)
    {
        $design = factory(Design::class)->create(['image_name' => 'test_filename.jpg']);
        $product = factory(Product::class)->create(['name' => 'small bracelet']);
        $order = factory(Order::class)->states(['for-user', 'active'])->create(['user_id' => $user, 'email' => $email]);

        $item = Item::create([
            'order_id' => $order->id,
            'design_id' => $design->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'total_price' => 4000
         ]);

        return $order;
    }

    /** @test */
    function user_can_view_their_own_order()
    {
        $user = factory(User::class)->create();
        $order = $this->createOrder($user->id);

        $response = $this->actingAs($user)->json('GET','/orders/'.$order->reference_number);

        $response->assertStatus(200);
        $this->assertTrue($user->hasOrder($order));
    }

    /** @test */
    function user_cannot_view_others_order()
    {
        $this->withExceptionHandling();
        $user1 = factory(User::class)->create();
        $order = $this->createOrder($user1->id);

        $user2 = factory(User::class)->create();

        $response = $this->actingAs($user2)->json('GET','/orders/'.$order->reference_number);

        $response->assertStatus(403);
    }

    /** @test */
    function admin_can_view_user_order()
    {
        $user = factory(User::class)->states('user')->create();
        $order = $this->createOrder($user->id);

        $admin = factory(User::class)->states('admin')->create();

        $response = $this->actingAs($admin)->json('GET','/orders/'.$order->reference_number);

        $response->assertStatus(200);
    }

    /** @test */
    function guest_cannot_view_a_users_order()
    {
        $this->withExceptionHandling();
        $user = factory(User::class)->states('user')->create();
        $order = $this->createOrder($user->id);

        $response = $this->json('GET','/orders/'.$order->reference_number);

        $response->assertStatus(403);
    }

    /** @test */
    function a_guest_can_view_their_order_only_with_their_token()
    {
        $this->withExceptionHandling();
        $order = $this->createOrder(null, 'guest@mail.com');
        $token = RegisterToken::generateFor('guest@mail.com');

        $this->json('GET',"/orders/{$order->reference_number}/{$token}")
            ->assertStatus(200);

        $this->json('GET',"/orders/{$order->reference_number}")
            ->assertStatus(403);
    }

    /** @test */
    function a_user_cannot_view_a_guests_order()
    {
        $this->withExceptionHandling();
        $this->signIn();
        $order = $this->createOrder(null, 'guest@mail.com');

        $this->json('GET',"/orders/{$order->reference_number}")
            ->assertStatus(403);
    }
}
