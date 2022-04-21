<?php

namespace App;

use Carbon\Carbon;
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

    protected $appends = [
        'time'
    ];

    public function getTimeAttribute()
    {
        $date = Carbon::parse($this->start)->format('l d M Y');
        $startTime = Carbon::parse($this->start)->format('H:i');
        $endTime = Carbon::parse($this->end)->format('H:i');
        $fullDate = $date . ', ' . $startTime . ' to ' . $endTime;
        return $fullDate;
    }


}
