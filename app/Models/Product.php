<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'qty',
        'unit',
        'buy_price',
        'sell_price',
        'created_at',
        'updated_at',
    ];
}
