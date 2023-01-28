<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        return view('pages.customer.show_customer')->with('result', Customer::get());
    }

    public function create()
    {
        return view('pages.customer.create_customer')->with('outlets', Outlet::get());
    }


    public function store(Request $request)
    {
        //return $request->all();
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = session('outlet_id');
        unset($request['_token']); //Remove Token
        $request->validate([
            'customer_name' => 'required'
        ]);

        $request->request->add(['outlet_id' => $outlet_id]);
        //return $request->all();
        try {
            Customer::create($request->all());
            return redirect('/customer/show')->with('success', "Customer Save");
        } catch (\Exception $exception) {
            return redirect('/customer/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }

    public function getCustomer(Request $request)
    {

        try {
            $customers =Customer::get();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved',
                'customers' => $customers
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'customers' => null,
                'message' => 'There was a problem' . $exception->getMessage(),
            ], 200);
        }
    }

    public function storeCustomer(Request $request)
    {

        $outlet_id = session('outlet_id');
        $request->request->add(['outlet_id' => $outlet_id]);

        try {
            Customer::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Saved',
                'response' => $request->all(),
            ], 200);

        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage(),
                'response' => $request->all(),
            ], 200);

        }
    }


    public function show(Customer $customer)
    {
        //
    }


    public function edit($customer_id)
    {
        return view('pages.customer.edit_customer')->with('result', Customer::where('customer_id', $customer_id)->first());
    }


    public function update(Request $request)
    {//OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        // $outlet_id = session('outlet_id');
        $customer_id = $request['customer_id'];
        unset($request['_token']); //Remove Token
        unset($request['customer_id']);//Remove token

        $request->validate([
            'customer_name' => 'required'
        ]);

        //return $request->all();
        try {

            Customer::where('customer_id', $customer_id)->update($request->all());
            return redirect('/customer/show')->with('success', "Customer Updated");
        } catch (\Exception $exception) {
            return redirect('/customer/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }

    public function destroy($customer_id)
    {
        try {
            Customer::where('customer_id', $customer_id)->delete();
            return redirect('/customer/show')->with('success', "Customer Deleted");
        } catch (\Exception $exception) {
            return redirect('/customer/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
