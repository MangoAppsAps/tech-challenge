<?php

namespace App\Models;

use App\Traits\ClientRelations;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use ClientRelations;

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
        'bookings_count'
    ];


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


}
