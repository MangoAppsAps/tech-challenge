<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    protected $appends = ['time_range'];

    public function getTimeRangeAttribute()
    {
        $start = $this->start->format('l d F Y, H:i');
        if ($this->start->isSameDay($this->end)) {
            $end = $this->end->format('H:i');
        } else {
            $end = $this->end->format('l d F Y, H:i');
        }

        return $start . ' to ' . $end;
    }
}
