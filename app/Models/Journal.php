<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'journal_date',
        'journal_content',
    ];

    protected $dates = ['journal_date'];
}
