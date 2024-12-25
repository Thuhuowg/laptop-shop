<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'user_pj'; // Tên bảng
    protected $primaryKey = 'user_id';

    public $timestamps = false; // Vô hiệu hóa timestamps

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'address',
        'role_id',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
