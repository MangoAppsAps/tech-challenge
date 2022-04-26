<?php

namespace App\Traits;

use App\Models\Booking;
use App\Models\Journal;

trait ClientRelations
{
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function journals()
    {
        return $this->hasMany(Journal::class, 'client_id', 'id');
    }


}
