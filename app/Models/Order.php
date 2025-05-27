<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'table_id',
        'total_price',
        'status',
        'rating',
        'comment',
    ];
    public function items() {
        return $this->hasMany(OrderItem::class);
    }
    
    public function table() {
        return $this->belongsTo(Table::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
