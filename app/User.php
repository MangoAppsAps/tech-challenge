<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasFactory;

    /** @var string[] */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /** @var string[] */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /** @var string[] */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
