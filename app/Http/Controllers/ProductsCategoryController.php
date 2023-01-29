<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProductsCategoryController extends Controller
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
        //TODO:USE Model for insert or getting values

        return view('pages.products_category.show_products_category')->with('result', ProductsCategory::get());
    }

    public function create(Request $request)
    {

        return view('pages.products_category.create_products_category')->with('outlets', Outlet::get());
    }


    public function store(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = session('outlet_id');
        unset($request['_token']); //Remove Token
        $request->validate([
            'product_category_name' => 'required'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = 'null.png';
        }

        $request->request->add(['product_category_image' => $image_name, 'outlet_id' => $outlet_id]);
        //return $request->all();
        try {
            ProductsCategory::create($request->except('image'));
            return redirect('/product/category/show')->with('success', "Products Category Save");
        } catch (\Exception $exception) {
            //echo$exception->getMessage();
            return redirect('/product/category/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(ProductsCategory $productsCategory)
    {
        //
    }


    public function edit($product_category_id)
    {
        return view('pages.products_category.edit_products_category')->with('result', ProductsCategory::where('product_category_id', $product_category_id)->first());
    }

    public function update(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = session('outlet_id');
        $product_category_id = $request['product_category_id'];
        unset($request['_token']); //Remove Token
        unset($request['product_category_id']);//Remove token

        $request->validate([
            'product_category_name' => 'required'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = $request['image_name'];
            $destinationPath = public_path('/images/category');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = $request['image_name'];
        }


        unset($request['image_name']);//Remove token
        $request->request->add(['product_category_image' => $image_name]);

        //return $request->all();
        try {

            ProductsCategory::where('product_category_id', $product_category_id)->update($request->except('image'));
            return redirect('/product/category/show')->with('success', "Products Category Updated");
        } catch (\Exception $exception) {
            return redirect('/product/category/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }

    public function destroy($product_category_id)
    {
        try {
            ProductsCategory::where('product_category_id', $product_category_id)->delete();
            return back()->with('success', "Product Category Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
