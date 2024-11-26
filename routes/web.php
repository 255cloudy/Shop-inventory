<?php

use GuzzleHttp\Psr7\Request;
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
Route::get("/", function () {
    return redirect("dashboard");
});
Route::get("dashboard", [\App\Http\Controllers\DashboardController::class, 'show'])->name("dashboard")->middleware('auth');
Route::get('user/all', [\App\Http\Controllers\UserController::class, 'index'])->name("all-users")->middleware('auth');
Route::post('user/', [\App\Http\Controllers\UserController::class, 'create'])->name("create-user")->middleware('auth');;
Route::post('user/delete/{user}', [\App\Http\Controllers\UserController::class, 'delete'])->name("delete-user")->middleware('auth');
Route::get('user/update/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name("update-user")->middleware('auth');

Route::get('asset/all', [\App\Http\Controllers\AssetController::class, 'index'])->name("all-assets")->middleware('auth');
Route::post('asset/', [\App\Http\Controllers\AssetController::class, 'create'])->name("create-asset")->middleware('auth');
Route::get('asset/delete/{id}', [\App\Http\Controllers\AssetController::class, 'delete'])->name("delete-asset")->middleware('auth');
Route::post('asset/update/{id}', [\App\Http\Controllers\AssetController::class, 'update'])->name("update-asset")->middleware('auth');

Route::get('product/all', [\App\Http\Controllers\ProductController::class, 'index'])->name("all-products")->middleware('auth');
Route::post('product/', [\App\Http\Controllers\ProductController::class, 'store'])->name("create-product")->middleware('auth');
Route::get('product/delete/{id}', [\App\Http\Controllers\ProductController::class, 'delete'])->name("delete-product")->middleware('auth');
Route::post('product/update/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name("update-product")->middleware('auth');

Route::get('distributer/all', [\App\Http\Controllers\DistributerController::class, 'index'])->name("all-distributers")->middleware('auth');
Route::post('distributer/', [\App\Http\Controllers\DistributerController::class, 'create'])->name("create-distributer")->middleware('auth');
Route::get('distributer/delete/{id}', [\App\Http\Controllers\DistributerController::class, 'delete'])->name("delete-distributer")->middleware('auth');
Route::post('distributer/update/{id}', [\App\Http\Controllers\DistributerController::class, 'update'])->name("update-distributer")->middleware('auth');


Route::get('sales/all', [\App\Http\Controllers\SaleController::class, 'all_sales'])->name("all_sales")->middleware('auth');
Route::get('sales/', [\App\Http\Controllers\SaleController::class, 'make_sale'])->name("make_sale")->middleware('auth');
Route::post('sales/', [\App\Http\Controllers\SaleController::class, 'store'])->name("store_sale")->middleware('auth');
Route::post('sales/filtered', [\App\Http\Controllers\SaleController::class, 'filtered_sales'])->name("filter_sale")->middleware('auth');
Route::post('sales/delete/{id}', [\App\Http\Controllers\SaleController::class, 'delete'])->name("delete-sale")->middleware('auth');
Route::post('sales/update/{id}', [\App\Http\Controllers\SaleController::class, 'update'])->name("update-sale")->middleware('auth');
Route::get('sales/reverse/{sale}', [\App\Http\Controllers\SaleController::class, 'reverse_sale'])->name("reverse_sale")->middleware('auth');

Route::get('order/all', [\App\Http\Controllers\OrderController::class, 'index'])->name("all-orders")->middleware('auth');
Route::get('order/view/{id}', [\App\Http\Controllers\OrderController::class, 'view'])->name("create-order")->middleware('auth');
Route::get('order/delete/{order}/{id}', [\App\Http\Controllers\OrderController::class, 'delete'])->name("delete-order")->middleware('auth');;
Route::post('order/update/{id}', [\App\Http\Controllers\OrderController::class, 'update_entry'])->name("update-order-entry")->middleware('auth');;
Route::post('order/', [\App\Http\Controllers\OrderController::class, 'add'])->name("add-order")->middleware('auth');
Route::get('order/create/{id}', [\App\Http\Controllers\OrderController::class, 'add_entries'])->name("add_entries")->middleware('auth');
Route::post('order/create/{id}', [\App\Http\Controllers\OrderController::class, 'store_entries'])->name("store_entries")->middleware('auth');
Route::get('order/changed/{order}', [\App\Http\Controllers\OrderController::class, 'changed_entries'])->name("changed_entries")->middleware('auth');
Route::post('order/changed/{order}', [\App\Http\Controllers\OrderController::class, 'update_changes'])->name("update_changes")->middleware('auth');

Route::get('expense/all', [\App\Http\Controllers\ExpenseController::class, 'index'])->name("all-expenses")->middleware('auth');
Route::post('expense/', [\App\Http\Controllers\ExpenseController::class, 'store'])->name("create-expense")->middleware('auth');
Route::post('expense/delete/{id}', [\App\Http\Controllers\ExpenseController::class, 'delete'])->name("delete-expense")->middleware('auth');
Route::post('expense/update/{id}', [\App\Http\Controllers\ExpenseController::class, 'update'])->name("update-expense")->middleware('auth');

Route::get('category/all', [\App\Http\Controllers\CategoryController::class, 'index'])->name("all-categories")->middleware('auth');
Route::post('category/', [\App\Http\Controllers\CategoryController::class, 'store'])->name("create-category")->middleware('auth');
Route::get('category/delete/{id}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name("delete-category")->middleware('auth');
Route::post('category/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name("update-category")->middleware('auth');
Route::post('category/xp', [\App\Http\Controllers\CategoryController::class, 'storeFromEp'])->name("create-category-from-xp")->middleware('auth');;

Route::get('stock/all', [\App\Http\Controllers\StockController::class, 'index'])->name("all-stock")->middleware('auth');
Route::post('stock/update/{id}', [\App\Http\Controllers\StockController::class, 'update'])->name("update-stock")->middleware('auth');

Route::get('price/all', [\App\Http\Controllers\PriceController::class, 'index'])->name("all-prices")->middleware('auth');
Route::post('price/update/{id}', [\App\Http\Controllers\PriceController::class, 'update'])->name("update-price")->middleware('auth');


Route::get('user/all', [\App\Http\Controllers\UserController::class, 'index'])->name("all-users")->middleware('auth');
Route::get('user/login', [\App\Http\Controllers\UserController::class, 'show_login'])->name("login-show");
Route::get('user/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name("logout")->middleware('auth');
Route::post('user/login', [\App\Http\Controllers\UserController::class, 'login'])->name("login");
Route::get('user/registration', [\App\Http\Controllers\UserController::class, 'show_registration'])->name("registration-show")->middleware('auth');
Route::post('user/registration', [\App\Http\Controllers\UserController::class, 'add_user'])->name("registration")->middleware('auth');


Route::get("report/sales", [\App\Http\Controllers\ReportController::class, 'base_sales'])->name("base-sales")->middleware('auth');
Route::post("report/sales", [\App\Http\Controllers\ReportController::class, 'filter_sales'])->name("filter-sales")->middleware('auth');
Route::post("report/sales/date", [\App\Http\Controllers\ReportController::class, 'filter_sales_date'])->name("filter-sales-date")->middleware('auth');
Route::get("report/profit", [\App\Http\Controllers\ReportController::class, 'profit'])->name("profit")->middleware('auth');
Route::post("report/profit", [\App\Http\Controllers\ReportController::class, 'filter_profit'])->name("profit")->middleware('auth');
