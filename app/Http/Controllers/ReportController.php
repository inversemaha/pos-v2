<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ingredient;
use App\Models\Purchase;
use App\Models\Sell;
use App\Models\SellItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
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

    public function profit(Request $request)
    {
        if ($request->isMethod('post')) {

            $from_date = getFormatteddate($request['from_date']);
            $to_date = getFormatteddate($request['to_date']);
            if($from_date != $to_date){
                $total_sell=  Sell::whereBetween('created_at', [$from_date, $to_date]) ->sum('grand_total_price');
                $total_expense = Expense::whereBetween('created_at', [$from_date, $to_date])->sum('expense_amount');
                $total_purchase = Purchase::whereBetween('created_at', [$from_date, $to_date])->sum('total_price');
                $total_ingredient_purchase = Ingredient::whereBetween('created_at', [$from_date, $to_date])->sum('total_price');
            }else{
                $total_sell=  Sell::whereDate('created_at', $from_date) ->sum('grand_total_price');
                $total_expense = Expense::whereDate('created_at',  $to_date)->sum('expense_amount');
                $total_purchase = Purchase::whereDate('created_at',  $to_date)->sum('total_price');
                $total_ingredient_purchase = Ingredient::whereDate('created_at',  $to_date)->sum('total_price');
            }

        } else {
            //return  view('pages.profitlos.test');
            $total_sell = Sell::sum('grand_total_price');
            $total_expense = Expense::sum('expense_amount');
            $total_purchase = Purchase::sum('total_price');
            $total_ingredient_purchase = Ingredient::sum('total_price');
        }

        $grand_total = $total_sell + $total_expense + $total_purchase + $total_sell - ($total_expense + $total_purchase+$total_ingredient_purchase);
        if ($grand_total <= 0) {
            $grand_total = 1;
        }


        return view('pages.report.show_profitlos')
            ->with('total_sell', $total_sell)
            ->with('total_expense', $total_expense)
            ->with('total_purchase', $total_purchase)
            ->with('total_ingredient_purchase', $total_ingredient_purchase)
            ->with('grand_total', $grand_total);
        // ->with('from_date',$from_date)
        // ->with('to_date',$to_date);
    }

    public function sellReport(Request $request)
    {
        /* return $result = Sell::
         join('customers', 'customers.customer_id', '=', 'sells.customer_id')
             ->join('users', 'users.user_id', '=', 'sells.seller_id')
             ->get();*/

        /* $from_date = $request['from_date'];
         $to_date = $request['to_date'];*/
        if ($request->isMethod('post')) {

            $from_date = $request['from_date'];
            $to_date = $request['to_date'];
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));
            if($from_date != $to_date){
                $result = Sell::
                whereBetween('sells.created_at', [$from_date, $to_date])
                    ->orderBy('sells.created_at', 'DESC')->get();
            }else{
                $result = Sell::
                wheredate('sells.created_at',$from_date)
                    ->orderBy('sells.created_at', 'DESC')->get();
            }

            return view('pages.report.sell')->with('result', $result);
        } else {
            $result = Sell:: orderBy('sells.created_at', 'DESC')->get();
            return view('pages.report.sell')->with('result', $result);
        }

    }
    public function dailySellReport(){

        $currentDate = Carbon::now();
        $currentDate = new Carbon();
        $today = Carbon::today();
        $result = Sell::wheredate('sells.created_at',$today)
            ->orderBy('sells.created_at', 'DESC')->get();
        return view('pages.report.sell')->with('result', $result);
    }

    public function sellByProductReport(Request $request)
    {

        if ($request->isMethod('post')) {
            $from_date = $request['from_date'];
            $to_date = $request['to_date'];
            $from_date = date('Y-m-d', strtotime($from_date));
            $to_date = date('Y-m-d', strtotime($to_date));

            if($from_date != $to_date){
                $products = DB::table('sell_items')
                    ->join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                    ->select('product_details.product_title')
                    ->groupBy('product_details.product_title')
                    ->whereBetween('sell_items.created_at', [$from_date, $to_date])
                    ->get();
            }else{
                $products = DB::table('sell_items')
                    ->join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                    ->select('product_details.product_title')
                    ->groupBy('product_details.product_title')
                    ->whereDate('sell_items.created_at', $from_date)
                    ->get();
            }


            if($from_date != $to_date){
                $result = SellItem::
                join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                    ->select('sell_items.product_id', 'product_details.product_title', 'sell_items.quantity', 'sell_items.created_at')
                    ->whereBetween('sell_items.created_at', [$from_date, $to_date])
                    ->get();
            }else{
                $result = SellItem::
                join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                    ->select('sell_items.product_id', 'product_details.product_title', 'sell_items.quantity', 'sell_items.created_at')
                    ->whereDate('sell_items.created_at', $from_date)
                    ->get();
            }

            return view('pages.report.product_sell')
                ->with('products', $products)
                ->with('result', $result)
                ->with('from_date',$from_date)
                ->with('to_date',$to_date);
        } else {
             $products = DB::table('sell_items')
                ->join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                ->select('product_details.product_title')
                ->groupBy('product_details.product_title')
                ->get();

            $result = SellItem::join('product_details', 'product_details.product_id', '=', 'sell_items.product_id')
                ->select('sell_items.product_id', 'product_details.product_title', 'sell_items.quantity', 'sell_items.created_at')
                ->get();

            return view('pages.report.product_sell')
                ->with('products', $products)
                ->with('result', $result);

        }

    }

    public function sellBySalesmanReport(Request $request)
    {

        $from_date = getFormatteddate($request['from_date']);
        $to_date = getFormatteddate($request['to_date']);

        $users = User::get();

        if ($request->isMethod('post')) {

            if($from_date != $to_date){
                $result = Sell::
                join('users', 'users.user_id', '=', 'sells.seller_id')
                    ->whereBetween('sells.created_at', [$from_date, $to_date])
                    ->get();
            }else{
                $result = Sell::
                join('users', 'users.user_id', '=', 'sells.seller_id')
                    ->whereDate('sells.created_at', $from_date)
                    ->get();
            }

        } else {
            $result = Sell::
            join('users', 'users.user_id', '=', 'sells.seller_id')
                ->get();
        }

        return view('pages.report.product_sell_by_salesman')
            ->with('users', $users)
            ->with('result', $result)
            ->with('from_date',$from_date)
            ->with('to_date',$to_date);
    }





    public function dailyProfitLoss(Request $request)
    {

        $currentDate = Carbon::now();
        $currentDate = new Carbon();
        $today = Carbon::today();

        //return  view('pages.profitlos.test');

        $total_sell=  Sell::whereDate('created_at', $today) ->sum('grand_total_price');
        $total_expense = Expense::whereDate('created_at',  $today)->sum('expense_amount');
        $total_purchase = Purchase::whereDate('created_at',  $today)->sum('total_price');
        $total_ingredient_purchase = Ingredient::whereDate('created_at',  $today)->sum('total_price');


        // $total_sell = Sell::sum('grand_total_price');
        // $total_expense = Expense::sum('expense_amount');
        // $total_purchase = Purchase::sum('total_price');
        // $total_ingredient_purchase = Ingredient::sum('total_price');


        $grand_total = $total_sell + $total_expense + $total_purchase + $total_sell - ($total_expense + $total_purchase+$total_ingredient_purchase);
        if ($grand_total <= 0) {
            $grand_total = 1;
        }


        return view('pages.report.show_profitlos')
            ->with('total_sell', $total_sell)
            ->with('total_expense', $total_expense)
            ->with('total_purchase', $total_purchase)
            ->with('total_ingredient_purchase', $total_ingredient_purchase)
            ->with('grand_total', $grand_total);
        // ->with('from_date',$from_date)
        // ->with('to_date',$to_date);
    }

    public function currentWeekProfitLoss(Request $request)
    {

        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek =  Carbon::now()->endOfWeek();
        //  $today = Carbon::today();

        //return  view('pages.profitlos.test');

        $total_sell=  Sell::whereBetween('created_at', [$startOfWeek,$endOfWeek]) ->sum('grand_total_price');
        $total_expense = Expense::whereBetween('created_at',  [$startOfWeek,$endOfWeek])->sum('expense_amount');
        $total_purchase = Purchase::whereBetween('created_at',  [$startOfWeek,$endOfWeek])->sum('total_price');
        $total_ingredient_purchase = Ingredient::whereBetween('created_at',  [$startOfWeek,$endOfWeek])->sum('total_price');


        // $total_sell = Sell::sum('grand_total_price');
        // $total_expense = Expense::sum('expense_amount');
        // $total_purchase = Purchase::sum('total_price');
        // $total_ingredient_purchase = Ingredient::sum('total_price');


        $grand_total = $total_sell + $total_expense + $total_purchase + $total_sell - ($total_expense + $total_purchase+$total_ingredient_purchase);
        if ($grand_total <= 0) {
            $grand_total = 1;
        }


        return view('pages.report.show_profitlos')
            ->with('total_sell', $total_sell)
            ->with('total_expense', $total_expense)
            ->with('total_purchase', $total_purchase)
            ->with('total_ingredient_purchase', $total_ingredient_purchase)
            ->with('grand_total', $grand_total);
        // ->with('from_date',$from_date)
        // ->with('to_date',$to_date);
    }

    public function currentMonthProfitLoss(Request $request)
    {

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth =  Carbon::now()->endOfMonth();
        //  $today = Carbon::today();

        //return  view('pages.profitlos.test');

        $total_sell=  Sell::whereBetween('created_at', [$startOfMonth,$endOfMonth]) ->sum('grand_total_price');
        $total_expense = Expense::whereBetween('created_at',  [$startOfMonth,$endOfMonth])->sum('expense_amount');
        $total_purchase = Purchase::whereBetween('created_at',  [$startOfMonth,$endOfMonth])->sum('total_price');
        $total_ingredient_purchase = Ingredient::whereBetween('created_at',  [$startOfMonth,$endOfMonth])->sum('total_price');


        // $total_sell = Sell::sum('grand_total_price');
        // $total_expense = Expense::sum('expense_amount');
        // $total_purchase = Purchase::sum('total_price');
        // $total_ingredient_purchase = Ingredient::sum('total_price');


        $grand_total = $total_sell + $total_expense + $total_purchase + $total_sell - ($total_expense + $total_purchase+$total_ingredient_purchase);
        if ($grand_total <= 0) {
            $grand_total = 1;
        }


        return view('pages.report.show_profitlos')
            ->with('total_sell', $total_sell)
            ->with('total_expense', $total_expense)
            ->with('total_purchase', $total_purchase)
            ->with('total_ingredient_purchase', $total_ingredient_purchase)
            ->with('grand_total', $grand_total);
        // ->with('from_date',$from_date)
        // ->with('to_date',$to_date);
    }
}
