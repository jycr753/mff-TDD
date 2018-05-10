<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;
use App\Spam;

class RepliesController extends Controller
{
    /**
     * Create a new RepliesController instance.
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Persist a new reply.
     *
     * @param  integer $channelId
     * @param  Thread  $thread
     * @param  Spam    $spam
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(
            request(),
            [
                'body' => ' required'
            ]
        );

        $spam->detect(request('body'));

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
     * Delete the given reply.
     *
     * @param Reply $reply //Reply Model binding
     * 
     * @return \Illuminate\Http\RedirectResponse
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
     * Update an existing reply.
     *
     * @param Reply $reply
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(request(['body']));
    }
}
