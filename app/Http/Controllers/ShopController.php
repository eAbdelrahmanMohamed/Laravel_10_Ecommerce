<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);
        $pagesize = $request->query('pagesize', 12);
        $order = $request->query('order');
        $q_brands = $request->query('q_brands');
        $prange = !$request->query('prange') ? "0,500" : $request->query('prange');
        $new_range = explode(",", $prange);
        $from = $new_range[0];
        $to = $new_range[1];
        $q_categories = $request->query('q_categories');

        $query = Product::query();

        switch ($order) {
            case "1":
                $query->orderBy('created_at', 'ASC');
                break;
            case "3":
                $query->orderBy('regular_price', 'ASC');
                break;
            case "4":
                $query->orderBy('regular_price', 'DESC');
                break;
            default:
                $query->orderBy('created_at', 'DESC');
                break;
        }

        if ($q_brands && !empty($q_brands)) {
            $b_array = explode(',', $q_brands);
            $query->whereIn('brand_id', $b_array);
        }

        if ($q_categories && !empty($q_categories)) {
            $c_array = explode(',', $q_categories);
            $query->whereIn('category_id', $c_array);
        }

        if ($prange) {
            $query->whereBetween('regular_price', array($from, $to));
        }
        // if ($prange) {
        //     $query->where(function ($q) use ($from, $to) {
        //         $q->whereBetween('regular_price', [$from, $to])
        //             ->orWhereBetween('sale_price', [$from, $to]);
        //     });
        // }

        $products = $query->paginate($pagesize);
        $price_range = array('from' => $from, 'to' => $to);
        $brands = Brand::all();
        $categories = Category::all();

        return view('shop', compact('products', 'brands', 'categories', 'page', 'pagesize', 'order', 'q_brands', 'q_categories', 'price_range'));
    }
    function UpdateCartWishlistCount(Request $request)
    {
        $object = $request->query('type');
        $count = Cart::instance($object)->content()->count();
        return response()->json(['status' => 200, 'count' => $count]);
    }

    // public function index(Request $request)
    // {
    //     $page = $request->query('page');
    //     if (!$page) $page = 1;
    //     $pagesize = $request->query('pagesize');
    //     if (!$pagesize) $pagesize = 12;
    //     $order = $request->query('order');
    //     // if (!$order || $order == "-1") $order = 'DESC';
    //     // dd($pagesize);
    //     $q_brands=$request->query('brands');
    //     $category = Category::all();
    //     $brands = Brand::all();
    //     if (!$order) {
    //         $products = Product::orderBy('created_at', 'DESC')->paginate($pagesize);
    //     } else {
    //         switch ($order) {
    //             case "-1":
    //                 $products = Product::orderBy('created_at', 'DESC')->paginate($pagesize);
    //                 break;
    //             case "1":
    //                 $products = Product::orderBy('created_at', 'ASC')->paginate($pagesize);
    //                 break;
    //             case "3":
    //                 $products = Product::orderBy('regular_price', 'ASC')->paginate($pagesize);
    //                 break;
    //             case "4":
    //                 $products = Product::orderBy('regular_price', 'DESC')->paginate($pagesize);
    //                 break;
    //             default:
    //                 $products = Product::orderBy('created_at', 'DESC')->paginate($pagesize);
    //                 break;
    //         }
    //     }
    //     // if (!$order || $order == "-1") $order = 'DESC';

    //     return view('shop', ['products' => $products, 'brands' => $brands, 'categories' => $category,  'page' => $page, 'pagesize' => $pagesize, 'order' => $order ,'q_brands'=>$q_brands]);
    // }
    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $brand_products = Product::where('brand_id', $product->brand_id)->inRandomOrder('id')->get()->take(8);
        return view('detail', ["product" => $product, "brand_products" => $brand_products]);
    }
}
