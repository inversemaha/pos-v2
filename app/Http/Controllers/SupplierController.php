<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SupplierController extends Controller
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
        return view('pages.supplier.show_supplier')->with('result', Supplier::get());
    }


    public function create(Request $request)
    {
        return view('pages.supplier.create_supplier')->with('outlets', Outlet::get());
    }


    public function store(Request $request)
    {

        //return $request->all();
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id =session('outlet_id');
        unset($request['_token']); //Remove Token
        $request->validate([
            'supplier_name' => 'required'
        ]);

        $request->request->add(['outlet_id' => $outlet_id]);
        try {
            Supplier::create($request->all());
            return redirect('/supplier/show')->with('success', "Supplier Save");
        } catch (\Exception $exception) {
            return redirect('/supplier/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Supplier $supplier)
    {
        //
    }


    public function edit($supplier_id)
    {
        return view('pages.supplier.edit_supplier')->with('result', Supplier::where('supplier_id', $supplier_id)->first());
    }


    public function update(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = session('outlet_id');
        $supplier_id = $request['supplier_id'];
        unset($request['_token']); //Remove Token
        unset($request['supplier_id']);//Remove token

        $request->validate([
            'supplier_name' => 'required'
        ]);

        //return $request->all();
        try {

            Supplier::where('supplier_id', $supplier_id)->update($request->all());
            return redirect('/supplier/show')->with('success', "Supplier Updated");
        } catch (\Exception $exception) {
            return redirect('/supplier/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($supplier_id)
    {
        try {
            Supplier::where('supplier_id', $supplier_id)->delete();
            return redirect('/supplier/show')->with('success', "Supplier Deleted");
        } catch (\Exception $exception) {
            return redirect('/supplier/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
