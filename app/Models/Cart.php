<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'session_id', 'table_id'];
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function table()
    {
        return $this->belongsTo(\App\Models\Table::class);
    }
}
