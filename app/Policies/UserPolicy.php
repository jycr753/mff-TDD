<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the given profile.
     *
     * @param \App\Models\User  $user
     * @param \App\Models\User  $signInUser
     * 
     * @return mixed
     */
    public function update(User $user, User $signInUser)
    {
        return $signInUser->id == $user->id;
    }
}
