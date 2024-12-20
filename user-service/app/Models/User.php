<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'User_PJ'; // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'user_id'; // Tên khóa chính
    public $timestamps = false; // Vì bảng không có cột timestamps mặc định

    protected $fillable = [
        'username',
        'password',
        'email',
        'phone_number',
        'address',
        'role_id',
        'is_deleted'
    ];

    // Nếu cần mã hóa mật khẩu trước khi lưu
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
