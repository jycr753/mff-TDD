<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Reply;
use App\Thread;

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
     * 
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store($channelId, Thread $thread)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply(
                [
                    'body' => request('body'),
                    'user_id' => auth()->id()
                ]
            );
        } catch (\Exception $e) {
            return response('Sorry, your reply can not be saved at the moment.', 422);
        }

        return $reply->load('owner');
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

        try {
            $this->validateReply();

            $reply->update(request(['body']));
        } catch (\Exception $e) {
            return response('Sorry, your reply can not be saved at the moment.', 422);
        }
    }

    /**
     * Validate and detect spam
     */
    public function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);

        resolve(Spam::class)->detect(request('body'));
    }
}
