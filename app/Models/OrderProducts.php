<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'order_products';
    protected $fillable = [
        'products_id',
        'orders_id'
    ];
}
