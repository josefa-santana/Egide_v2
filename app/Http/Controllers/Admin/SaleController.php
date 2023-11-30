<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Image;
use App\Models\User;

class SaleController extends Controller
{
    //
    public function Index(){
        $products = Product::all();
        $images = Image::all();
        return view('admin.displayproducts', compact('products', 'images'));
    }

    public function Checkout(){
        $items = \Cart::getContent();
        return view('admin.salecheckout', compact('items'));
    }

    public function ViewProduct($id){
        $product = Product::find($id);
        return view('admin.viewproduct', compact('product'));
    }

    public function DoneSale(){

    }
    
}
