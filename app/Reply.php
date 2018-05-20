<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Favoritable;
use App\Traits\RecordActivity;
use Stevebauman\Purify\Purify;

class Reply extends Model
{
    use Favoritable, RecordActivity;

    /**
     * Don't auto-apply mass assignment protection.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['owner', 'favorites'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['favoriteCount', 'isFavorited', 'isBest'];

    /**
     * Boot the reply instance.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(
            function ($reply) {
                $reply->thread->increment('replies_count');

                (new Reputation)->award(
                    $reply->owner,
                    Reputation::REPLY_POSTED
                );
            }
        );

        static::deleted(
            function ($reply) {
                // This one way of doing it, we can alsoe do it in database level
                // look at create_thread_table
                if ($reply->isBest()) {
                    $reply->thread->update(['best_reply_id' => null]);
                }

                $reply->thread->decrement('replies_count');
            }
        );
    }
    /**
     * A reply has an owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A reply belongs to a thread.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Determine if the reply was just published a moment ago.
     *
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * Determine the path to the reply.
     *
     * @return void
     */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * Inspect the body of the reply for username
     *
     * @return array
     */
    public function mentionedUsers()
    {
        preg_match_all('/@([\w\-]+)/', $this->body, $matchs);

        return $matchs[1];
    }

    /**
     * Set the body attribute.
     *
     * @param string $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = \preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }

    /**
     * Determine if the current reply is marked as the best.
     *
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * Determine if the current reply is marked as the best.
     *
     * @return bool
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    /**
     * Access the body attribute.
     *
     * @param string $body
     * 
     * @return string
     */
    public function getBodyAttribute($body)
    {
        return \Purify::clean($body);
    }
}
