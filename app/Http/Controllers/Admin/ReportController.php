<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class ReportController extends Controller
{
    //
    public function Index(){
        
        $products = Product::all()->count();//quantidade de produtos cadastrados no banco
        $stock = DB::table('stock_mutations')->count();//quantidade de registros de alteração de estoque
        $user = DB::table('users')->count();//quantidade de registro de usuários no sistema
        //DATASET QUANTIDADE(Y) X PRODUTO(X)
        $prodName = DB::table('products')->orderBy('created_at')->pluck('nome')->toArray(); //coluna de nome dos produtos ordenados por inserção
        $qtdStockP = DB::table('stocks')->orderBy('created_at')->pluck('quantidade')->toArray(); //coluna de quantidade em estoque ordenado por inserção
        return view('admin.report', compact('products', 'stock', 'user', 'prodName', 'qtdStockP'));
    }


    
}
