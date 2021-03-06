<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $guarded = [];

    protected $casts = [
        'archived' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(
            'active',
            function ($builder) {
                $builder->where('archived', false)
                    ->orderBy('name', 'asc');
            }
        );
    }

    /**
     * Get the route key name for Laravel.
     * 
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * To archived a channel
     *
     * @return void
     */
    public function archived()
    {
        $this->update(['archived' => true]);
    }

    /**
     * A channel consists of threads.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
