<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ExpenseCategoryController extends Controller
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
        return view('pages.expense_category.show_expense_category')->with('result', ExpenseCategory::get());
    }


    public function create()
    {
        return view('pages.expense_category.create_expense_category')->with('outlets', Outlet::get());
    }


    public function store(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id =session('outlet_id');
        unset($request['_token']); //Remove Token
        $request->validate([
            'expense_category_name' => 'required'
        ]);

        if ($request->hasFile('image')){
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,svg|max:2048',
            ]);
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/expense_category');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = 'default.jpg';
        }

        $request->request->add(['expense_category_image' => $image_name, 'outlet_id' => $outlet_id]);
        try {
            ExpenseCategory::create($request->except('image'));
            return redirect('/expense/category/show')->with('success', "Expense Category save");
        } catch (\Exception $exception) {
            return redirect('/expense/category/show')->with('failed', "There was a Problem" . $exception->getMessage());
        }

    }


    public function show(ExpenseCategory $expenseCategory)
    {
        //
    }


    public function edit($expense_category_id)
    {
        //return ExpenseCategory::get();
        return view('pages.expense_category.edit_expense_category')->with('result', ExpenseCategory::where('expense_category_id', $expense_category_id)->first());
    }


    public function update(Request $request)
    {
        //OUTLET ID,IT WILL CAME FROM SESSION, THIS TIME WE WILL USE static value
        $outlet_id = 1;
        $expense_category_id = $request['expense_category_id'];
        unset($request['_token']); //Remove Token
        unset($request['expense_category_id']);//Remove token

        $request->validate([
            'expense_category_name' => 'required'
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $image_name = $request['image_name'];
            $destinationPath = public_path('/images/expense_category');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = $request['image_name'];
        }


        unset($request['image_name']);//Remove token
        $request->request->add(['expense_category_image' => $image_name]);

        //return $request->all();
        try {

            ExpenseCategory::where('expense_category_id', $expense_category_id)->update($request->except('image'));
            return redirect('/expense/category/show')->with('success', "Products Category Updated");
        } catch (\Exception $exception) {
            return redirect('/expense/category/show')->with('failed', "There was a problem. " . $exception->getMessage());
        }
    }


    public function destroy($expense_category_id)
    {
        try {
            ExpenseCategory::where('expense_category_id', $expense_category_id)->delete();
            return back()->with('success', "Expense Category Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed',"There was a Problem ." . $exception->getMessage());
        }
    }
}
