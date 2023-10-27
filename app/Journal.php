<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $fillable = [
        'client_id',
        'date',
        'text'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
