<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\Models\User')->create();

        $this->actingAs($user);

        return $this;
    }

    protected function signInAdmin($admin = null)
    {
        return $this->signIn(
            $admin = $admin ?: factory('App\Models\User')->states('admin')->create()
        );
    }
}
