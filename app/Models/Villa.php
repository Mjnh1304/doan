<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Villa extends Model
{
    protected $fillable = ['name', 'price', 'location', 'description', 'image', 'panorama_url'];
    public function bookings()
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
    public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable')->latest();
}
}
