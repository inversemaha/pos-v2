<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductsCategory;
use App\Models\Purchase;
use App\Models\SellItem;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PosController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return Redirect::to('/login');
            } else {
                if (!Session::get('user_id')) {
                    return Redirect::to('/logout');
                }
            }
            return $next($request);
        });
    }

    //
    function index()
    {

        $value = session('outlet_id');
        $products = Product::join('product_details', 'product_details.product_id', '=', 'products.product_id')
            ->get(['products.*',
                'product_details.product_details_id',
                'product_details.product_purchase_price',
                'product_details.product_retail_price',
                'products.product_category_id'

            ]);
        // return $products->all();

        // $product=Product::get();
        foreach($products as $item){
            $quantity= Purchase::where('product_details_id', $item->product_id)->sum('quantity');

            $sold_item=SellItem::where('product_id', $item->product_id)->sum('quantity');


            $item->quantity=$quantity-$sold_item;

        }
        //  return $products->all();

        $vat = Vat::first();
        $vat->vat_rate;
        return view('pages.pos.index')
            ->with('categories', ProductsCategory::get())
            ->with('users', Customer::get())
            ->with('vat', $vat->vat_rate)
            ->with('products', $products);
    }
}
