<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    function index(){
        $products = product::all();
        return view('products', ["products"=>$products]);
    }
    function store(ProductStoreRequest $request){
        product::create($request->validated());
        return redirect()->action([ProductController::class, "index"]);
    }
    function update(ProductStoreRequest $request, Product $id){
        $id->update($request->validated());
        return redirect()->action([ProductController::class, "index"]);
    }

    function delete(Request $request, Product $id){
        $id->delete();
        return redirect()->action([ProductController::class, "index"]);
    }
}
