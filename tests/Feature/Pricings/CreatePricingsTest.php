<?php

namespace Tests\Feature\Pricings;

use Tests\TestCase;
use App\Models\User;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreatePricingsTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'min_quantity' => 10,
            'max_quantity' => 99,
            'unit_price' => 130,
        ], $overrides);
    }

    /** @test */
    public function an_admin_can_add_a_pricing_to_a_category()
    {
        $this->signIn($this->admin);
        $category = factory('App\Models\Category')->create();

        $response = $this->post(route('pricings.store', ['category' => $category->id]), [
            'min_quantity' => 5,
            'max_quantity' => 199,
            'unit_price' => 150,
        ]);

        tap($category->pricings()->first(), function($pricing) use($category) {
            $this->assertEquals(5, $pricing->min_quantity);
            $this->assertEquals(199, $pricing->max_quantity);
            $this->assertEquals(150, $pricing->unit_price);
            $this->assertTrue($pricing->category->is($category));
        });
    }

    /** @test */
    public function a_guest_cannot_add_a_pricing_to_a_category()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->post(route('pricings.store', ['category' => $category->id]), $this->validParams());

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function min_quantity_is_required()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'min_quantity' => ''
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function min_quantity_must_be_an_integer()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'min_quantity' => 0.4
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function max_quantity_is_required()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'max_quantity' => ''
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('max_quantity');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function max_quantity_must_be_an_integer()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'max_quantity' => 0.4
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('max_quantity');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function unit_price_is_required()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'unit_price' => ''
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('unit_price');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function unit_price_must_be_an_integer()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'unit_price' => 0.4
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('unit_price');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function min_quantity_must_be_smaller_than_max_quantity()
    {
        $category = factory('App\Models\Category')->create();

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->post(route('pricings.store', ['category' => $category->id]), $this->validParams([
                        'min_quantity' => 100,
                        'max_quantity' => 50,
                    ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
        $this->assertEquals(0, Pricing::count());
    }

    /** @test */
    public function a_guest_cannot_delete_a_pricing()
    {
        $pricing = factory(Pricing::class)->create();

        $response = $this->delete(route('pricings.delete', ['pricing' => $pricing->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }   

    /** @test */
    public function an_admin_can_delete_a_pricing()
    {
        $pricing = factory(Pricing::class)->create();
        $this->assertDatabaseHas('category_pricings', ['id' => $pricing->id]);

        $response = $this->signIn($this->admin)
            ->delete(route('pricings.delete', ['pricing' => $pricing->id]));

        $this->assertDatabaseMissing('category_pricings', ['id' => $pricing->id]);
    }   
}
