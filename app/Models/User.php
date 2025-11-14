<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'division_id'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function division()
{
    return $this->belongsTo(\App\Models\Division::class);
}

    public function isAdmin() { return $this->role === 'admin'; }
    public function isLeader() { return $this->role === 'leader'; }
    public function isFinance() { return $this->role === 'finance'; }
}
