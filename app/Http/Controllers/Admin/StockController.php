<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Sale;
use App\Models\MinimumQuantity;
use App\Models\User;
use App\Models\OrderItem;
use App\Notifications\MinimumStock;
use Illuminate\Support\Facades\Notification;



class StockController extends Controller
{
    //
    public function updateStockIncrease(){
        $products = Product::where('is_active', true)->get();
        $images = Image::all();
        return view('admin.displayproducts', compact('products', 'images'));
    }

    public function StockProducts() {
        $stock = Stock::all();
        $products = Product::where('is_active', true)->get();
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

        $quantity = MinimumQuantity::find($id);
        
        $quantity_info = MinimumQuantity::find($id);
        
        return redirect()->route('configurations', compact('quantity', 'quantity_info'))->with('message', 'Estoque minimo alterado com sucesso!');
        
    }

    public function FinishSale(Request $request){
        // Verificar e notificar sobre estoque mínimo
        self::notificationMinimumStock();

        // Obter o conteúdo do carrinho
        $items = \Cart::getContent();
        $sales = $items->toArray();

        // Criar um novo pedido
        $new_sale = Sale::create();
        $total = 0;
        $orderDetails = [];

        foreach ($items as $item) {
            $product_id = $item->id;
            $nome = $item->name;
            $preco = $item->price;
            $quantidade = $item->quantity;

            // Buscar o estoque do produto
            $stock = Stock::where('product_id', $product_id)->first();

            // Criar um item de pedido
            OrderItem::create(['sale_id'=>$new_sale->id, 'nome'=>$nome, 'preco'=>$preco, 'quantidade'=>$quantidade, 'product_id'=>$product_id]);
           
            // Atualizar o estoque: Subtrair a quantidade vendida
            $stock->quantidade -= $quantidade;
            $stock->quantidade = max($stock->quantidade, 0); // Garantir que o estoque não fique negativo
            $stock->save();   

            // Preparar detalhes do pedido
            $orderDetails[] = [
                'nome' => $nome,
                'preco' => $preco,
                'quantidade' => $quantidade,
               
            ];

            // Calcular o total
            $total += $preco * $quantidade;
        }

         // Salvar os detalhes do pedido na sessão
        $request->session()->put('orderDetails', [
            'order_id' => $new_sale->id,
            'total' => $total,
            'items' => $orderDetails,
        ]);

        // Limpar o carrinho
        \Cart::clear();

        return redirect()->route('salecheckout');
    }

    public function notificationMinimumStock(){
        // Obter todos os usuários para enviar notificações
        $users = User::all();

        // Obter a quantidade mínima de estoque
        $minimumQuantity = MinimumQuantity::first()->quantidade_minima;

        // Obter o conteúdo do carrinho
        $items = \Cart::getContent();

        foreach ($items as $item) {
            $product_id = $item->id;
            $quantidade = $item->quantity;
    
            // Obter o estoque atual do produto
            $stock = Stock::where('product_id', $product_id)->first();
    
            if (!$stock) {
                continue; // Se o estoque não existir, continue com o próximo item
            }

            // Calcular a quantidade restante após a venda
            $remainingQuantity = $stock->quantidade - $quantidade;

            // Verificar o status do estoque e enviar notificações apropriadas
            if ($remainingQuantity <= 0) {
                // Estoque esgotado
                Notification::send($users, new MinimumStock([
                    'id' => $product_id,
                    'name' => $item->name,
                    'status' => 'esgotado'
                ]));
            } elseif ($remainingQuantity <= $minimumQuantity) {
                // Estoque baixo
                Notification::send($users, new MinimumStock([
                    'id' => $product_id,
                    'name' => $item->name,
                    'status' => 'baixo'
                ]));
            }
            // Atualizar o estoque: subtrair a quantidade vendida
        $stock->quantidade = max($remainingQuantity, 0); // Garantir que o estoque não seja negativo
        $stock->save();
    }
    return redirect()->route('salecheckout');
}


    public function markAsReadNotification($id){
        auth()->user()->unreadNotifications->where('id', $id)->first()->markAsRead();
        return redirect()->back();

    }



}
