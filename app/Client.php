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
        return $this->hasMany(Booking::class)
            ->orderBy('start', 'desc');
    }

    public function getBookingsCountAttribute()
    {
        return $this->bookings->count();
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }
}
