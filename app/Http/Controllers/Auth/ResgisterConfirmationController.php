<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class ResgisterConfirmationController extends Controller
{
    /**
     * User email confirmatin and redirect
     *
     * @return view
     */
    public function index()
    {
        try {
            User::where('confirmation_token', request('token'))
                ->firstOrfail()
                ->confirm();
        } catch (\Exception $e) {
            return redirect('/dashboard')
                ->with('flash', 'Unknown token.');
        }

        return redirect('/dashboard')
            ->with('flash', 'Your account is now confirmed');
    }
}
