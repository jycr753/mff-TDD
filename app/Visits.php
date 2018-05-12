<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Visits
{
    /**
     * Initiate the thread
     *
     * @var array
     */
    protected $thread;

    /**
     * Create new visits
     *
     * @param Thread $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

    /**
     * Create a default kep for each thread
     *
     * @return string
     */
    public function cacheKey()
    {
        return "threads.{$this->thread->id}.visits";
    }

    /**
     * Reset redis list for test cases
     *
     * @return $this
     */
    public function reset()
    {
        Redis::del($this->cacheKey());

        return $this;
    }

    /**
     * Record by incrementing redis count for each key
     *
     * @return $this
     */
    public function record()
    {
        Redis::incr($this->cacheKey());

        return $this;
    }

    /**
     * Get the count of the redis thread list 
     *
     * @return int
     */
    public function count()
    {
        return Redis::get($this->cacheKey()) ?? 0;
    }
}
