<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'user_id',
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
        return route('clients.show', ['client' => $this->id]);
    }
}
