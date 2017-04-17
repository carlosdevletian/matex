<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Design;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Design $design)
    {
        return $user->id == $design->user_id;
    }
}
