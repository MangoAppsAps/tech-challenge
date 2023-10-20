<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DateTime;

class Journal extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'notes',
    ];

    public function getFormattedDateAttribute()
    {
        $formattedDate = $this->attributes['date'] ? (new DateTime($this->attributes['date']))->format('Y F j') : null;        
        return $formattedDate;
        
    }

}
