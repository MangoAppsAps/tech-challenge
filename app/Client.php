<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read Collection $bookings
 */
class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'adress',
        'city',
        'postcode',
    ];

    protected $appends = [
        'url',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings->count();
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }
}
