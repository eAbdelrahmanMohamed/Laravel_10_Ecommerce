<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart; 

class CartController extends Controller
{
    public function index(){
        $CartItems=Cart::instance('cart')->content();
        return view('cart',['items'=>$CartItems]);
    }
    public function addtocart(Request $Request){
        $product=Product::find($Request->id);
        $price=$product->sale_price?$product->sale_price:$product->regular_price;
        Cart::instance('cart')->add($product->id,$product->name,$Request->quantity,$price)->associate('App\Models\Product');
        return redirect()->back()->with('message','product successfully added');
    }
    public function updatecart(request $request){
        Cart::instance('cart')->update($request->rowId,$request->quantity);
        return redirect()->route('cart');
    }
    public function removefromcart(request $request){
        Cart::instance('cart')->remove($request->rowId);
        return redirect()->route('cart');
    }
}