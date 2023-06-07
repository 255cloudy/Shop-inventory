<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStockRequest;
use App\Models\product;
use App\Models\stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    function index(){
        return view('stocks', ["stocks"=> stock::all(), "products"=> product::all()]);
    }

    function update(UpdateStockRequest $request, stock $id){
        $validated = $request->validated();
        $id->update([
            "qty"=> $validated["qty"]
        ]);
        return redirect()->action([StockController::class, "index"]);
    }
    function delete(){
        return view('stock');
    }
}
