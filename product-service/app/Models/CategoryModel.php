<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;
    protected $table = "categories";
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    protected $fillable = [
        'category_id',
        'category_name',
        'category_desc',
        'category_status',
    ] ;

    public function products()
    {
        return $this->hasMany(ProductModel::class, 'category_id');
    }
}
