<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'date',
        'text',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
