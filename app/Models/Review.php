<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reviewable_id',
        'reviewable_type',
        'user_id',
        'rating',
        'comment',
        'parent_id',
    ];
    public function reviewable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
