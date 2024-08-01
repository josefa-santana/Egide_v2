<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\MinimumQuantity;
use App\Models\User;
use App\Notifications\MinimumStock;
use Illuminate\Support\Facades\Notification;



class StockController extends Controller
{
    //
    public function updateStockIncrease(){
        $products = Product::all();
        $images = Image::all();
        return view('admin.displayproducts', compact('products', 'images'));
    }

    public function StockProducts() {
        $stock = Stock::all();
        $products = Product::all();
        $total = $stock->sum('quantidade');
        $valor_total = $products->sum('preco') * $total;
        
        return view('admin.stockproducts', compact('products', 'total', 'valor_total'));
        
    }

    public function ConfigurationsProfile() {

        $quantity = MinimumQuantity::all()->first();
        $quantity_info = MinimumQuantity::all()->first();
        
        return view('admin.configurations', compact('quantity', 'quantity_info'));
        
    }

    public function UpdateQuantity(Request $request, MinimumQuantity $id) {


        $id->update([
            'quantidade_minima' => $request->quantidade_minima
        ]);

        $quantity = MinimumQuantity::findorfail($id);
        
        $quantity_info = MinimumQuantity::findorfail($id);
        
        return redirect()->route('configurations', compact('quantity', 'quantity_info'))->with('message', 'Estoque minimo alterado com sucesso!');
        
    }

    public function notificationMinimumStock(Request $request, Product $id){
        $user = User::all();
        $product = Product::findorfail($id);
        $quantity = MinimumQuantity::all()->first();
       # $cart = Cart::all();


        $stock = Stock::where('product_id', $id->id)->decrement('quantidade', $request->quantidade);

        $stocks = Stock::where('product_id', $id->id)->first();

        if($stocks->quantidade <= $quantity->quantidade_minima){
            Notification::send($user, new MinimumStock());
        }

        return redirect()->route('cart');
    }

    public function markAsReadNotification(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();

    }



}
