<?php

namespace App\Http\Controllers\Mff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Income;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

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
    public function store(Request $request)
    {
        //dd(request('income_date'), request('category_id'), request('gross_amount'), request('net_amount'));
        $validator = Validator::make(
            $request->all(),
            [
                'income_date' => 'required|date_format:Y-m-d',
                'category_id' => 'required|exists:categories,id',
                'gross_amount' => 'required|regex:/^[\d]+[\.][\d]{2}/|greaterThan:net_amount',
                'net_amount' => 'required|regex:/^[\d]+[\.][\d]{2}/'
            ]
        );

        if ($validator->fails()) {
            dd($validator->errors());
            return response()->json(['message' => $validator->errors()]);
        }

        $income = Income::create(
            [
                'user_id' => auth()->id(),
                'income_date' => request('income_date'),
                'category_id' => request('category_id'),
                'gross_amount' => request('gross_amount'),
                'net_amount' => request('net_amount'),
                'description' => request('description')
            ]
        );


        return ['message' => 'Income added!'];
    }
}
