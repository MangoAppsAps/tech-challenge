<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

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

    public function bookings(): Relation
    {
        return $this->hasMany(Booking::class);
    }

    public function journals(): Relation
    {
        return $this->hasMany(Journal::class);
    }

    public function getUrlAttribute(): string
    {
        return route('clients.show', ['client' => $this->id]);
    }
}
