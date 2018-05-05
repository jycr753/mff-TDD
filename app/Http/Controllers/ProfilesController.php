<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Show each user profile
     *
     * @param User $user //User Model binding
     * 
     * @return void
     */
    public function show(User $user)
    {
        return view(
            'profile.show', [
                'profileUser' => $user,
                'activities' => Activity::feed($user)
            ]
        );
    }
}
