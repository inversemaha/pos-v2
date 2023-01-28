<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Sell;
use App\Models\SellItem;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
        $date = date('Y-m-d');
        $month = date('Y-m');
        $total_sell = SellItem::where('created_at', 'like', '%' . $date . '%')->count();
        $grand_total_price = Sell::where('created_at', 'like', '%' . $date . '%')->sum('grand_total_price');
        $total_expense = Expense::where('created_at', 'like', '%' . $date . '%')->sum('expense_amount');
        $sells = Sell::
        join('customers', 'customers.customer_id', '=', 'sells.customer_id')
            ->select('customers.customer_name', 'sells.grand_total_price', 'sells.paid_status', 'sells.invoice', 'sells.created_at')
            ->orderBy('sells.created_at', 'DESC')
            ->limit(15)
            ->get();
        $this_month_total_sell = Sell::where('created_at', 'like', '%' . $month . '%')->sum('grand_total_price');
        return view('pages.home.index')
            ->with('grand_total_price', $grand_total_price)
            ->with('total_expense', $total_expense)
            ->with('total_sell', $total_sell)
            ->with('this_month_total_sell', $this_month_total_sell)
            ->with('sells', $sells);
    }

    public function profile()
    {
        $result = User::where('user_id', Session::get('user_id'))->first();
        return view('pages.setting.profile')->with('result', $result);
    }

    public function profileUpdate(Request $request)
    {

        $user_id = $request['user_id'];
        unset($request['_token']); //Remove Token
        unset($request['user_id']);//Remove token
        $request->validate([
            'user_email' => 'required',
            'password' => 'required'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/admin');
            $image->move($destinationPath, $image_name);
        } else {

            $image_name = $request['product_image'];
        }

        $request->session()->put('user_image', $image_name);
        unset($request['image_name']);//Remove token
        $request->request->add(['user_image' => $image_name]);
        $request->request->add(['password' => Hash::make($request['password']),]);

        //return $request->all();
        try {

            User::where('user_id', $user_id)->update($request->except('image'));
            return back()->with('success', "User Details Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }
}
