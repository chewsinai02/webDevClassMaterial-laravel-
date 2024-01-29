<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\myCart;
use Auth;
use section;

class CartController extends Controller
{
    public function __construct(){
        $this->middleware('auth'); //require login before acess contoller
    }

    public function addToCart(){
        $r = request();

        // Check if the product is already in the cart for the current user
        $existingCartItem = myCart::where('productID', $r->id)
            ->where('userID', Auth::id())
            ->first();

        if ($existingCartItem) {
            // If the product is already in the cart, increment the quantity
            $existingCartItem->increment('quantity');
        } else {
            // If the product is not in the cart, create a new cart record
            myCart::create([
                'quantity' => 1,
                'orderID' => '',
                'productID' => $r->id,
                'dataAdd' => '',
                'userID' => Auth::id(),
            ]);
        }
        return redirect()->route('myCart'); //return to myCart page
        }
    
        public function addCart(){
            $r = request();
            
            // Check if the product is already in the cart for the current user
            $existingCartItem = myCart::where('productID', $r->id)
                ->where('userID', Auth::id())
                ->first();
        
            if ($existingCartItem) {
                // If the product is already in the cart, increment the quantity
                // read quantity from the request and ensure it's numeric
                $quantityToAdd = is_numeric($r->quantity) ? $r->quantity : 0;
                $existingCartItem->increment('quantity', $quantityToAdd);
            } else {
                // If the product is not in the cart, create a new cart record
                myCart::create([
                    'quantity' => $r->quantity,
                    'orderID' => '', 
                    'productID' => $r->id,
                    'dataAdd' => '',
                    'userID' => Auth::id(),
                ]);
            }
            return redirect()->route('myCart'); //return to myCart page
        }
        

    public function view(){
        $cart=DB::table('my_carts')->leftjoin('products','products.id','=','my_carts.productId')
        ->select('my_carts.quantity as cartQty','my_carts.id as cid','products.*')
        ->where('my_carts.orderID','=','')
        ->where('my_carts.userID','=',Auth::id())
        ->get();
        (new CartController)->cartItem();
        return view('myCart')->with('cart',$cart);
    }

    public function cartItem(){
        $cartItem=0;
        $noItem=DB::table('my_carts')->leftjoin('products','products.id','=','my_carts.productId')
        ->select(DB::raw('COUNT(*) as count_item'))
        ->where('my_carts.orderID','=','')
        ->where('my_carts.userID','=',Auth::id())
        ->groupBy('my_carts.userID')
        ->first();
        if($noItem){
            $cartItem=$noItem->count_item;
        }
        Session()->put('cartItem',$cartItem);
    }
}
