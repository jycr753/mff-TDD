<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Income extends Model
{
    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = ['categoryName', 'totalNetAmount'];

    /**
     * A income belongs to a owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A income has maney categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the name of each income category
     *
     * @return string
     */
    public function getCategoryNameAttribute()
    {
        return $this->category()
            ->where('user_id', auth()->id())
            ->value('name');
    }

    /**
     * Get the total monthly net amount
     *
     * @return integer
     */
    public function getTotalNetAmountAttribute()
    {
        return $this->sum('net_amount');
    }

    /**
     * Get all users latest incomes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incomeCategories()
    {
        return $this->hasMany(Category::class, 'user_id')->latest();
    }
}
