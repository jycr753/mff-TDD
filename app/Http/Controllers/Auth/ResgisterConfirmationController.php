<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ResgisterConfirmationController extends Controller
{
    /**
     * User email confirmatin and redirect
     *
     * @return view
     */
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrfail()
            ->confirm();

        return redirect('/dashboard')
            ->with('flash', 'Your account is now confirmed');
    }
}
