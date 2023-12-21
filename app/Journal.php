<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = ['date', 'text'];

    protected $dates = [
        'date',
    ];

    protected $appends = ['formatted_date', 'date_stamp'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function getFormattedDateAttribute()
    {
        return $this->date->format('F d, Y');
    }

    public function getDateStampAttribute()
    {
        return $this->date->format('U');
    }
}
