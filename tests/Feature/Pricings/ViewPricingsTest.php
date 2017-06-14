<?php

namespace Tests\Feature\Pricings;

use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Assert;
use App\Models\CategoryPricing as Pricing;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewPricingsTest extends TestCase
{
    use DatabaseMigrations;


    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(User::class)->states('admin')->create();

        TestResponse::macro('data', function($key) {
            return $this->original->getData()[$key];
        });

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
    public function an_admin_can_view_all_pricings_for_a_category()
    {
        $category = factory('App\Models\Category')->create();

        $pricingA = factory(Pricing::class)->create(['category_id' => $category->id]);
        $pricingB = factory(Pricing::class)->create(['category_id' => '99']);
        $pricingC = factory(Pricing::class)->create(['category_id' => $category->id]);

        $response = $this->signIn($this->admin)
            ->get(route('pricings.index', ['category' => $category->id]));

        $response->assertStatus(200);
        $response->data('pricings')->assertContains($pricingA);
        $response->data('pricings')->assertNotContains($pricingB);
        $response->data('pricings')->assertContains($pricingC);
    }

    /** @test */
    public function pricings_are_sorted_by_their_minimum_quantity_in_descending_order()
    {
        $category = factory('App\Models\Category')->create();
        $pricingA = factory(Pricing::class)->create([
            'min_quantity' => 1000,
            'category_id' => $category->id
        ]);
        $pricingB = factory(Pricing::class)->create([
            'min_quantity' => 10,
            'category_id' => $category->id
        ]);
        $pricingC = factory(Pricing::class)->create([
            'min_quantity' => 100,
            'category_id' => $category->id
        ]);

        $response = $this->signIn($this->admin)
            ->get(route('pricings.index', ['category' => $category->id]));

        $response->assertStatus(200);
        $this->assertEquals([
            $pricingB->id,
            $pricingC->id,
            $pricingA->id
        ], $response->data('pricings')->pluck('id')->all());
    }

    /** @test */
    public function a_guest_cannot_view_all_pricings_for_a_category()
    {
        $category = factory('App\Models\Category')->create();

        $pricingA = factory(Pricing::class)->create(['category_id' => $category->id]);
        $pricingB = factory(Pricing::class)->create(['category_id' => '99']);
        $pricingC = factory(Pricing::class)->create(['category_id' => $category->id]);

        $response = $this->get(route('pricings.index', ['category' => $category->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }
}
