<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{

    public function __construct()
    {

        //$this->middleware('auth');
        if (Auth::check()) {
            return Redirect::to('/admin-home');
        }
    }


    public function forgetPassword()
    {
        return view('pages.login.forget_password');
    }

    public function index()
    {
        return view('home');
    }

    public function doLogin(Request $request)
    {
        $user_email = $request['user_email'];
        $password = $request['password'];
        $remember = true;
        // attempt to do the login
        if (Auth::attempt(['user_email' => $user_email, 'password' => $password], $remember)) {

            $user = User::where('user_email', $user_email)->first();
            $request->session()->put('outlet_id', $user->outlet_id);
            $request->session()->put('user_id', $user->user_id);
            $request->session()->put('user_image', $user->user_image);

            $outlet = Outlet::where('outlet_id', $user->outlet_id)->first();
            $request->session()->put('outlet_name', $outlet->outlet_name);
            $request->session()->put('outlet_image', $outlet->outlet_image);
            $request->session()->put('outlet_phone', $outlet->outlet_phone);
            $request->session()->put('outlet_address', $outlet->outlet_address);

            return Redirect::to('/admin-home');
        } else {
            return back()->with('failed', "Email or password does not match");

        }
        //Auth::logout(); // log the user out of our application
    }

    public function doPassordReset(Request $request)
    {


        return back()->with('failed', "For security purpose you cant update password. Please Contact with Admin");

        $is_exist = User::where('user_email', $request['user_email'])->first();
        if (is_null($is_exist)) {
            return back()->with('failed', "Admin not Found");
        }
        try {
            $password = getPassword(6);
            mail($request['user_email'], 'Forget Password', "Your new Password is: " . $password);


            User::where('user_email', $request['user_email'])->update([
                'password' => Hash::make($password)
            ]);
            return Redirect::to('/admin-home');
        } catch (\Exception $exception) {
            return back()->with('failed', "Email or password does not match");

        }
        //Auth::logout(); // log the user out of our application
    }

    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('/');
    }
}
