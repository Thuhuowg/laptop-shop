<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $primaryKey = 'product_id';
    public $incrementing = true;
    protected $fillable = [
        'product_id',
        'product_name',
        'category_id',
        'product_desc',
        'product_price',
        'product_image',
        'discount_id',
        'product_status',
    ] ;

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function discount()
    {
        return $this->belongsTo(DiscountModel::class, 'discount_id');
    }
}
