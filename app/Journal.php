<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'created_at',
        'client_id',
        'journal',
    ];
}
