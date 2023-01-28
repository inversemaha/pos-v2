<?php

namespace App\Http\Controllers;

use App\Models\Profitlos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ProfitlosController extends Controller
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
        return view('pages.profitlos.show_profitlos')->with('result', Supplier::get());
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Profitlos $profitlos)
    {
        //
    }


    public function edit(Profitlos $profitlos)
    {
        //
    }

    public function update(Request $request, Profitlos $profitlos)
    {
        //
    }

    public function destroy(Profitlos $profitlos)
    {
        //
    }
}
