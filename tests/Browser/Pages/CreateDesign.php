<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

class CreateDesign extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/design/bracelets';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->whenAvailable('.Modal', function ($modal) {
                    $modal->assertSee('Welcome')
                        ->keys('.Button--secondary',['{escape}']);
                })
                ->press('guest')
                ->whenAvailable('.Modal', function($modal) {
                    $modal->press('Continue');
                });
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}
