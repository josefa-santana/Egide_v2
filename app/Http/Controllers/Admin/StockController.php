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

        $quantity = MinimumQuantity::find($id);
        
        $quantity_info = MinimumQuantity::find($id);
        
        return redirect()->route('configurations', compact('quantity', 'quantity_info'))->with('message', 'Estoque minimo alterado com sucesso!');
        
    }

    public function FinishSale(Request $request){
        $products = Product::all();
        self::notificationMinimumStock();

        $items = \Cart::getContent();

        $sales = $items->toArray();

    #    Sale::create([]);

        $new_sale = Sale::create();

        foreach ($items as $f) {
            $product_id = $f->id;
            $nome = $f->name;
            $preco = $f->price;
            $quantidade = $f->quantity;
            $new_item = OrderItem::create(['sale_id'=>$new_sale->id, 'nome'=>$nome, 'preco'=>$preco, 'quantidade'=>$quantidade, 'product_id'=>$product_id]);
           
            
            
        }

        return redirect()->route('salecheckout');

        
       # $new_sale = OrderItem::create(['product_id'=>$product_id, 'nome'=>$nome, 'preco'=>$preco, 'quantidade'=>$quantidade]);

    

       /* $data = $request->validate([
            'nome' => 'required|min:3|max:40',
            'categoria' => 'required|min:3|max:40',
            'preco' => 'required',
            'fornecedor' => 'required',
            'peso' => 'required|integer',
            'descricao' => 'required|min:3|max:2000'
        ]);*/

#        $new_product = Product::create($data);

    }

    public function notificationMinimumStock(){
        $user = User::all();
        $quantity = MinimumQuantity::all()->first();
        $items = \Cart::getContent();

        foreach ($items as $row) {

            $quantidade = $row->quantity;


            $stock = Stock::where('product_id', [$row->id])->decrement('quantidade', $quantidade);

            $stocks = Stock::where('product_id', [$row->id])->first();

            if($stocks->quantidade <= $quantity->quantidade_minima){
                Notification::send($user, new MinimumStock(['id' => $row->id, 'name' => $row->name]));
            
        }

    }


    return redirect()->route('salecheckout');
}

    public function markAsReadNotification($id){
        auth()->user()->unreadNotifications->where('id', $id)->first()->markAsRead();
        return redirect()->back();

    }



}
