<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OutletController extends Controller
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
        return view('pages.outlets.show_outlets')->with('result', Outlet::get());
    }


    public function create()
    {
        return view('pages.outlets.create_outlets');
    }


    public function store(Request $request)
    {

        unset($request['_token']);//Remove token
        //return $request->all();

        $request->validate([
            'outlet_name' => 'required',
            'outlet_phone' => 'required|unique:outlets'
        ]);

        try {
            Outlet::create($request->all());
            return back()->with('success', "Outlet saved");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Outlet $outlet)
    {
        //
    }


    public function edit($outlet_id)
    {
        return view('pages.outlets.edit_outlets')->with('result', Outlet::where('outlet_id', $outlet_id)->first());
    }


    public function update(Request $request)
    {
        $outlet_id = $request['outlet_id'];
        unset($request['_token']);//Remove token
        unset($request['outlet_id']);//Remove token
        //return $request->all();

        if ($request->hasFile('outlet_image')) {

            $outlet_image = $request->file('outlet_image');
            $outlet_image_name = time() . '.' . $outlet_image->getClientOriginalExtension();
            $destinationPath = public_path('/image/');
            $outlet_image->move($destinationPath, $outlet_image_name);
        } else {
            $outlet_image_name = $request['product_outlet_image'];
        }


        $outlet_array = array(
            'outlet_name' => $request['outlet_name'],
            'outlet_phone' => $request['outlet_phone'],
            'outlet_address' => $request['outlet_address'],
            'outlet_image' => $outlet_image_name
        );
        try {
            Outlet::where('outlet_id', $outlet_id)->update($outlet_array);

            $request->session()->put('outlet_image', $outlet_image_name);
            $request->session()->put('outlet_name', $request['outlet_name']);
            $request->session()->put('outlet_phone', $request['outlet_phone']);
            $request->session()->put('outlet_address', $request['outlet_address']);

            return back()->with('success', "Outlet updated");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($outlet_id)
    {
        try {
            Outlet::where('outlet_id', $outlet_id)->delete();
            return back()->with('success', "Outlet Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
