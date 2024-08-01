<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Stock;

class ProductController extends Controller
{
    //
    public function Index(){
        return view('admin.indexproducts');
    }

    public function CreateProduct(){

        $products = Product::all();
        return view('admin.createproduct', compact('products'));

    }
    
    public function StoreProduct(Request $request){
        $products = Product::all();

        $data = $request->validate([
            'nome' => 'required|min:3|max:40',
            'categoria' => 'required|min:3|max:40',
            'preco' => 'required',
            'fornecedor' => 'required',
            'peso' => 'required|integer',
            'descricao' => 'required|min:3|max:2000'
        ]);

        $new_product = Product::create($data);

        $stock = $request->validate([
            'quantidade' => 'required'
        ]);

        $new_stock = Stock::create(['product_id'=>$new_product->id, 'quantidade'=>$stock['quantidade']]);

        if($request->has('images')){
            foreach($request->file('images')as $image){
                $imageName = $data['nome'].'-image-'.time().rand(1,1000).'.'.$image->extension();
                $image->move(public_path('product_images'),$imageName);
                Image::create([
                    'product_id'=>$new_product->id,
                    'image'=>$imageName
                ]);
            }
        }
        return redirect()->route('allproducts', compact('products'))->with('message', 'Produto adicionado com sucesso!');
    }

    public function ShowProducts(){
        $products = Product::paginate(10);
        $stock = Stock::all();
        return view('admin.allproducts', compact('products', 'stock'));
    }

    public function EditProduct($id){
        $product = Product::findOrFail($id);
        $product_info = Product::findOrFail($id);
       # $stock = $product->stock->quantidade;
        $images = $product->images;
        return view('admin.editproduct', compact('product_info', 'product', 'images'));
    }

    public function UpdateProduct(Request $request, Product $id){
        

        $id->update([
            'nome' => $request->nome,
            'categoria' => $request->categoria,
            'preco' => $request->preco,
            'fornecedor' => $request->fornecedor,
            'peso' => $request->peso,
            'descricao' => $request->descricao,

        ]);

        $stock = Stock::where('product_id', $id->id)->update(['quantidade' => $request->quantidade]);

        $products = Product::find($id);
        
  
        return redirect()->route('allproducts', compact('products'))->with('message', 'Produto alterado com sucesso!');

    }

    public function DeleteProduct($id){
        $product = Product::findOrFail($id);
        #$stock = Stock::all();
        if($product->images){
            foreach($product->images as $image){
                if(Image::exists($image->image)){
                    unlink(public_path('product_images/'.$image->image));
                    $image->delete();
                }
            }
        }
        Stock::where('product_id', $id)->delete();

        $product->findOrFail($id)->delete();
        return redirect()->route('allproducts')->with('message', 'Produto removido com sucesso!');
    }

    public function images($id){
        $product = Product::find($id);
        if(!$product) abort(404);
        $images = $product->images;
        return view('admin.imagesproduct',compact('product','images'));
    }

    public function DeleteImage($id){
    
        $image = Image::find($id);
        if(!$image) abort(404);
        unlink(public_path('product_images/'.$image->image));
        $image->delete();
        return redirect()->back();
    }

    public function AddImages(Request $request, $id){
        $product = Product::find($id);
        if(!$product) abort(404);

        if($request->has('images')){
            foreach($request->file('images')as $image){
                $imageName = $product['nome'].'-image-'.time().rand(1,1000).'.'.$image->extension();
                $image->move(public_path('product_images'),$imageName);
                Image::create([
                    'product_id'=>$product->id,
                    'image'=>$imageName
                ]);
            }
        }
        return redirect()->back();

    }

    public function SearchProducts(Request $request) {
        $search = $request->search;

        $products = Product::where(function($query) use ($search){
            $query->where('nome', 'like', "%$search%")
            ->orWhere('descricao', 'like', "%$search%")
            ->orWhere('id', 'like', "%$search%");
        })
        ->get();

        return view('admin.allproducts', compact('products'));
        
    }

   

}
