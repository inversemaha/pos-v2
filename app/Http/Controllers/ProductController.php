<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Vtiful\Kernel\Excel;

class ProductController extends Controller
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
        $result = Product::
        join('product_details', 'products.product_id', '=', 'product_details.product_id')
            ->join('products_categories', 'products_categories.product_category_id', '=', 'products.product_category_id')
            ->get();
        return view('pages.products.show_products')->with('result', $result);
    }

    /*
        public function payment(Request $request)
        {
            $data = [
                'status' => 'success',
                'message' => 'successfully send data in ProductController payment',
                'data' => $request['productList'],
            ];

            // todo ::  $request['productList'] contains productList so catch value use foreach and save it..

            return $data;
        }*/

    public function create(Request $request)
    {
        return view('pages.products.create_products')->with('category', ProductsCategory::get());
    }


    public function store(Request $request)
    {

        $request->validate([
            'product_title' => 'required',
            'product_category_id' => 'required',
            'product_purchase_price' => 'required|numeric',
            'product_retail_price' => 'required|numeric'
        ]);

        $outlet_id = session('outlet_id');
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/products');
            $image->move($destinationPath, $image_name);
        } else {

            $image_name = "null.png";
        }

        $product_array = array(
            /*   'product_name' => $request['product_name'],*/
            'product_name' => $request['product_title'],
            'product_category_id' => $request['product_category_id'],
            'product_description' => $request['product_description'],
            'product_image' => $image_name,
            'outlet_id' => $outlet_id
        );

        $product_details_array = array(
            'barcode' => $request['barcode'],
            'product_title' => $request['product_title'],
            'product_purchase_price' => $request['product_purchase_price'],
            'product_retail_price' => $request['product_retail_price'],
            'outlet_id' => $outlet_id
        );

        try {
            $product_id = Product::insertGetId($product_array);
            if ($product_id > 0) {
                $product_details_array['product_id'] = $product_id;
                ProductDetail::create($product_details_array);
            }
            //return $product_details_array;
            return redirect('/products/show')->with('success', "Products Save");
        } catch (\Exception $exception) {
            //return $exception->getMessage();
            return redirect('/products/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Product $product)
    {

    }


    public function edit($product_id)
    {
        return view('pages.products.edit_products')
            ->with('categories', ProductsCategory::get())
            ->with('product', Product::join('product_details', 'products.product_id', '=', 'product_details.product_id')
                ->where('products.product_id', $product_id)
                ->first());
    }


    public function update(Request $request)
    {

        // return $request->all();
        $product_details_id = $request['product_details_id'];

        $product_id = $request['product_id'];

        // $request->validate([
        //     'product_name' => 'required',
        //     'product_category_id' => 'required',
        //     'product_purchase_price' => 'required',
        //     'product_retail_price' => 'required'
        // ]);


        $outlet_id = session('outlet_id');

        // if ($request->hasFile('image')) {

        //     $image = $request->file('image');
        //     $image_name = time() . '.' . $image->getClientOriginalExtension();
        //     $destinationPath = public_path('/images/products');
        //     $image->move($destinationPath, $image_name);
        // } else {

        //     $image_name = $request['image_name'];
        // }
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/products');
            $image->move($destinationPath, $image_name);
        } else {

            $image_name = $request['product_image'];
            // return 11111;
        }
        $product_array = array(
            'product_name' => $request['product_title'],
            'product_category_id' => $request['product_category_id'],
            'product_description' => $request['product_description'],
            'product_image' => $image_name,
            'outlet_id' => $outlet_id
        );
        // return $product_array;



        $product_details_array = array(
            'barcode' => $request['barcode'],
            'product_title' => $request['product_title'],
            'product_purchase_price' => $request['product_purchase_price'],
            'product_retail_price' => $request['product_retail_price'],
            'outlet_id' => $outlet_id,
            'product_id' => $product_id
        );

        try {


            Product::where('product_id', $product_id)->update($product_array);


            ProductDetail::where('product_details_id', $product_details_id)->update($product_details_array);
            //return $product_details_array;
            return redirect('/products/show')->with('success', "Product Updated");
        } catch (\Exception $exception) {

            //return $exception->getMessage();
            return redirect('/products/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($product_id, $product_detail_id)
    {
        try {
            ProductDetail::where('product_details_id', $product_detail_id)->delete();
            if (ProductDetail::where('product_details_id', $product_detail_id)->count() <= 0) {
                Product::where('product_id', $product_id)->delete();
                echo "product deleted";
            }
            return back()->with('success', "Product Deleted");
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }


    }


    public function import(Request $request)
    {
        return view('pages.products.import');
    }

    public function save(Request $request)
    {
        $outlet_id = session('outlet_id');
        $success = 0;


        try {
            if ($request->hasFile('import_file')) {
                $path = $request->file('import_file')->getRealPath();
                $data = Excel::load($path, function ($reader) {
                    $reader->formatDates(true);
                })->get();

                //return $data->count();
                foreach ($data as $key => $value) {
                    $barcode = $value->barcode;
                    $product_name = $value->name;
                    $product_category_id = $value->category;
                    $product_description = $value->description;
                    $product_title = $value->title;
                    $product_purchase_price = $value->purchase;
                    $product_retail_price = $value->price;

                    $product_array = array(
                        'product_name' => $product_name,
                        'product_category_id' => $product_category_id,
                        'product_description' => $product_description,
                        'product_image' => null,
                        'outlet_id' => $outlet_id
                    );

                    $product_details_array = array(
                        'barcode' => $barcode,
                        'product_title' => $product_title,
                        'product_purchase_price' => $product_purchase_price,
                        'product_retail_price' => $product_retail_price,
                        'outlet_id' => $outlet_id
                    );

                    $status = $this->saveProduct($product_array, $product_details_array);
                    if ($status == true) {
                        $success++;
                    }
                }
            }


            return back()->with('success', "Total " . $success . " Product added");

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    private function saveProduct($product_array, $product_details_array)
    {
        try {
            $product_id = Product::insertGetId($product_array);
            if ($product_id > 0) {
                $product_details_array['product_id'] = $product_id;
                ProductDetail::create($product_details_array);
                return true;
            }

        } catch (\Exception $exception) {
            //echo$exception->getMessage();
            return false;
        }
    }
}
