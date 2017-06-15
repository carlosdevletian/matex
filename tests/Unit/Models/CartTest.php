<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use PHPUnit\Framework\Assert;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CartTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        Collection::macro('assertContains', function($value) {
            Assert::assertTrue(
                $this->contains($value),
                'Failed asserting that the collection contained the specified value'
            );
        });

        Collection::macro('assertNotContains', function($value) {
            Assert::assertFalse(
                $this->contains($value),
                'Failed asserting that the collection did not contain the specified value'
            );
        });
    }

    /** @test */
    function it_adds_calculates_order_total()
    {
        $user = factory(User::class)->create();

        $item1 = factory(Item::class)->create(['total_price' => 100, 'cart_id' => $user->cart->id]);
        $item2 = factory(Item::class)->create(['total_price' => 200, 'cart_id' => $user->cart->id]);
        $item3 = factory(Item::class)->create(['total_price' => 300, 'cart_id' => $user->cart->id]);

        $total = $user->cart->orderTotal();

        $this->assertEquals(600, $total);
    }

    /** @test */
    function a_cart_is_created_when_a_user_is_created()
    {
        $user = factory(User::class)->create();
        $this->assertNotNull($user->cart);
    }

    /** @test */
    function a_cart_is_not_created_when_an_admin_is_created()
    {
        $user = factory(User::class)->states('admin')->create();
        $this->assertNull($user->cart);
    }

    /** @test */
    function a_cart_is_not_created_when_an_owner_is_created()
    {
        $user = factory(User::class)->states('owner')->create();
        $this->assertNull($user->cart);
    }

    /** @test */
    public function a_cart_can_determine_all_the_categories_it_has()
    {
        $cart = factory(Cart::class)->create();
        $categoryA = factory(Category::class)->create();
        $productA = factory(Product::class)->create(['category_id' => $categoryA->id]);
        $categoryB = factory(Category::class)->create();
        $productB = factory(Product::class)->create(['category_id' => $categoryB->id]);
        $categoryC = factory(Category::class)->create();
        $productC = factory(Product::class)->create(['category_id' => $categoryC->id]);

        $itemA = factory(Item::class)->create([
                    'product_id' => $productA->id,
                    'cart_id' => $cart->id,
                ]);
        $itemB = factory(Item::class)->create([
                    'product_id' => $productB->id,
                    'cart_id' => 99
                ]);
        $itemC = factory(Item::class)->create([
                    'product_id' => $productC->id,
                    'cart_id' => $cart->id
                ]);

        $cart->categories()->assertContains($categoryA);

        $cart->categories()->assertContains($categoryC);

        $cart->categories()->assertNotContains($categoryB);
    }
}
