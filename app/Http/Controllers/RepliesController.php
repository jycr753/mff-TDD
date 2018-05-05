<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    /**
     * Constructor for autheticating user
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * To Store a reply
     *
     * @param [type] $channelId //Channel id
     * @param Thread $thread    //Thread Model bonding
     * 
     * @return void
     */
    public function store($channelId, Thread $thread)
    {
        $this->validate(
            request(), [
                'body' => ' required'
            ]
        );

        $reply = $thread->addReply(
            [
                'body' => request('body'),
                'user_id' => auth()->id()
            ]
        );

        if (request()->expectsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * To delete a reply
     *
     * @param Reply $reply //Reply Model binding
     * 
     * @return void
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (\request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back()->with('flash', 'your reply has been deleted!');
    }

    /**
     * To update a reply
     *
     * @param Reply $reply //Reply Model binding
     * 
     * @return void
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body']));
    }
}
