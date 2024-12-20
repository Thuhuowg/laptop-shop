<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;

class OrderItem extends Model
{
    //
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'oder_id',
        'order_item_id',
        'product_name',
        'quantity',
        'price',
    ];
    public function order () {
        return $this->belongTo(Order::class);
    }
}
