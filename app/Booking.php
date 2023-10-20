<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getFormattedTimeRangeAttribute()
    {
        $formattedStart = $this->attributes['start'] ? Carbon::parse($this->attributes['start'])->format('l j F Y, H:i') : null;
        $formattedEnd = $this->attributes['end'] ? Carbon::parse($this->attributes['end'])->format('H:i') : null;

        return $formattedStart . ' to ' . $formattedEnd;
        
    }

}
