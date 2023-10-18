<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    protected $appends = [
        'url',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class)->orderBy('start', 'DESC');
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings->count();
    }

    public function journals()
    {
        return $this->hasMany(Journal::class)->orderBy('date', 'DESC');
    }

    public function journalsCount()
    {
        return $this->journals->count();
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }
}
