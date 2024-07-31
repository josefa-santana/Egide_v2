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
        // Obtém todos os produtos
        $products = Product::with('images')->get();
    
        // Verifica se há produtos
        $hasProducts = $products->isNotEmpty();
    
        // Verifica se a pasta de imagens está vazia
        $publicImagesPath = public_path('product_images');
        $imagesInDirectory = array_diff(scandir($publicImagesPath), ['..', '.']);
        $hasImagesInDirectory = count($imagesInDirectory) > 0;
    
        // Passa os dados e a informação de existência para a view
        return view('admin.displayproducts', compact('products', 'hasProducts', 'hasImagesInDirectory'));
    }

    public function Checkout(){
        $items = \Cart::getContent();
        return view('admin.salecheckout', compact('items'));
    }

    public function ViewProduct($id){
        // Obtém o produto com as imagens associadas
        $product = Product::with('images')->find($id);
    
        // Verifica se o produto foi encontrado e se há imagens
        $hasImages = $product && $product->images->isNotEmpty();
    
        // Passa o produto e a informação de existência para a view
        return view('admin.viewproduct', compact('product', 'hasImages'));
    }


    
}
