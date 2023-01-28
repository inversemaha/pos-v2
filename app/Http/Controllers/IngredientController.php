<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class IngredientController extends Controller
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
        $result = Ingredient::get();
        return view('pages.ingredient_purchase.show_purchase')->with('result', $result);
    }


    public function create()
    {
        return view('pages.ingredient_purchase.create_purchase')->with('suppliers', Supplier::get())->with('product', ProductDetail::get());
    }


    public function store(Request $request)
    {

        $user_id = session('user_id');
        unset($request['_token']);
        $request->validate([
            'total_price' => 'required'
        ]);
        $request->request->add(['user_id' => $user_id]);
        try {
            Ingredient::create($request->all());
            return redirect('/ingredient/purchase/show')->with('success', "Purchase Save");
        } catch (\Exception $exception) {

            return redirect('/ingredient/purchase/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function show(Purchase $purchase)
    {
        //
    }


    public function edit($ingredient_id)
    {
        return view('pages.ingredient_purchase.edit_purchase')
            ->with('purchase', Ingredient::where('ingredient_id', $ingredient_id)
                ->first());
    }

    public function update(Request $request, Purchase $purchase)
    {
        $ingredient_id = $request['ingredient_id'];
        unset($request['_token']); //Remove token
        unset($request['ingredient_id']);

        $request->validate([
            'total_price' => 'required'
        ]);


        Try {
            Ingredient::where('ingredient_id', $ingredient_id)->update($request->all());

            return redirect('/ingredient/purchase/show')->with('success', "Purchase Update");
        } catch (\Exception $exception) {
            return redirect('/ingredient/purchase/show')->with('failed', "There Was a Problem" . $exception->getMessage());
        }
    }


    public function destroy($ingredient_id)
    {
        try {
            Ingredient::where('ingredient_id', $ingredient_id)->delete();
            return redirect('/ingredient/purchase/show')->with('success', "Purchase Details Deleted");
        } catch (\Exception $exception) {
            return redirect('/ingredient/purchase/show')->with('failed', "There Was a Problem" . $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        $from_date = getFormatteddate($request['from_date']);
        $to_date = getFormatteddate($request['to_date']);
        if ($from_date != $to_date) {
            $result = Ingredient::whereBetween('created_at', [$from_date, $to_date])
                ->get();

        } else {
            $result = Ingredient::whereDate('created_at', $from_date)
                ->get();

        }

        return view('pages.ingredient_purchase.show_purchase')->with('result', $result);
    }
}
