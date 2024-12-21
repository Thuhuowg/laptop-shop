<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'discount_id';  // Khóa chính của bảng
    public $timestamps = true;  // Đảm bảo bảng có cột created_at và updated_at
    protected $fillable = ['discount_name', 'discount_percent', 'start_date', 'end_date', 'is_deleted'];

    public function products()
    {
        return $this->hasMany(Product::class, 'discount_id');
    }
}
