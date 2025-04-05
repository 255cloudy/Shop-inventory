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
        $todayStart = Carbon::now()->startOfDay();
        $todayEnd = Carbon::now()->endOfDay();
        $sales_up = sale::whereBetween("created_at",  [$todayStart, $todayEnd])
            ->where("qty", ">", 0)
            ->orderBy("updated_at", "asc")
            ->get();
        return view('all_sales', ["sales"=> $sales_up,
            "today"=> "Date:" . Carbon::now()->toDateString(),
            "from"=> Carbon::now()->toDateString(),
            "to" => Carbon::now()->toDateString()
        ]);
    }
    function filtered_sales(SalesFileterdRequest $request){
        $today = Carbon::now();
        $validated = $request->validated();
        $from = Carbon::createFromFormat("Y-m-d", $request->validated("from"))->startOfDay();
        $to = Carbon::createFromFormat("Y-m-d", $request->validated("to"))->endOfDay();
        $sales = sale::where("qty", ">", 0)
            ->whereBetween("created_at", [
                $from, $to])
            ->orderBy("updated_at", "asc")
            ->get();
        return view("all_sales", 
        [
            "sales"=> $sales, 
            "from"=>$validated["from"], 
            "to"=>$validated["to"], 
            "today"=> "from:".$validated["from"] . " to:" . $validated["to"]]);
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
                $bp =(float) stock::where("product_id", $entry["product"])
                ->first()
                ->retail_price;
                $sale->curr_bp =$bp;
                $sale->total = $qty * $price;
                $sale->profit = ($price - $bp)*$qty;
                $sale->save();
            }
            $this->update_stock($entries);
        }
        return redirect()->action([SaleController::class, "make_sale"]);

    }
    function delete(Sale $id){
        $id->delete();
        return view('sales');
    }
    function reverse_sale(Sale $sale) {
        $qty = $sale->qty;
        // reverse the stock
        $stock = stock::where("product_id", $sale->product_id)->first();
        $stock->update(["qty"=>$stock->qty + $qty]);
        $sale->delete();
        return redirect()->action([SaleController::class, "all_sales"]);
    }
}
