<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments'; // Tên bảng trong CSDL

    protected $fillable = [
        'order_id',
        'payment_method',
        'payment_status',
        'amount',
    ];
}

