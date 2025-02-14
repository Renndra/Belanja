<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'status', 'total', 'created_at', 'updated_at', 'status'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_product', 'order_id', 'product_id')
                    ->withPivot(['stock', 'price', 'created_at', 'updated_at']);
    }
}    
