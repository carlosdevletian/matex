<?php

namespace Tests\Feature\Pricings;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditPricingTest extends TestCase
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
    public function an_admin_can_edit_several_pricings_at_once()
    {
        $pricingA = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'max_quantity' => 19,
            'unit_price' => 130,
        ]);
        $pricingB = factory(Pricing::class)->create([
            'min_quantity' => 20,
            'max_quantity' => 29,
            'unit_price' => 110,
        ]);
        $pricingC = factory(Pricing::class)->create([
            'min_quantity' => 30,
            'max_quantity' => 39,
            'unit_price' => 90,
        ]);

        $response = $this->signIn($this->admin)
            ->put(route('pricings.update'), [
                'pricings' => [
                    $pricingA->id => [
                        'min_quantity' => 100,
                        'max_quantity' => 199,
                        'unit_price' => 50
                    ],
                    $pricingB->id => [
                        'min_quantity' => 200,
                        'max_quantity' => 299,
                        'unit_price' => 30
                    ],
                    $pricingC->id => [
                        'min_quantity' => 300,
                        'max_quantity' => 399,
                        'unit_price' => 10
                    ],
                ]
            ]);

        tap($pricingA->fresh(), function($A) {
            $this->assertEquals(100, $A->min_quantity);
            $this->assertEquals(199, $A->max_quantity);
            $this->assertEquals(50, $A->unit_price);
        });
        tap($pricingB->fresh(), function($B) {
            $this->assertEquals(200, $B->min_quantity);
            $this->assertEquals(299, $B->max_quantity);
            $this->assertEquals(30, $B->unit_price);
        });
        tap($pricingC->fresh(), function($C) {
            $this->assertEquals(300, $C->min_quantity);
            $this->assertEquals(399, $C->max_quantity);
            $this->assertEquals(10, $C->unit_price);
        });
    }

    /** @test */
    public function a_guest_cannot_edit_pricings()
    {
        $pricing = factory(Pricing::class)->create([
            'min_quantity' => 5
        ]);

        $response = $this->put(route('pricings.update', ['pricing' => $pricing->id]), $this->validParams());
                    
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    /** @test */
    public function each_updating_pricing_must_have_a_minimum_quantity()
    {
        $pricingA = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'max_quantity' => 19,
            'unit_price' => 130,
        ]);

        $response = $this->withExceptionHandling()
            ->signIn($this->admin)
            ->put(route('pricings.update'), [
                'pricings' => [
                    $pricingA->id => [
                        'min_quantity' => '',
                        'max_quantity' => 199,
                        'unit_price' => 50
                    ],
                ]
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
    }

    /** @test */
    public function each_updating_pricing_must_have_a_maximum_quantity()
    {
        $pricingA = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'max_quantity' => 19,
            'unit_price' => 130,
        ]);

        $response = $this->withExceptionHandling()
            ->signIn($this->admin)
            ->put(route('pricings.update'), [
                'pricings' => [
                    $pricingA->id => [
                        'min_quantity' => 100,
                        'max_quantity' => '',
                        'unit_price' => 50
                    ],
                ]
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('max_quantity');
    }

    /** @test */
    public function each_updating_pricing_must_have_a_unit_price()
    {
        $pricingA = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'max_quantity' => 19,
            'unit_price' => 130,
        ]);

        $response = $this->withExceptionHandling()
            ->signIn($this->admin)
            ->put(route('pricings.update'), [
                'pricings' => [
                    $pricingA->id => [
                        'min_quantity' => 100,
                        'max_quantity' => 199,
                        'unit_price' => ''
                    ],
                ]
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('unit_price');
    }
}
