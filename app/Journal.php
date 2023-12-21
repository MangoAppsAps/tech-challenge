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
        'notes',
        'date'
    ];

    protected $appends = [
        'url',
        'client_url'
    ];

    public $timestamps = false;

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getUrlAttribute(): string
    {
        return "/clients/" . $this->client_id . "/journals/" . $this->id;
    }

    public function getClientUrlAttribute(): string
    {
        return "/clients/" . $this->client_id;
    }
}
