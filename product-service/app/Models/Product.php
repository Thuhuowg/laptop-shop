<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'product_id';  // Khóa chính của bảng
    public $timestamps = true;  // Đảm bảo bảng có cột created_at và updated_at
    protected $fillable = ['product_name', 'description', 'price', 'category_id', 'image_url', 'discount_id', 'is_deleted']; 
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
