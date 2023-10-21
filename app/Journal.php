<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'text',
        'date',
        'client_id'
    ];
}
