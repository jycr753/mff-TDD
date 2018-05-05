<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    /**
     * Constructor 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * To store favorites for each reply
     *
     * @param Reply $reply //Reply Model binding
     * 
     * @return void
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    /**
     * Unfavorties a reply
     *
     * @param Reply $reply //Reply Model binding
     * 
     * @return void
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
