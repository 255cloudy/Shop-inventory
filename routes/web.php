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
    return view("dbTest");
});
Route::get("dashboard", [\App\Http\Controllers\DashboardController::class, 'show'])->name("dashboard");
Route::get('user/all', [\App\Http\Controllers\UserController::class, 'index'])->name("all-users");
Route::post('user/', [\App\Http\Controllers\UserController::class, 'create'])->name("create-user");
Route::post('user/delete/{user}', [\App\Http\Controllers\UserController::class, 'delete'])->name("delete-user");
Route::get('user/update/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name("update-user");

Route::get('asset/all', [\App\Http\Controllers\AssetController::class, 'index'])->name("all-assets");
Route::post('asset/', [\App\Http\Controllers\AssetController::class, 'create'])->name("create-asset");
Route::get('asset/delete/{id}', [\App\Http\Controllers\AssetController::class, 'delete'])->name("delete-asset");
Route::post('asset/update/{id}', [\App\Http\Controllers\AssetController::class, 'update'])->name("update-asset");

Route::get('product/all', [\App\Http\Controllers\ProductController::class, 'index'])->name("all-products");
Route::post('product/', [\App\Http\Controllers\ProductController::class, 'store'])->name("create-product");
Route::get('product/delete/{id}', [\App\Http\Controllers\ProductController::class, 'delete'])->name("delete-product");
Route::post('product/update/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name("update-product");

Route::get('distributer/all', [\App\Http\Controllers\DistributerController::class, 'index'])->name("all-distributers");
Route::post('distributer/', [\App\Http\Controllers\DistributerController::class, 'create'])->name("create-distributer");
Route::get('distributer/delete/{id}', [\App\Http\Controllers\DistributerController::class, 'delete'])->name("delete-distributer");
Route::post('distributer/update/{id}', [\App\Http\Controllers\DistributerController::class, 'update'])->name("update-distributer");

Route::get('sales/all', [\App\Http\Controllers\SaleController::class, 'all_sales'])->name("all_sales");
Route::get('sales/', [\App\Http\Controllers\SaleController::class, 'make_sale'])->name("make_sale");
Route::post('sales/', [\App\Http\Controllers\SaleController::class, 'store'])->name("store_sale");
Route::post('sales/delete/{id}', [\App\Http\Controllers\SaleController::class, 'delete'])->name("delete-sale");
Route::post('sales/update/{id}', [\App\Http\Controllers\SaleController::class, 'update'])->name("update-sale");

Route::get('order/all', [\App\Http\Controllers\OrderController::class, 'index'])->name("all-orders");
Route::get('order/view/{id}', [\App\Http\Controllers\OrderController::class, 'view'])->name("create-order");
Route::get('order/delete/{order}/{id}', [\App\Http\Controllers\OrderController::class, 'delete'])->name("delete-order");
Route::post('order/update/{id}', [\App\Http\Controllers\OrderController::class, 'update_entry'])->name("update-order-entry");
Route::post('order/', [\App\Http\Controllers\OrderController::class, 'add'])->name("add-order");
Route::get('order/create/{id}', [\App\Http\Controllers\OrderController::class, 'add_entries'])->name("add_entries");
Route::post('order/create/{id}', [\App\Http\Controllers\OrderController::class, 'store_entries'])->name("store_entries");

Route::get('expense/all', [\App\Http\Controllers\ExpenseController::class, 'index'])->name("all-expenses");
Route::post('expense/', [\App\Http\Controllers\ExpenseController::class, 'store'])->name("create-expense");
Route::post('expense/delete/{id}', [\App\Http\Controllers\ExpenseController::class, 'delete'])->name("delete-expense");
Route::post('expense/update/{id}', [\App\Http\Controllers\ExpenseController::class, 'update'])->name("update-expense");

Route::get('category/all', [\App\Http\Controllers\CategoryController::class, 'index'])->name("all-categories");
Route::post('category/', [\App\Http\Controllers\CategoryController::class, 'store'])->name("create-category");
Route::get('category/delete/{id}', [\App\Http\Controllers\CategoryController::class, 'delete'])->name("delete-category");
Route::post('category/update/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name("update-category");
Route::post('category/xp', [\App\Http\Controllers\CategoryController::class, 'storeFromEp'])->name("create-category-from-xp");

Route::get('stock/all', [\App\Http\Controllers\StockController::class, 'index'])->name("all-stock");
Route::post('stock/update/{id}', [\App\Http\Controllers\StockController::class, 'update'])->name("update-stock");

Route::get('price/all', [\App\Http\Controllers\PriceController::class, 'index'])->name("all-prices");
Route::post('price/update/{id}', [\App\Http\Controllers\PriceController::class, 'update'])->name("update-price");
