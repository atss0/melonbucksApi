<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'menu_item_id',
        'order_id',
        'quantity',
        'price',
    ];
    public function product() {
        return $this->belongsTo(MenuItem::class, 'menu_item_id');
    }
    
    public function order() {
        return $this->belongsTo(Order::class);
    }
}
