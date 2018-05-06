<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    /**
     * Show the user profile
     *
     * @param User $user
     * 
     * @return \Response
     */
    public function show(User $user)
    {
        return view(
            'profile.show',
            [
                'profileUser' => $user,
                'activities' => Activity::feed($user)
            ]
        );
    }
}
