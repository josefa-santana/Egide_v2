<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use MercadoPago\Item;
use MercadoPago\Preference;
use MercadoPago\SDK;
use MercadoPago;
use MercadoPago\Config;

class CartController extends Controller
{
    //
    public function Index(){
        $items = \Cart::getContent();
        $products = Product::all();
        $stock = Stock::all();
        return view('cart', compact('items', 'products',  'stock'));
    }

    public function AddToCart(Request $request){
        \Cart::add([
            'id' => $request->id,
            'name' => $request->nome,
            'price' => $request->preco,
            'quantity' => abs($request->quantidade)
        ]);

        return redirect()->back()->with('message', 'Produto adicionado no carrinho com sucesso!');
    }

    public function DeleteCart(Request $request){
        \Cart::remove($request->id);

        return redirect()->back()->with('message', 'Produto removido do carrinho com sucesso!');
    }

    public function UpdateCart(Request $request){
        \Cart::update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => abs($request->quantity),
            ],
        ]);

        return redirect()->back()->with('message', 'Produto atualizado ao carrinho com sucesso!');
    }

    public function ClearCart(Request $request){
        \Cart::clear();

        return redirect()->back()->with('warning', 'Seu carrinho está vazio!');
    }

    
    public function FinalizarVenda(){
        SDK::setAccessToken(config('services.mercadopago.token'));

        $cart = \Cart::getContent();

        $preference = new Preference();

        $itens = [];

        foreach ($cart as $produtos) {
            # code...
            $item = new Item();
            $item->title = $produtos->name;
            $item->quantity = $produtos->quantity;
            $item->unit_price = $produtos->price;
            $item->currency_id = "BRL";

            $itens[] = $item;

        }

    
        $preference->items = $itens;
        $preference->save();

        
        $mp = new MercadoPago\MercadoPagoConfig(config('services.mercadopago.key'));
        $bricksBuilder = $mp.bricks();

      

    }


    
}
