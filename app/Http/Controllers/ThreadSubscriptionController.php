<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadSubscriptionController extends Controller
{
    /**
     * Store a newly created subscription in storage.
     *
     * @param Thread $thread
     * @param $channelId
     */
    public function store($channelId, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * Destroy a thread subscription.
     *
     * @param Thread $thread
     * @param $channelId
     */
    public function destroy($channelId, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
