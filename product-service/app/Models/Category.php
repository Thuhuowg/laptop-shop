<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';  // Tên bảng trong cơ sở dữ liệu
    protected $primaryKey = 'category_id';  // Khóa chính của bảng
    public $timestamps = true;  // Đảm bảo bảng có cột created_at và updated_at
    protected $fillable = ['category_name', 'description', 'is_deleted'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}

