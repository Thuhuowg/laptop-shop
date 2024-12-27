<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Tên bảng tương ứng trong CSDL
    protected $table = 'orders';

    // Các trường có thể được gán (mass assignable)
    protected $fillable = [
        'user_id', 
        'customer_name', 
        'address', 
        'phone', 
        'payment_method', 
        'total_amount', 
        'status'
    ];

    // Các trường không được gán (bảo vệ)
    protected $guarded = ['id'];

    // Thời gian mặc định (Laravel tự động thêm created_at và updated_at)
    public $timestamps = false;

    // Các định dạng dữ liệu cho các trường ngày tháng
    protected $dates = [
        'created_at',
        'updated_at',
    ];


}
