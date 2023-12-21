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

    protected $appends = ['date', 'timeframe', 'start_stamp'];

    public function getDateAttribute()
    {
        return $this->start->format('l d F Y');
    }

    public function getTimeframeAttribute()
    {
        return $this->start->format('H:i') . ' to ' . $this->end->format('H:i');
    }

    public function getStartStampAttribute()
    {
        return $this->start->format('U');
    }
}
