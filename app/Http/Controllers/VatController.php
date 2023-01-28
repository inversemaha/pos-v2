<?php

namespace App\Http\Controllers;

use App\Models\ProductsCategory;
use App\Models\Vat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class VatController extends Controller
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
        return view('pages.vat.show_vat_rate')->with('result', Vat::get());
    }


    public function create()
    {
        return view('pages.vat.create_vat_rate');
    }


    public function store(Request $request)
    {
        unset($request['_token']);
        $request->validate([
            'vat_rate' => 'required'
        ]);

        try {
            Vat::create($request->all());
            return redirect('/vat/show')->with('success', "Vat Rate Save");
        } catch (\Exception $exception) {
            return redirect('/vat/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Vat $vat)
    {
        //
    }


    public function edit($vat_id)
    {
        return view('pages.vat.edit_vat_rate')->with('result', Vat::where('vat_id', $vat_id)->first());
    }


    public function update(Request $request)
    {
        $vat_id = $request['vat_id'];
        unset($request['_token']); //Remove Token
        unset($request['vat_id']);//Remove token

        $request->validate([
            'vat_id' => 'required'
        ]);

        //return $request->all();
        try {

            Vat::where('vat_id', $vat_id)->update($request->all());
            return redirect('/vat/show')->with('success', "Vat Rate Updated");
        } catch (\Exception $exception) {
            return redirect('/vat/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }

    public function destroy($vat_id)
    {
        try {
            ProductsCategory::where('vat_id', $vat_id)->delete();
            return back()->with('success', "Vat Rate Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
