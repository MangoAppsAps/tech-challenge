<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'content',
    ];

    public function client(): Relation
    {
        return $this->belongsTo(Client::class);
    }
}
