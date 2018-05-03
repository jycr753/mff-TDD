<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    /**
     * @var array
     */
    protected $guarded = [];

    protected $with = ['owner', 'favorites'];

    protected $appends = ['favoriteCount', 'isFavorited'];

    /**
     * A reply has a owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return $this->thread->path(). "#reply-{$this->id}";
    }
}
