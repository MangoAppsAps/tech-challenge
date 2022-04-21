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
        'user_id'
    ];

    protected $appends = [
        'url','bookings_count'
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

//local scope
    public function scopeCurrentUser()
    {
        return $this->where('user_id', '=', Auth()->id());
    }

    public function journals()
    {
        return $this->hasMany(Journal::class,'client_id','id');
    }




}
