<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** @property-read int $id */
class Client extends Model
{
    /** @var string[] */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
    ];

    /** @var string[] */
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
        return $this->hasMany(Booking::class);
    }

    public function getBookingsCountAttribute(): int
    {
        return $this->bookings()->count();
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }

    public function getUrlAttribute(): string
    {
        return route('clients.show', $this->id);
    }
}
