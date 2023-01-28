<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
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
        //return  User::get();
        return view('pages.user.show_user')->with('result', User::get());
    }


    public function create()
    {

        return view('pages.user.create_user')->with('roles', Role::get());
    }


    //Need to update below functions
    public function store(Request $request)
    {

        $role_id = $request['user_type'];
        unset($request['_token']);
        $request->validate([
            'user_phone' => 'required',
            'password' => 'required'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = 'null.png';
        }

        $request['password'] = Hash::make($request['password']);

        $request->request->add(['user_image' => $image_name, 'role_id' => $role_id]);

        // return $request->all();

        try {
            User::create($request->except('image'));
            return back()->with('success', "New User Created");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Vat $vat)
    {
        //
    }


    public function edit($user_id)
    {
        return view('pages.user.edit_user')->with('result', User::where('user_id', $user_id)->first());
    }


    public function update(Request $request)
    {

        $user_id = $request['user_id'];
        unset($request['_token']); //Remove Token
        unset($request['user_id']);//Remove token
        $request->validate([
            'user_email' => 'required',
            /* 'password' => 'required'*/
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = $request['image_name'];
        }
        if($request['password']!=null){
            $request->request->add(['password' => Hash::make($request['password']),]);
        }else{
            unset($request['password']);//Remove token
        }

        $request['password'] = Hash::make($request['password']);
        unset($request['image_name']);//Remove token
        $request->request->add(['user_image' => $image_name]);

        //return $request->all();
        try {

            User::where('user_id', $user_id)->update($request->except('image'));
            return redirect('/user/show')->with('success', "User Details Updated");
        } catch (\Exception $exception) {
            return redirect('/user/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }

    }

    public function destroy($user_id)
    {
        try {
            User::where('user_id', $user_id)->delete();
            return back()->with('success', "User Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
