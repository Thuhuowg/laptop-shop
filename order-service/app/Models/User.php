<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;  // Thêm dòng này

class User extends Authenticatable implements JWTSubject  // Implement JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone_number',
        'address'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Lấy định danh (ID) của người dùng.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();  // Hoặc có thể là $this->id nếu khóa chính là id
    }

    /**
     * Lấy các thuộc tính tùy chỉnh của người dùng (thêm vào trong token).
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];  // Có thể trả về mảng các thuộc tính tùy chỉnh nếu cần
    }
}
