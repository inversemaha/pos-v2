<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductsCategoryController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VatController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('locale/{locale}', function ($locale) {

    App::setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();

});


Route::get('/admin-home', [Controller::class, 'index']);
Route::get('/user/profile', [Controller::class, 'profile']);
Route::post('/user/profile/update', [Controller::class, 'profileUpdate']);

Route::get('/', function () {
    if (Auth::check()) {
        return Redirect::to('/admin-home');
    }
    return view('pages.login.login');
});


Route::get('/login', function () {
    return view('pages.login.login');
});

Route::get('/forget-password', [HomeController::class, 'forgetPassword']);
Route::post('/do-password-reset', [HomeController::class, 'doPassordReset']);

Route::post('/login-check', [HomeController::class, 'doLogin']);
Route::get('/logout', [HomeController::class, 'doLogout']);


//Manage user
Route::get('/user/create', [UserController::class, 'create']);
Route::get('/user/show', [UserController::class, 'index']);
Route::post('/user/store', [UserController::class, 'store']);
Route::get('/user/edit/{user_id}', [UserController::class, 'edit']);
Route::post('/user/update', [UserController::class, 'update']);
Route::get('/user/destroy/{user_id}',[UserController::class, 'destroy']);

//Manage user Role
Route::get('/user/role/create',[RoleController::class, 'create']);
Route::get('/user/role/show',[RoleController::class, 'index']);
Route::post('/user/role/store',[RoleController::class, 'store'] );
Route::get('/user/role/edit/{role_id}',[RoleController::class, 'edit']);
Route::post('/user/role/update', [RoleController::class, 'update']);
Route::get('/user/role/destroy/{role_id}',[RoleController::class, 'destroy']);

//Manage Outlet
Route::get('/outlet/create', [OutletController::class, 'create']);
Route::get('/outlet/show', [OutletController::class, 'index']);
Route::post('/outlet/store', [OutletController::class, 'store']);
Route::get('/outlet/edit/{outlet_id}', [OutletController::class, 'edit']);
Route::post('/outlet/update', [OutletController::class, 'update']);
Route::get('/outlet/destroy/{outlet_id}',[OutletController::class, 'destroy']);

//Manage Products Category
Route::get('/product/category/create',[ProductsCategoryController::class, 'create']);
Route::get('/product/category/show', [ProductsCategoryController::class, 'index']);
Route::post('/product/category/store', [ProductsCategoryController::class, 'store']);
Route::get('/product/category/edit/{product_category_id}', [ProductsCategoryController::class, 'edit']);
Route::post('/product/category/update', [ProductsCategoryController::class, 'update']);
Route::get('/product/category/destroy/{product_category_id}', [ProductsCategoryController::class, 'destroy']);

//Manage Products
Route::get('/products/create', [ProductController::class, 'create']);
Route::get('/products/show',[ProductController::class, 'index']);
Route::post('/products/store', [ProductController::class, 'store']);
Route::get('/products/edit/{product_id}', [ProductController::class, 'edit']);
Route::post('/products/update',[ProductController::class, 'update']);
Route::get('/products/destroy/{product_id}/{details_id}', [ProductController::class, 'destroy']);

Route::get('/products/import',[ProductController::class, 'import']);
Route::post('/product/import/save', [ProductController::class, 'save']);

//manage sell
Route::post('/products/payment', [SellController::class, 'payment']);       // sadhan need to check

//Manage Expense Category
Route::get('/expense/category/create',[ExpenseCategoryController::class, 'create']);
Route::get('/expense/category/show',[ExpenseCategoryController::class, 'index']);
Route::post('/expense/category/store',[ExpenseCategoryController::class, 'store'] );
Route::get('/expense/category/edit/{expense_category_id}', [ExpenseCategoryController::class, 'edit']);
Route::post('/expense/category/update', [ExpenseCategoryController::class, 'update']);
Route::get('/expense/category/destroy/{expense_category_id}', [ExpenseCategoryController::class, 'destroy']);

//Manage Expense
Route::get('/expense/create', [ExpenseController::class, 'create']);
Route::get('/expense/show',[ExpenseController::class, 'index'] );
Route::post('/expense/store',[ExpenseController::class, 'store'] );
Route::get('/expense/edit/{expense_id}',[ExpenseController::class, 'edit']);
Route::post('/expense/update',[ExpenseController::class, 'update']);
Route::get('/expense/destroy/{expense_id}',[ExpenseController::class, 'destroy'] );

//Manage Supplier
Route::get('/supplier/create',[SupplierController::class, 'create']);
Route::get('/supplier/show', [SupplierController::class, 'index']);
Route::post('/supplier/store', [SupplierController::class, 'store']);
Route::get('/supplier/edit/{supplier_id}', [SupplierController::class, 'edit']);
Route::post('/supplier/update',[SupplierController::class, 'update']);
Route::get('/supplier/destroy/{supplier_id}', [SupplierController::class, 'destroy']);

//Manage Customer
Route::get('/customer/create', [CustomerController::class, 'create']);
Route::get('/customer/show',[CustomerController::class, 'index'] );
Route::post('/customer/store',[CustomerController::class, 'store'] );
Route::get('/customer/edit/{customer_id}',[CustomerController::class, 'edit']);
Route::post('/customer/update',[CustomerController::class, 'update']);
Route::get('/customer/destroy/{customer_id}',[CustomerController::class, 'destroy']);

//Save by angular

Route::post('/customer-js/store', [CustomerController::class, 'storeCustomer']);
Route::post('/customer/get', [CustomerController::class, 'getCustomer']);

//Manage Vat
Route::get('/vat/create',[VatController::class, 'create']);
Route::get('/vat/show',[VatController::class, 'index'] );
Route::post('/vat/store', [VatController::class, 'store']);
Route::get('/vat/edit/{vat_id}', [VatController::class, 'edit']);
Route::post('/vat/update', [VatController::class, 'update']);
Route::get('/vat/destroy/{vat_id}',[VatController::class, 'destroy']);

//Manage Products Discount
Route::get('/sell/discount/create', [DiscountController::class, 'create']);
Route::get('/sell/discount/show',[DiscountController::class, 'index']);
Route::post('/sell/discount/store', [DiscountController::class, 'store']);
Route::get('/sell/discount/edit/{discount_id}', [DiscountController::class, 'edit']);
Route::post('/sell/discount/update',[DiscountController::class, 'update']);
Route::get('/sell/discount/destroy/{discount_id}', [DiscountController::class, 'destroy']);

//Manage Unit
Route::get('/unit/create',[UnitController::class, 'create']);
Route::get('/unit/show',[UnitController::class, 'index']);
Route::post('/unit/store',[UnitController::class, 'store']);
Route::get('/unit/edit/{vat_id}', [UnitController::class, 'edit']);
Route::post('/unit/update',[UnitController::class, 'update']);
Route::get('/unit/destroy/{vat_id}', [UnitController::class, 'destroy']);

//Manage Purchase
Route::get('/purchase/create',[PurchaseController::class, 'create']);
Route::get('/purchase/show', [PurchaseController::class, 'index']);
Route::post('/purchase/store',[PurchaseController::class, 'store']);
Route::get('/purchase/edit/{purchase_id}',[PurchaseController::class, 'edit']);
Route::post('/purchase/update', [PurchaseController::class, 'update']);
Route::get('/purchase/destroy/{purchase_id}', [PurchaseController::class, 'destroy']);
Route::post('/purchase/search', [PurchaseController::class, 'search']);

//Manage Ingredient
Route::get('/ingredient/purchase/create', [IngredientController::class, 'create']);
Route::get('/ingredient/purchase/show',[IngredientController::class, 'index']);
Route::post('/ingredient/purchase/store',[IngredientController::class, 'store']);
Route::get('/ingredient/purchase/edit/{purchase_id}',[IngredientController::class, 'edit']);
Route::post('/ingredient/purchase/update',[IngredientController::class, 'update']);
Route::get('/ingredient/purchase/destroy/{purchase_id}', [IngredientController::class, 'destroy']);
Route::post('/ingredient/purchase/search',[IngredientController::class, 'search']);


//Manage Sells
Route::any('/sell/list', [SellController::class, 'showSales']);
Route::post('/sell/pay',[SellController::class, 'duepay']);
Route::post('/sell/search', [SellController::class, 'search']);
Route::get('/sells/details/{invoice}', [SellController::class, 'show']);
Route::get('/sells/payment/details/{invoice}', [SellController::class, 'showPayments']);
Route::get('/sells/delete/{invoice}/{id}', [SellController::class, 'destroy']);
Route::get('/sells/pos/{invoice}',[SellController::class, 'posPrint']);
Route::get('/sell/list/due',[SellController::class, 'dueList']);
Route::get('/sell/list/paid', [SellController::class, 'paidList']);


//Manage Stock
Route::get('/stock/create',[StockController::class, 'create']);
Route::get('/stock/show',[StockController::class, 'show']);
Route::post('/stock/store',[StockController::class, 'store']);

//
Route::get('/stock-history/show',[StockHistoryController::class, 'show']);


Route::get('/home', [HomeController::class, 'index'])->name('home');

//Manage POS
Route::get('/pos', [PosController::class, 'index']);

//Manage Report
Route::group(['middleware' => 'admin'], function () {

    Route::any('/report/profit/show', [ReportController::class, 'profit']);
    Route::any('/report/sell',[ReportController::class, 'sellReport']);
    Route::any('/report/sell/product', [ReportController::class, 'sellByProductReport']);
    Route::any('/report/sell/salesman', [ReportController::class, 'sellBySalesmanReport']);
    Route::any('/daily/report/show', [ReportController::class, 'dailySellReport']);
    Route::any('/daily/report/profit/loss/show', [ReportController::class, 'dailyProfitLoss']);
    Route::any('/current-week/report/profit/loss/show', [ReportController::class, 'currentWeekProfitLoss']);
    Route::any('/current-month/report/profit/loss/show', [ReportController::class, 'currentMonthProfitLoss']);

});


//Manage Report
Route::get('/setting/shop',[SettingController::class, 'shopSetting']);


Route::get('/clear-cache', function () {

    return DB::table('stocks')->where('product_id', 1)->decrement('quantity', 2);

    return DB::table('stocks')->where('product_id', 1)->get();
    $exitCode = Artisan::call('cache:clear');


    $exitCode = Artisan::call('config:cache');

    $exitCode = Artisan::call('view:clear');


    $exitCode = Artisan::call('cache:clear');
    // return what you want
});


Route::group(['middleware' => 'admin'], function () {

    Route::get('/test',[SettingController::class, 'test']);


});
