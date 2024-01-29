<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;

class ProductController extends Controller
{
    public function add(){
        $r=request(); //get data from html input
        if($r->file('productImage')!=''){ 
            $image=$r->file('productImage');
            $image->move('images', $image->getClientOriginalName()); 
            $imageName=$image->getClientOriginalName(); 
        }
        else{
            $imageName="empty.jpg";
        }
        $add=Product::create([
            'name'=>$r->productName,
            'description'=>$r->productDescription,
            'quantity'=>$r->productQuantity,
            'price'=>$r->productPrice,
            'categoryID'=>'1',
            'image'=>$imageName,
        ]);
        return redirect()->route('showProduct');
    }

    public function view(){
        $viewProduct=Product::all(); //SQL "select * from products"
        return view('showProduct')->with('products',$viewProduct);
    }

    public function delete($id){
        $product=Product::find($id);
        $product->delete(); //SQL "delete from products where id='$id'
        return redirect()->route('showProduct');
    }

    public function edit($id){
        $editProduct=Product::all()->where('id',$id); //SQL "select * from products where id='$id
        return view('editProduct')->with('products',$editProduct);
    }

    public function productDetail($id){
        $editProduct=Product::all()->where('id',$id);
        return view('showProductDetail')->with('products',$editProduct);
    }

    public function update(){
        $r=request();
        $product=Product::find($r->id);
        if($r->file('productImage')!=''){ 
            $image=$r->file('productImage');
            $image->move('images', $image->getClientOriginalName()); 
            $imageName=$image->getClientOriginalName(); 
            $product->image=$imageName;
        }
        $product->name=$r->productName;
        $product->description=$r->productDescription;
        $product->price=$r->productPrice;
        $product->quantity=$r->productQuantity;
        $product->categoryID=$r->CategoryID;
        $product->save();
        return redirect()->route('showProduct');
    }

    public function allProduct(Request $request){
        $searchQuery = $request->input('search');

        if ($searchQuery) {
            // If search query is provided, perform search
            $products = Product::where('name', 'like', '%' . $searchQuery . '%')->get();
            return view('search', ['products' => $products, 'searchQuery' => $searchQuery]);
        } else {
            // If no search query, retrieve all products from the database
            $allProduct = Product::all();
            return view('allProduct')->with('products', $allProduct);
        }
    }

    public function search(Request $request){
        $searchQuery = $request->input('search');
        $products = Product::where('name', 'like', '%' . $searchQuery . '%')->get();

        return view('search', ['products' => $products, 'searchQuery' => $searchQuery]);
    }
}
