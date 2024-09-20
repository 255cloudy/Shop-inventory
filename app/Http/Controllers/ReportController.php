<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterSalesDateRequest;
use App\Http\Requests\FilterSalesRequest;
use App\Http\Requests\ProfitFilterRequest;
use App\Models\expense;
use App\Models\product;
use App\Models\sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use mysql_xdevapi\Table;

class ReportController extends Controller
{
    protected int $DAY = 0;
    protected int $MONTH = 1;
    protected int $YEAR = 2;
    public array $months = [
        "jan", "feb", "mar", "april", "may", "june", "july", "aug", "sep", "oct", "nov", "dec"
    ];
    public array $days = [
        "sun", "mon", "tue", "wed", "thur", "fri", "sat"
    ];
    public function base_sales(){
        $from = Carbon::createFromFormat("Y-m-d", Carbon::today()->toDateString())->startOfDay();
        $to = Carbon::createFromFormat("Y-m-d", Carbon::today()->toDateString())->endOfDay();
        $product_data = DB::table("sales")
                ->join("products", "sales.product_id", "=", "products.id")
                ->select(
                    'products.name as product',
                    DB::raw('SUM(sales.total) as total'),
                    DB::raw('SUM(sales.qty) as pcs')
                    )
                ->whereBetween("sales.updated_at", [$from, $to])
                -> groupBy("sales.product_id", "products.name")->get();
        return view("base_sales", ["product_data" => $product_data,
            "months"=> $this->months,
            "days"=> $this->days,
            "isQueried"=> "none",
            "today" => $from->toDateString()
        ]);
    }
    private function resolve_days($sales, $day){
            $compatible_sales_ids = [];
            foreach ($sales as $sale){
                $date = new Carbon($sale->updated_at);
                if($date->dayOfWeek === (int) $day){
                    array_push($compatible_sales_ids, $sale->id);
                }
            }
            return $compatible_sales_ids;

    }
//    
    public function filter_sales(FilterSalesRequest $request){
        $product_sales = [];
        $validated = $request->validated();
        $data = [ $validated['day'],  $validated['month'],  $validated['year']];
        $all_products = product::all();
        foreach ($all_products  as $product){
            $cash = 0;
            $pcs = 0;
            $query = DB::table("sales")->where("product_id", $product->id);
            //        all of ?:?:y
            if ($data[$this->YEAR] !== "any"){
                if($data[$this->MONTH] !== "any"){
                    if($data[$this->DAY] !== "any"){
                        $inter_items = $query->whereYear("updated_at", $data[$this->YEAR])
                                            ->whereMonth("updated_at", $data[$this->MONTH])
                                            ->get();
                        $inter_cash = 0;
                        $inter_pcs = 0;
                        foreach ($inter_items as $item){
                               $date = new Carbon($item->updated_at);
                               $day = $date->dayOfWeek;
                               if($day === (int)$data[$this->DAY]){
                                   $cash += $item->total;
                                   $pcs  += $item->qty;
                               }
                        }
                    }
                    else {
                        $cash = $query->whereYear("updated_at", $data[$this->YEAR])
                            ->whereMonth("updated_at", $data[$this->MONTH])
                            ->sum("total");
                        $pcs = $query->whereYear("updated_at", $data[$this->YEAR])
                            ->whereMonth("updated_at", $data[$this->MONTH])
                            ->sum("qty");
                    }
                }
                else {
                    if($data[$this->DAY] != "any"){
                        $subset = $query->whereYear("updated_at", $data[$this->YEAR])->get();
                        foreach ($subset as $item){
                            $date = new Carbon($item->updated_at);
                            $day = $date->dayOfWeek;
                            if($day === (int)$data[$this->DAY]){
                                $cash +=  $item->total;
                                $pcs += $item->qty;
                            }
                        }
                    }
                    else {
                        $cash = $query->whereYear("updated_at", $data[$this->YEAR])->sum("total");
                        $qty = $query->whereYear("updated_at", $data[$this->YEAR])->sum("qty");
                    }
                }
            }
            else{
                if($data[$this->MONTH] !== "any"){
                    if($data[$this->DAY] !== "any"){
                        $subset = $query->whereMonth("updated_at", $data[$this->MONTH])->get();
                        foreach ($subset as $item){
                            $date = new Carbon($item->updated_at);
                            $day = $date->dayOfWeek;
                            if($day === (int)$data[$this->DAY]){
                                $cash +=  $item->total;
                                $pcs += $item->qty;
                            }
                        }
                    }
                    else {
                        $cash = $query
                            ->whereMonth("updated_at", $data[$this->MONTH])
                            ->sum("total", );
                        $pcs =  $cash = $query
                            ->whereMonth("updated_at", $data[$this->MONTH])
                            ->sum("qty", );
                    }
                }
                else {
                    foreach ($query->get() as $item){
                        $date = new Carbon($item->updated_at);
                        $day = $date->dayOfWeek;
                        if($day === (int)$data[$this->DAY]){
                            $cash +=  $item->total;
                            $pcs += $item->qty;
                        }
                    }
                }
            }
            array_push($product_sales, [
                "product"=> $product->name,
                "cash" => $cash,
                "pcs" => $pcs
            ]);
        }
        $query_params = [
            "day" => "any",
            "month" => "any",
            "year" => $data[2]
        ];
        if($data[0] !== "any"){
            $query_params["day"]= $this->days[$data[0]];
        }
        if($data[1] !== "any"){
            $query_params["month"]= $this->months[$data[1]];
        }
        return view("base_sales", ["product_data" => $product_sales,
                "months"=> $this->months,
                "days"=> $this->days,
                "query" => $query_params,
                "isQueried" => "aggregate",
            ]
        );
    }
    public function filter_sales_date(FilterSalesDateRequest $request){
        $from = Carbon::createFromFormat("Y-m-d", $request->validated("date"))->startOfDay();
        $to = Carbon::createFromFormat("Y-m-d", $request->validated("date"))->endOfDay();
        $product_data = DB::table("sales")
                ->join("products", "sales.product_id", "=", "products.id")
                ->select(
                    'products.name as product',
                    DB::raw('SUM(sales.total) as total'),
                    DB::raw('SUM(sales.qty) as pcs')
                    )
                ->whereBetween("sales.updated_at", [$from, $to])
                -> groupBy("sales.product_id", "products.name")->get();
        return view("base_sales", ["product_data" => $product_data,
            "months"=> $this->months,
            "days"=> $this->days,
            "query"=> $from->toDateString(),
            "isQueried"=> "date"
        ]);
    }
    public function profit(Request $request){
        $from = Carbon::createFromFormat("Y-m-d", Carbon::today()->toDateString())->startOfDay();
        $to = Carbon::createFromFormat("Y-m-d", Carbon::today()->toDateString())->endOfDay();
        $query_totals = DB::table("sales")
            ->whereBetween("updated_at", [$from, $to]);
        $sales_total = $query_totals->sum("total");
        $profit_total = $query_totals->sum("profit");
        $product_data = DB::table("sales")
                ->join("products", "sales.product_id", "=", "products.id")
                ->select(
                    'products.name as product',
                    DB::raw('SUM(sales.profit) as profit'),
                    DB::raw('SUM(sales.qty) as pcs')
                    )
                ->whereBetween("sales.updated_at", [$from, $to])
                -> groupBy("sales.product_id", "products.name")->get();
        $expenses = DB::table("expenses")
            ->whereBetween("updated_at", [$from, $to])
            ->sum("amount");
        $profit_total -= $expenses;
        return view("profits", [
            "product_data"=> $product_data,
            "from" => $from->toDateString(),
            "to" => $to->toDateString(),
            "profit_total" => $profit_total,
            // "bp_total" => $bp_sum,
            "sales_total" => $sales_total,
            "expenses" => $expenses
        ]);
    }

    public function filter_profit(ProfitFilterRequest $request){
        $from = Carbon::createFromFormat('Y-m-d', $request->validated("from"))->startOfDay();
        $to =   Carbon::createFromFormat('Y-m-d', $request->validated("to"))->endOfDay();
        if($from->gt($to)){
            return back()->withErrors(["dates"=> "from date cant be greater than to date"])->withInput();
        }
        // do the between two dates
        $query_totals = DB::table("sales")
            ->whereBetween("updated_at", [$from, $to]);
            $sales_total = $query_totals->sum("total");
            $profit_total = $query_totals->sum("profit");
            $product_data = DB::table("sales")
                    ->join("products", "sales.product_id", "=", "products.id")
                    ->select(
                        'products.name as product',
                        DB::raw('SUM(sales.profit) as profit'),
                        DB::raw('SUM(sales.qty) as pcs')
                        )
                    ->whereBetween("sales.updated_at", [$from, $to])
                    -> groupBy("sales.product_id", "products.name")->get();
            $expenses = DB::table("expenses")
                ->whereBetween("updated_at", [$from, $to])
                ->sum("amount");
            $profit_total -= $expenses;
            return view("profits", [
                "product_data"=> $product_data,
                "from" => $from->toDateString(),
                "to" => $to->toDateString(),
                "profit_total" => $profit_total,
                // "bp_total" => $bp_sum,
                "sales_total" => $sales_total,
                "expenses" => $expenses
            ]);

    }
}
