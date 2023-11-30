<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\Product;

class Product extends Model
{
    use HasFactory;

  /*  protected $fillable = [
        'nome',
        'categoria',
        'preco',
        'fornecedor',
        'quantidade',
        'peso',
        'descricao'
    ];*/


    protected $guarded = [];

    public function images(){
        return $this->hasMany(Image::class, 'product_id');
    }
    
    public function stock(){
        return $this->HasOne(Stock::class, 'product_id');
    }
}
