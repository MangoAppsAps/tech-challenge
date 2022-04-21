<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    protected $table = 'journals';
    protected $fillable = ['text', 'date', 'client_id', 'user_id'];
}
