<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class ThreadHasNewReply
{
    //Dispatchable, InteractsWithSockets not needed
    use Dispatchable, SerializesModels;

    public $thread;
    public $reply;

    /**
     * Create a new event instance.
     * 
     * @param \App\Thread $thread
     * @param \App\Reply $reply
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }
}
