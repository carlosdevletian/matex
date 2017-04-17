<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Design' => 'App\Policies\DesignPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('user', function ($user, $revisedUser) {
            return $user->id == $revisedUser->id || $user->role->name === 'admin';
        });

        Gate::define('owner', function ($user, $model) {
            return $model->user_id == $user->id || $user->role->name === 'admin';
        });
    }
}
