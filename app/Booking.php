<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    public function getIntervalAttribute(): string
    {
        $startFormat = 'l d F Y, H:i';
        $endFormat = $this->end->isSameDay($this->start) ? 'H:i' : $startFormat;

        return "{$this->start->format($startFormat)} to {$this->end->format($endFormat)}";
    }

    public function client(): Relation
    {
        return $this->belongsTo(Client::class);
    }
}
