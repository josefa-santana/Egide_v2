<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Notifications\Notifiable;

class Stock extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    public function product(){
        return $this->HasOne(Product::class, 'product_id');
    }
}
