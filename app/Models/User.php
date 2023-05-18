<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Foundation\Auth\User as AuthUser;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AuthUser implements JWTSubject
{
    use HasFactory, Filterable;

    protected $table = 'user';

    protected $fillable = [
        'id',
        'email',
        'name',
        'password',
    ];

    public $timestamps = false;

    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
