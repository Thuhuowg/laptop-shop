<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'Shopping_Cart'; // Tên bảng
    protected $primaryKey = 'cart_id';  // Khóa chính

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'added_at',
        'is_deleted',
    ];

    public $timestamps = false; // Nếu không có `created_at` và `updated_at`
}
