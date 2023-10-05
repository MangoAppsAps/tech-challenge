<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /** @var string[]  */
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    /** @var string[] */
    protected $dates = [
        'start',
        'end',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
