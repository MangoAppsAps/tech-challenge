<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'user_id'
    ];

    protected $appends = [
        'url',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class);
    }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }

    public function scopeFilterByAuthUser($query)
    {
        return $query->whereUserId(Auth::id());
    }
}
