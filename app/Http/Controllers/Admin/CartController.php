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
        $products = Product::where('is_active', true)->get();
        $stock = Stock::all();
        return view('cart', compact('items', 'products',  'stock'));
    }

    public function AddToCart(Request $request){
        // Validar a entrada do formulário
        $request->validate([
            'id' => 'required|integer|exists:products,id',
            'nome' => 'required|string',
            'preco' => 'required|numeric',
            'quantidade' => 'required|integer|min:1'
        ]);

        // Buscar o produto pelo ID
        $product = Product::where('id', $request->id)
        ->where('is_active', true)
        ->first();

        if (!$product) {
            return redirect()->back()->withErrors('Produto não encontrado.');
        }

        // Buscar o estoque do produto
        $stock = Stock::where('product_id', $request->id)->first();
        if (!$stock) {
            return redirect()->back()->withErrors('Estoque não encontrado para o produto.');
        }
        // Verificar se a quantidade solicitada é maior que o estoque disponível
        if ($request->quantidade > $stock->quantidade) {
            return redirect()->back()->withErrors('Quantidade solicitada não disponível no estoque.');
        }

        // Adicionar o produto ao carrinho
        \Cart::add([
            'id' => $request->id,
            'name' => $request->nome,
            'price' => $request->preco,
            'quantity' => abs($request->quantidade)
        ]);
        // Atualizar o estoque: subtrair a quantidade adicionada ao carrinho
        $newStockQuantity = $stock->quantidade - $request->quantidade;;

        $stock->quantidade = max($newStockQuantity, 0); // Evita valores negativos
        $stock->save();

        return redirect()->back()->with('message', 'Produto adicionado no carrinho com sucesso!');
    }

    public function DeleteCart(Request $request){
        // Encontrar o item no carrinho
        $cartItem = \Cart::get($request->id);

        if (!$cartItem) {
            return redirect()->back()->withErrors('Item não encontrado no carrinho.');
        }
    
        // Buscar o estoque do produto
        $stock = Stock::where('product_id', $cartItem->id)->first();
    
        if (!$stock) {
            return redirect()->back()->withErrors('Estoque não encontrado para o produto.');
        }
    
        // Adicionar a quantidade de volta ao estoque
        $stock->quantidade += $cartItem->quantity;
        $stock->save();

        // Remover o item do carrinho
        \Cart::remove($request->id);

        return redirect()->back()->with('message', 'Produto removido do carrinho com sucesso!');
    }

    public function UpdateCart(Request $request){
        // Validar a entrada do formulário
        $request->validate([
            'id' => 'required|string', // ID do item no carrinho
            'quantity' => 'required|integer|min:1'
        ]);

        // Obter o item atual do carrinho
        $cartItem = \Cart::get($request->id);

        if (!$cartItem) {
            return redirect()->back()->withErrors('Item não encontrado no carrinho.');
        }
    
        // Buscar o estoque do produto
        $stock = Stock::where('product_id', $cartItem->id)->first();
    
        if (!$stock) {
            return redirect()->back()->withErrors('Estoque não encontrado para o produto.');
        }

        // Calcular a diferença de quantidade
        $quantityDifference = $request->quantity - $cartItem->quantity;

        // Verificar se a nova quantidade solicitada é maior que o estoque disponível
        if ($quantityDifference > $stock->quantidade) {
            return redirect()->back()->withErrors('Quantidade solicitada não disponível no estoque.');
        }

        // Atualizar o estoque: adicionar de volta a quantidade anterior e subtrair a nova
        $stock->quantidade += $cartItem->quantity; // Adiciona de volta a quantidade antiga
        $stock->quantidade -= $request->quantity; // Subtrai a nova quantidade
        $stock->quantidade = max($stock->quantidade, 0); // Garante que o estoque não fique negativo
        $stock->save();

        // Atualizar a quantidade no carrinho
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
