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
        $sales_up = sale::where("created_at", ">=",  $today->toDateString())
            ->where("created_at", "<",  $today->addDay(1)->toDateString())
            ->where("qty", ">", 0)
            ->orderBy("updated_at", "asc")
            ->get();
        return view('all_sales', ["sales"=> $sales_up,
            "today"=> $today->toDateString(),
            "from"=> $today->toDateString(),
            "to" => $today->toDateString()
        ]);
    }
    function filtered_sales(SalesFileterdRequest $request){
        $validated = $request->validated();
        $full_from = $validated["from"]." "."24:00:00";
        $full_to = $validated["to"]." "."24:00:00";
        $sales = DB::table("sales")
            ->where("qty", ">", 0)
            ->whereBetween("created_at", [
                 $full_from, $full_to])
            ->get();
        return view("all_sales", ["sales"=> $sales, "from"=>$validated["from"], "to"=>$validated["to"]]);
    }
    protected function  update_stock($entries){
        foreach ($entries as  $entry){
            $stock = stock::where("product_id", $entry["product"])->first();
            if($stock!= null){
                $stock->qty -= (int)$entry["qty"];
                $stock->save();
            }
        }
    }
    function store(Request $request){
        $entries = json_decode($request->input("data"), true);
        if(count($entries)>0){
            foreach ($entries as  $entry){
                $sale = new sale();
                $price = (int)$entry["price"];
                $sale->sale_price = $price;
                $sale->product_id = $entry["product"];
                $qty = (int)$entry["qty"];
                $sale->qty = $qty;
                $sale->total = $qty * $price;
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
