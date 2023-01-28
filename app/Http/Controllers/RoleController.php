<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RoleController extends Controller
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
        return view('pages.role.show_role')->with('result', Role::get());
    }


    public function create()
    {
        return view('pages.role.create_role');
    }


    public function store(Request $request)
    {
        unset($request['_token']);
        $request->validate([
            'role_name' => 'required'
        ]);

        try {
            Role::create($request->all());
            return redirect('/user/role/show')->with('success', "User Role Save");
        } catch (\Exception $exception) {
            return redirect('/user/role/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }

    public function show(Role $role)
    {
        //
    }


    public function edit($role_id)
    {
        return view('pages.role.edit_role')->with('result', Role::where('role_id', $role_id)->first());
    }


    public function update(Request $request)
    {
        $role_id = $request['role_id'];
        unset($request['_token']); //Remove Token
        unset($request['role_id']);//Remove token

        $request->validate([
            'role_name' => 'required'
        ]);

        //return $request->all();
        try {

            Role::where('role_id', $role_id)->update($request->all());
            return redirect('/user/role/show')->with('success', "User Role Updated");
        } catch (\Exception $exception) {
            return redirect('/user/role/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($role_id)
    {
        try {
            Role::where('role_id', $role_id)->delete();
            return back()->with('success', "User Role Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
