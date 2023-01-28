<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use App\Models\Purchase;
use App\Models\StockHistory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
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


        $result = StockHistory::join('products', 'products.product_id', '=', 'stock_histories.product_details_id')
            ->leftJoin('suppliers', 'suppliers.supplier_id', '=', 'stock_histories.supplier_id')
            ->get();

        return view('pages.purchase.show_purchase')->with('result', $result);


    }


    public function create()
    {
        $result = ProductDetail::join('products', 'products.product_id', '=', 'product_details.product_id')->get();
        return view('pages.purchase.create_purchase')
            ->with('suppliers', Supplier::get())
            ->with('product', $result);
    }


    public function store(Request $request)
    {

        $user_id = session('user_id');
        unset($request['_token']);
        $request->validate([
            'quantity' => 'required',
            'total_price' => 'required'
        ]);
        $request->request->add(['user_id' => $user_id]);
        $data = Purchase::where('product_details_id', $request['product_details_id'])->first();
        try {
            if (!is_null($data)) {

                DB::table('purchases')->increment('quantity', $request['quantity']);
                DB::table('purchases')->increment('total_price', $request['total_price']);


            } else {
                Purchase::create($request->except('_token'));
            }
            StockHistory::create($request->except('_token'));

            return redirect('/purchase/show')->with('success', "Purchase Save");
        } catch (\Exception $exception) {
            return redirect('/purchase/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Purchase $purchase)
    {
        //
    }


    public function edit($purchase_id)
    {
        return view('pages.purchase.edit_purchase')
            ->with('suppliers', Supplier::get())
            ->with('product', ProductDetail::get())
            ->with('purchase', Purchase::join('product_details', 'product_details.product_details_id', '=', 'purchases.product_details_id')
                ->where('purchases.purchase_id', $purchase_id)
                ->first());
    }

    public function update(Request $request, Purchase $purchase)
    {
        $purchase_id = $request['purchase_id'];
        unset($request['_token']); //Remove token
        unset($request['purchase_id']);

        $request->validate([
            'quantity' => 'required',
            'total_price' => 'required'
        ]);

        //return $request->all();

        try {
            Purchase::where('purchase_id', $purchase_id)->update($request->all());
            return redirect('/purchase/show')->with('success', "Purchase Save");
        } catch (\Exception $exception) {
            return redirect('/purchase/show')->with('failed', "There Was a Problem" . $exception->getMessage());
        }
    }


    public function destroy($purchase_id)
    {
        try {
            Purchase::where('purchase_id', $purchase_id)->delete();
            return redirect('/purchase/show')->with('success', "Purchase Details Deleted");
        } catch (\Exception $exception) {
            return redirect('/purchase/show')->with('failed', "There Was a Problem" . $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        $from_date = getFormatteddate($request['from_date']);
        $to_date = getFormatteddate($request['to_date']);
        if ($from_date != $to_date) {
            $result = Purchase::whereBetween('created_at', [$from_date, $to_date])
                ->get();

        } else {
            $result = Purchase::whereDate('created_at', $from_date)
                ->get();

        }

        return view('pages.purchase.show_purchase')->with('result', $result);
    }
}
