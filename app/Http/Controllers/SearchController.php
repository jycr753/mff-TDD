<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Libraries\Trending;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $search = request('q');

        $threads = Thread::search($search)->paginate(25);

        if (request()->expectsJson()) {
            return $threads;
        }

        return view(
            'threads.search',
            [
                'trending' => $trending->get()
            ]
        );
    }
}
