<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;
use Cart;

class WishListController extends Controller
{
    public function index()
    {
        $Items = Cart::instance('wishlist')->content();
        return view('wishlist', ['items' => $Items]);
    }
    public function addProductToWishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Product');
        return response()->json(['status' => 200, 'message' => 'Success ! Item added to Wishlist']);
    }
    public function updatewishlist(request $request)
    {
        Cart::instance('wishlist')->update($request->rowId, $request->quantity);
        return redirect()->route('wishlist');
    }
    public function removefromwishlist(request $request)
    {
        Cart::instance('wishlist')->remove($request->rowId);
        return redirect()->route('wishlist');
    }
}
