<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller
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
        $result = Expense::
        join('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
            ->get();
        return view('pages.expense.show_expense')->with('result', $result);
    }


    public function create()
    {
        return view('pages.expense.create_expense')->with('category', ExpenseCategory::get());
    }


    public function store(Request $request)
    {
        $outlet_id = session('outlet_id');
        unset($request['_token']); //Remove Token
        $request->validate([
            'expense_name' => 'required',
            'expense_amount' => 'required|numeric',
            'expense_category_id' => 'required'
        ]);

        $request->request->add(['outlet_id' => $outlet_id]);
        try {
            Expense::create($request->all());
            return redirect('/expense/show')->with('success', "Expense Save");
        } catch (\Exception $exception) {
            return redirect('/expense/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }

    }


    public function show(Expense $expense)
    {
        //
    }


    public function edit($expense_id)
    {
        return view('pages.expense.edit_expense')
            ->with('categories', ExpenseCategory::get())
            ->with('expense', Expense::where('expense_id', $expense_id)->first());
    }


    public function update(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = session('outlet_id');;
        $expense_id = $request['expense_id'];
        unset($request['_token']); //Remove Token
        unset($request['expense_id']);

        $request->validate([
            'expense_name' => 'required',
            'expense_amount' => 'required',
            'expense_category_id' => 'required'
        ]);

        $request->request->add(['outlet_id' => $outlet_id]);
        try {
            Expense::where('expense_id', $expense_id)->update($request->all());
            return redirect('/expense/show')->with('success', "Expense Save");
        } catch (\Exception $exception) {
            return redirect('/expense/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($expense_id)
    {
        try {
            Expense::where('expense_id', $expense_id)->delete();
            return redirect('/expense/show')->with('success', "Expense Deleted");
        } catch (\Exception $exception) {
            redirect('/expense/show')->with('failed', "There was a problem." . $exception->getMessage());
        }
    }
}
