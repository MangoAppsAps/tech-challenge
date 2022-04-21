<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\MultiTenantable;

class Client extends Model
{
    use HasFactory, MultiTenantable;

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
        return $this->hasMany(Booking::class)->orderBy('created_at', 'DESC');
    }

    public function journals()
    {
        return $this->hasMany(Journal::class)->orderBy('created_at', 'DESC');
    }

    /**
     * hasMany BookingsCount
     * Replaced getBookingsCountAttribute with this because otherwise the relation always counts as loaded even when
     * we don't need it
     *
     * @return void
     */
    public function bookingsCount() {
        return $this->hasMany(Booking::class);
    }

    // public function getBookingsCountAttribute()
    // {
    //     return $this->bookings->count();
    // }

    public function getUrlAttribute()
    {
        return "/clients/" . $this->id;
    }
}
