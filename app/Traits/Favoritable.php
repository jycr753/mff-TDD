<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use App\Favorite;
use App\Reputation;

trait Favoritable
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootFavoritable()
    {
        static::deleting(
            function ($model) {
                $model->favorites->each->delete();
            }
        );
    }

    /**
     * A reply can be favorited
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorite');
    }

    /**
     * Favorite the current reply.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {

            (new Reputation)->award(
                auth()->user(),
                Reputation::REPLY_FAVORITED
            );

            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Unfavorite the current reply.
     *
     * @return Model
     */
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();

        (new Reputation)->revoke(
            auth()->user(),
            Reputation::REPLY_FAVORITED
        );
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return bool
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Fetch the favorited status as a property.
     * 
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Get the number of favorites for the reply.
     * 
     * @return integer
     */
    public function getFavoriteCountAttribute()
    {
        return $this->favorites->count();
    }
}
