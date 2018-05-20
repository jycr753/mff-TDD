<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance. 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favorite in the database.
     *
     * @param Reply $reply
     * 
     * @return redirect
     */
    public function store(Reply $reply)
    {
        $reply->favorite();
    }

    /**
     * Delete the favorite.
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
