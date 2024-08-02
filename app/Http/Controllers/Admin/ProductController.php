<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use App\Models\Stock;
use App\Models\OrderItem;

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
            'nome' => 'required|min:3|max:100',
            'categoria' => 'required|min:3|max:40',
            'preco' => 'required',
            'fornecedor' => 'required',
            'peso' => 'required|numeric',
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

    public function DeleteProduct($id)
    {
        // Encontre o produto pelo ID ou lance uma exceção se não for encontrado
        $product = Product::findOrFail($id);
    
        // Exclua as imagens associadas ao produto
        if ($product->images) {
            foreach ($product->images as $image) {
                // Verifique se o arquivo existe antes de tentar excluí-lo
                if (file_exists(public_path('product_images/' . $image->image))) {
                    unlink(public_path('product_images/' . $image->image));
                    $image->delete();
                }
            }
        }
    
        // Exclua os registros relacionados no estoque
        Stock::where('product_id', $id)->delete();
    
        // Exclua os registros relacionados em order_item
        // Adicione a lógica para excluir os itens de pedido associados
        OrderItem::where('product_id', $id)->delete();
    
        // Finalmente, exclua o produto
        $product->delete();
    
        // Redirecione para a rota allproducts com uma mensagem de sucesso
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
