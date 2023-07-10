<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalesFileterdRequest;
use App\Models\product;
use App\Models\sale;
use App\Models\stock;
use App\Models\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $today = Carbon::now();
        $sales_up = sale::whereYear("updated_at", $today->year)
            ->whereMonth("updated_at", $today->month)
            ->orderBy("updated_at", "asc")
            ->get();
        return view('all_sales', ["sales"=> $sales_up]);
    }
    function filtered_sales(SalesFileterdRequest $request){
        $validated = $request->validated();
        $sales = DB::table("sales")
            ->whereBetween("updated_at", [$validated["from"], $validated["to"]])
            ->get();
        return view("all_sales", ["sales"=> $sales]);
    }
    protected function  update_stock($entries){
        foreach ($entries as  $entry){
            $stock = stock::where("product_id", $entry["product"])->get();
            if($stock!= null){
                $stock[0]->qty -= $entry["qty"];
                $stock[0]->save();
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
