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

    protected $appends = ['formatted_date'];

    public function getFormattedDateAttribute() {
        return $this->start->format('l d F Y, H:i') . ' to ' . $this->end->format('H:i');
    }
}
