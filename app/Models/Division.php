<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class, 'division_id');
    }

    public function requests()
    {
        return $this->hasManyThrough(
            Request::class,
            User::class,
            'division_id', // FK pada users
            'user_id',     // FK pada requests
            'id',          // PK pada divisions
            'id'           // PK pada users
        );
    }
}
