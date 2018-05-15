<?php

namespace App\Http\Controllers;

use App\Thread;

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
}
