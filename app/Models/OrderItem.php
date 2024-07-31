<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'Order_Item';
    protected $fillable = [
        'sale_id',
        'nome',
        'preco',
        'quantidade',
        'product_id',
    ];
}
