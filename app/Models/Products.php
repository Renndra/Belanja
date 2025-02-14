<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = ['name', 'price', 'description', 'created_at', 'updated_at', 'is_active'];
    
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id')
                    ->withPivot(['stock', 'price', 'created_at', 'updated_at']);
    }
    
}
