<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class LockedThreadsController extends Controller
{
    /**
     * Lock the given thread
     *
     * @param Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->lock();
    }

    /**
     * Unlock the given thread
     *
     * @param Thread $thread
     */
    public function destroy(Thread $thread)
    {
        $thread->unlock();
    }
}
