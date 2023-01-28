<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UnitController extends Controller
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
        return view('pages.unit.show_unit')->with('result', Unit::get());
    }


    public function create()
    {
        return view('pages.unit.create_unit');
    }

    public function store(Request $request)
    {
        unset($request['_token']);
        $request->validate([
            'unit_name' => 'required'
        ]);

        try {
            Unit::create($request->all());
            return redirect('/unit/show')->with('success', 'Units Created');
        } catch (\Exception $exception) {
            return redirect('/unit/show')->with('failed', 'There was a problem.' . $exception->getMessage());
        }
    }


    public function show(Unit $unit)
    {
        //
    }


    public function edit($unit_id)
    {
        return view('pages.unit.edit_unit')->with('result', Unit::where('unit_id',$unit_id)->first());
    }


    public function update(Request $request)
    {
        $unit_id = $request['unit_id'];
        unset($request['_token']);
        unset($request['unit_id']);

        try {
            Unit::where('unit_id',$unit_id)->update($request->all());
            return redirect('/unit/show')->with('success','Units Updated.');
        } catch (\Exception $exception) {
            return redirect('/unit/show')->with('failed','There was a problem. ' . $exception->getMessage());
        }

    }


    public function destroy($unit_id)
    {
        try {
            Unit::where('unit_id', $unit_id)->delete();
            return back()->with('success','Unit Deleted');
        } catch (\Exception $exception) {
            return back()->with('failed', 'There was a problem. ' . $exception->getMessage());
        }
    }
}
