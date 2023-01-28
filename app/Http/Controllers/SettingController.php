<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{


    public function __construct()
    {

        //$this->middleware('auth');
        if (Auth::check()) {
            return Redirect::to('/admin-home');
        }
    }

    public function shopSetting()
    {
        $outlet = Outlet::where('outlet_id', Session::get('outlet_id'))->first();
        return view('pages.setting.shop')->with('outlet', $outlet);
    }
    public function test()
    {
        return 77;
        $outlet = Outlet::where('outlet_id', Session::get('outlet_id'))->first();
        return view('pages.profitlos.test')->with('outlet', $outlet);
    }

}
