<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'bookings_count',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->latest('start');
    }

    public function getBookingsCountAttribute(): int
    {
        return $this->bookings->count();
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function getUrlAttribute(): string
    {
        return "/clients/" . $this->id;
    }
}
