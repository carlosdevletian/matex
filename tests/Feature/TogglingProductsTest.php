<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\Order;
use App\Models\Status;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TogglingProductsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        factory(Status::class)->create(['name' => 'unpaid', 'id' => 1]);
        factory(Status::class)->create(['name' => 'paid', 'id' => 2]);
    }

    /** @test */
    public function unpaid_items_are_made_unavailable_when_products_are_disabled()
    {
        $this->createProduct('available');
        $unpaidOrder = factory(Order::class)->states('for-guest')->create(['status_id' => 1]);
        $paidOrder = factory(Order::class)->states('for-guest')->create(['status_id' => 2]);
        $paidItem = factory(Item::class)->create([
            'order_id' => $paidOrder->id,
            'product_id' => $this->product->id,
            'available' => 1
        ]);
        $unpaidItem = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'product_id' => $this->product->id,
            'available' => 1
        ]);
        $this->category->updateProducts(
            $this->setProduct('unavailable')
        );

        $this->assertEquals(1, $paidItem->fresh()->available);
        $this->assertEquals(0, $unpaidItem->fresh()->available);
    }

    /** @test */
    public function unpaid_items_are_made_available_when_products_are_enabled()
    {
        $this->createProduct('unavailable');
        $unpaidOrder = factory(Order::class)->states('for-guest')->create(['status_id' => 1]);
        $unpaidItem = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'product_id' => $this->product->id,
            'available' => 0
        ]);

        $this->category->updateProducts(
            $this->setProduct('available')
        );

        $this->assertEquals(1, $unpaidItem->fresh()->available);
    }

    /** @test */
    public function items_in_carts_are_made_unavailable_when_products_are_disabled()
    {
        $this->createProduct('available');
        $cartItem = factory(Item::class)->create([
            'order_id' => null, 
            'cart_id' => 1, 
            'product_id' => $this->product->id,
            'available' => 1
        ]);

        $this->category->updateProducts(
            $this->setProduct('unavailable')
        );

        $this->assertEquals(0, $cartItem->fresh()->available);
    }

    /** @test */
    public function items_in_carts_are_made_available_when_products_are_enabled()
    {
        $this->createProduct('unavailable');
        $cartItem = factory(Item::class)->create([
            'order_id' => null, 
            'cart_id' => 1, 
            'product_id' => $this->product->id,
            'available' => 0
        ]);

        $this->category->updateProducts(
            $this->setProduct('available')
        );

        $this->assertEquals(1, $cartItem->fresh()->available);
    }

    /** @test */
    public function an_order_is_canceled_when_all_its_items_are_unavailable()
    {
        $this->createProduct('available');
        $unpaidOrder = factory(Order::class)->states('for-guest')->create(['status_id' => 1]);
        $unpaidItem = factory(Item::class, 2)->create([
            'order_id' => $unpaidOrder->id,
            'product_id' => $this->product->id,
            'available' => 1
        ]);

        $this->category->updateProducts(
            $this->setProduct('unavailable')
        );

        $this->assertTrue($unpaidOrder->fresh()->isCanceled());
    }

    /** @test */
    public function an_order_is_not_canceled_when_some_items_are_unavailable()
    {
        $this->createProduct('available');
        $anotherProduct = factory(Product::class)->create([
            'category_id' => $this->category->id, 
            'is_active' => 1
        ]);

        $unpaidOrder = factory(Order::class)->states('for-guest')->create(['status_id' => 1]);
        $item1 = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'product_id' => $this->product->id,
            'available' => 1
        ]);
        $item2 = factory(Item::class)->create([
            'order_id' => $unpaidOrder->id,
            'product_id' => $anotherProduct->id,
            'available' => 1
        ]);

        $this->category->updateProducts([
            'id' => ['1', '2'],
            'name' => ['Small', 'Large'],
            'width' => ['200', '200'],
            'length' => ['200', '200'],
            'active' => ['1', '0']
        ]);

        $this->assertEquals(1, $item1->fresh()->available);
        $this->assertEquals(0, $item2->fresh()->available);
        $this->assertFalse($unpaidOrder->fresh()->isCanceled());
    }

    private function createProduct($is_active)
    {
        $is_active = $this->validateParameter($is_active);
        $this->category = factory(Category::class)->create();
        $this->product = factory(Product::class)->create(['category_id' => $this->category->id, 'is_active' => $is_active]);
    }

    private function setProduct($is_active)
    {
        $is_active = $this->validateParameter($is_active);
        return [
            'id' => [$this->product->id],
            'name' => [$this->product->name],
            'width' => [$this->product->width],
            'length' => [$this->product->length],
            'active' => [$is_active]
        ];
    }

    private function validateParameter($is_active)
    {
        switch ($is_active) {
            case 'available':
                return 1;
                break;
            case 'unavailable':
                return 0;
                break;
            default:
                $this->fail("Invalid parameter '{$is_active}' passed to function");
                break;
        }
    }
}
