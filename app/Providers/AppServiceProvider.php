<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\User;
use App\Billing\PaymentGateway;
use Illuminate\Support\Collection;
use App\Billing\StripePaymentGateway;
use Laravel\Dusk\DuskServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::created(function($user){
            if(! $user->hasRole('user')) return; 
            return Cart::create(['user_id' => $user->id]);
        });

        Validator::extend('zip', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9]{5}(\-[0-9]{4})?$/', $value);
        }, 'Please enter a valid zip code');

        Collection::macro('transpose', function() {
            $items = array_map(function (...$items) {
                return $items;
            }, ...$this->values());

            return new static($items);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment('local', 'testing')) {
            $this->app->register(DuskServiceProvider::class);
        }

        $this->app->bind(StripePaymentGateway::class, function() {
            return new StripePaymentGateway(config('services.stripe.secret'));
        });

        $this->app->bind(PaymentGateway::class, StripePaymentGateway::class);
    }
}
