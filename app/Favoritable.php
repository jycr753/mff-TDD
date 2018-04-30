<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

trait Favoritable
{

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
     * Create favorite for each reply
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Find out if the reply is already favorited
     *
     * @return bool
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     *
     * @return mixed
     */
    public function getFavoriteCountAttribute()
    {
        return $this->favorites->count();
    }
}