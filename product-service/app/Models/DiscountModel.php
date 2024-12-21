<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountModel extends Model
{
    protected $table = "discounts";
    protected $primaryKey = 'discount_id';
    public $incrementing = true;
    protected $fillable = [
        'discount_id',
        'discount_name',
        'discount_percent',
        'start_date',
        'end_date',
    ] ;

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'discount_id');
    }
}
