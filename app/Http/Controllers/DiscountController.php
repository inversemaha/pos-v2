<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
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
    public function index()
    {
        $result = Discount::
        join('products', 'discounts.product_id', '=', 'products.product_id')
            ->get();
        return view('pages.discount.show_products_discount')->with('result', $result);
    }


    public function create()
    {
        return view('pages.discount.create_products_discount')->with('category', Product::get());
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'discount_rate' => 'required'
        ]);

        /*        $product_array = array(
                    'product_id' => $request['product_id'],
                    'discount_rate' => $request['discount_rate']
                );*/

        try {
            Discount::create($request->all());
            //return $product_array;
            return redirect('/sell/discount/show')->with('success', "Product Discount Save");
        } catch (\Exception $exception) {
            //return $exception->getMessage();
            return redirect('/sell/discount/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Discount $discount)
    {
        //
    }


    public function edit($discount_id)
    {
        return view('pages.discount.edit_products_discount')
            ->with('categories', Product::get())
            ->with('product', Discount::where('discounts.product_id', $discount_id)->first());
    }


    public function update(Request $request)
    {
        $discount_id = $request['discount_id'];
        unset($request['_token']); //Remove Token
        unset($request['discount_id']);

        $request->validate([
            'product_id' => 'required',
            'discount_rate' => 'required'
        ]);

        //return $request->all();

        try {
            Discount::where('discount_id', $discount_id)->update($request->all());
            return redirect('/sell/discount/show')->with('success', "Product Discount Update");
        } catch (\Exception $exception) {
            return redirect('/sell/discount/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($discount_id)
    {
        try {
            Discount::where('discount_id', $discount_id)->delete();
            return back()->with('success', "Product Discount Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
