<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Models\Price;
use App\Models\product;
use App\Models\stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    function index(){
        $products = product::all();
        return view('products', ["products"=>$products]);
    }
    function store(ProductStoreRequest $request){
        $product = new Product();
        $product->name = $request->validated("name");
        $product->description = $request->validated("description");
        $product->save();
        Price::create([
            "product_id"=> $product->id,
            "sale_price" => 0,
            "bp" => 0,
        ]);
        stock::create([
            "product_id" => $product->id,
            "retail_price" => 0,
            "qty" => 0,
        ]);
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
