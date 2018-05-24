<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordActivity;

class Favorite extends Model
{
    use RecordActivity;

    /**
     * Don't auto-apply mass assignment protection.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Fetch the model that was favorited.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorite()
    {
        return $this->morphTo();
    }
}
