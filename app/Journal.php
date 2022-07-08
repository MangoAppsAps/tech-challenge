<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    public $timestamps = false;

    public $fillable = [
        'client_id',
        'text',
        'date'
    ];

    protected $dates = [
        'date'
    ];

    protected $casts = [
        'date' => 'date:l d F Y',
    ];
}
