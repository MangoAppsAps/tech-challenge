<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'notes',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

}

