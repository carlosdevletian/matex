<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateOrderTest extends DuskTestCase
{
    use DatabaseTransactions;

    /** @test */
    public function create_order()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/design/bracelets')
                    ->whenAvailable('.Modal', function ($modal) {
                        $modal->assertSee('Welcome')
                            ->keys('.Button--secondary',['{escape}']);
                    })->press('guest')
                    ->whenAvailable('.Modal', function($modal) {
                        $modal->press('Continue');
                    })->pause(1000)
                    ->assertPathIs('/order/bracelets')
                    ->press('Small')
                    ->type('product-small', 1)
                    ->type('email', 'kajhsdkjahsd@kajhsdkjahsdka.com')
                    ->type('recipient', 'John Doe')
                    ->type('street', 'Example street')
                    ->type('city', 'Example City')
                    ->select('state')
                    ->type('zip', '33180')
                    ->type('phone_number', '123-45678')
                    ->press('Checkout');
                    // Acá va la parte de pagar con stripe
                    // ->whenAvailable('.stripe_checkout_app', function($stripeModal) {
                    //     $stripeModal->type('.Textbox-control','4242424242424242');
                    // });
        });
    }
}
