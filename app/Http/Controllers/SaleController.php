<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\sale;
use App\Models\stock;
use App\Models\Price;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    function make_sale(){
        return view('sales', [
            "products"=> product::all(),
            "prices" => price::all(),
            "stock" => stock::all()
        ]);
    }
    function all_sales(){
        return view('all_sales', ["sales"=> sale::orderBy("updated_at", "asc")->get()]);
    }
    protected function  update_stock($entries){
        foreach ($entries as  $entry){
            $stock = stock::where("product_id", $entry["product"])->get();
            if($stock!= null){
                $stock[0]->qty -= $entry["qty"];
            }
        }
    }
    function store(Request $request){
        $entries = json_decode($request->input("data"), true);
        if(count($entries)>0){
            foreach ($entries as  $entry){
                $sale = new sale();
                $sale->sale_price = $entry["price"];
                $sale->product_id = $entry["product"];
                $sale->qty = $entry["qty"];
                $sale->total = $entry["qty"] * $entry["price"];
                $sale->save();
            }
            $this->update_stock($entries);
        }
        return redirect()->action([SaleController::class, "make_sale"]);

    }
    function delete(){
        return view('sales');
    }
}
