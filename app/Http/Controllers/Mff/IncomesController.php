<?php

namespace App\Http\Controllers\Mff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mff\Income;

class IncomesController extends Controller
{
    /**
     * Create a new ThreadsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created income
     * 
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        request()->validate(
            [
                'income_date' => 'required|date',
                'income_type' => 'required|string',
                'gross_amount' => 'required|regex:/^[\d]+[\.][\d]{2}/|greaterThan:net_amount',
                'net_amount' => 'required|regex:/^[\d]+[\.][\d]{2}/'
            ]
        );

        $income = Income::create(
            [
                'user_id' => auth()->id(),
                'income_date' => request('income_date'),
                'income_type' => request('income_type'),
                'gross_amount' => request('gross_amount'),
                'net_amount' => request('net_amount')
            ]
        );

        return redirect('/dashboard')
            ->with('flash', 'Your income is saved!');
    }
}
