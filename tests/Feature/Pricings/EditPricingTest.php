<?php

namespace Tests\Feature\Pricings;

use Tests\TestCase;
use App\Models\User;
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
    public function min_quantity_is_required()
    {
        $pricing = factory(Pricing::class)->create([
            'min_quantity' => 5
        ]);

        $response = $this->signIn($this->admin)
            ->withExceptionHandling()
            ->put(route('pricings.update', ['pricing' => $pricing->id]), $this->validParams([
                'min_quantity' => ''
            ]));
                    
        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
        $this->assertEquals(5, $pricing->fresh()->min_quantity);
    }

    /** @test */
    public function min_quantity_must_be_an_integer()
    {
        $pricing = factory(Pricing::class)->create(['min_quantity' => 11]);

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->put(route('pricings.update', ['pricing' => $pricing->id]), [
                        'min_quantity' => 0.4
                    ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('min_quantity');
        $this->assertEquals(11, $pricing->fresh()->min_quantity);
    }

    /** @test */
    public function max_quantity_is_required()
    {
        $pricing = factory(Pricing::class)->create([
            'max_quantity' => 5
        ]);

        $response = $this->signIn($this->admin)
            ->withExceptionHandling()
            ->put(route('pricings.update', ['pricing' => $pricing->id]), $this->validParams([
                'max_quantity' => ''
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('max_quantity');
        $this->assertEquals(5, $pricing->fresh()->max_quantity);
    }

    /** @test */
    public function max_quantity_must_be_an_integer()
    {
        $pricing = factory(Pricing::class)->create(['max_quantity' => 99]);

        $response = $this->withExceptionHandling()
                    ->signIn($this->admin)
                    ->put(route('pricings.update', ['pricing' => $pricing->id]), [
                        'max_quantity' => 0.4
                    ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('max_quantity');
        $this->assertEquals(99, $pricing->fresh()->max_quantity);
    }
}
