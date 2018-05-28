<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class PinnedThreadsController extends Controller
{
    /**
     * Pin the given thread.
     *
     * @param Thread $thread
     * 
     * @return void
     */
    public function store(Thread $thread)
    {
        $thread->update(['pinned' => true]);
    }

    /**
     * Un-Pin the given thread.
     *
     * @param Thread $thread
     * 
     * @return void
     */
    public function destroy(Thread $thread)
    {
        $thread->update(['pinned' => false]);
    }
}
