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
        $product_data = [];
        foreach (product::all() as $product ){
            $query = DB::table("sales")
                            ->where("product_id", $product->id)
                            ->where("total", ">",0)
                            ->whereYear("updated_at", Carbon::now()->year);
            $total_sales = $query->sum("total");
            $pcs = $query->count();
            array_push($product_data, [
                "product"=> $product->name,
                "cash" => $total_sales,
                "pcs" => $pcs
            ]);
        }
        return view("base_sales", ["product_data" => $product_data,
            "months"=> $this->months,
            "days"=> $this->days,
            "isQueried"=> "none"
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
//    public function filter_sales(FilterSalesRequest $request){
//        $product_sales = [];
//        $validated = $request->validated();
//        $data = [ $validated['day'],  $validated['month'],  $validated['year']];
//        $all_products = product::all();
//       foreach ($all_products as $product){
//           $cash = 0;
//           $pcs = 0;
//           $query = DB::table("sales")->where("product_id", $product->id);
//           if($data[2]!== "any"){
//               $query->whereYear("updated_at", $data[2]);
//           }
//           if($data[1]!== "any"){
//               $query->whereMonth("updated_at", (int)$data[1]);
//           }
//
//           if($data[0]!== "any"){
//               $resolve_days = $this->resolve_days($query->get(), (int)$data[0]);
//               $cash = $query
//                    ->whereIn("id", $resolve_days)
//                    ->sum("sale_price");
//               $pcs = count($resolve_days);
//           }else {
//               $cash += $query->sum("sale_price");
//               $pcs += $query->count();
//           }
//           $prod_data = ["product"=>$product->name, "cash"=>$cash, "pcs"=>$pcs];
//           array_push($product_sales, $prod_data);
//       }
//       $query_params = [
//           "day" => "any",
//           "month" => "any",
//           "year" => $data[2]
//       ];
//       if($data[0] !== "any"){
//           $query_params["day"]= $this->days[$data[0]];
//       }
//        if($data[1] !== "any"){
//            $query_params["month"]= $this->months[$data[1]];
//        }
//
//        return view("base_sales", ["product_data" => $product_sales,
//            "months"=> $this->months,
//            "days"=> $this->days,
//            "query" => $query_params,
//             "isQueried" => "aggregate",
//            ]
//        );
//    }
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
        $product_data = [];
        $date = $request->validated()["date"];
        foreach (product::all() as $product ){
            $total_sales = DB::table("sales")
                ->where("product_id", $product->id)
                ->whereDate("updated_at", $date)
                ->sum("sale_price");
            $pcs = DB::table("sales")
                ->where("product_id", $product->id)
                ->whereDate("updated_at", $date)
                ->count();
            array_push($product_data, ["product"=> $product->name, "cash"=>$total_sales, "pcs"=>$pcs]);
        }
        return view("base_sales", ["product_data" => $product_data,
            "months"=> $this->months,
            "days"=> $this->days,
            "query"=> $date,
            "isQueried"=> "date"
        ]);
    }
    public function profit(Request $request){
        $product_data = [];
        $sales_total = 0;
        $profit_total = 0;
        $bp_sum = 0;
        $today = Carbon::today();
        foreach (product::all() as $product){
            $query =DB::table("sales")
            ->where("product_id", $product->id)
            ->where("qty", ">",0)
            ->whereMonth("updated_at", $today->month)
            ->groupBy("product_id");
            $profit = $query->sum("profit");
            $sales = $query->sum("total");
            $sales_total += $sales;
            $pcs = DB::table("sales")
                ->where("product_id", $product->id)
                ->whereMonth("updated_at", $today->month)
                ->sum("qty");
            $profit_total += $profit;
            array_push($product_data, [
                "product" => $product->name,
                "pcs" => $pcs,
                "profit" => $profit
            ]);
        }
        $expenses = DB::table("expenses")
            ->whereMonth("updated_at", $today->month)
            ->sum("amount");
        $profit_total -= $expenses;
        return view("profits", [
            "product_data"=> $product_data,
            "from" => $today->firstOfMonth(),
            "to" => $today->lastOfMonth(),
            "profit_total" => $profit_total,
            // "bp_total" => $bp_sum,
            "sales_total" => $sales_total,
            "expenses" => $expenses
        ]);
    }

    public function filter_profit(ProfitFilterRequest $request){
        $query = DB::table("sales")
                    ->select(
                        'product_id',
                        DB::raw('SUM(profit) as profit'),
                        DB::raw('SUM(total) as total'),
                        DB::raw('SUM(qty) as pcs')
                        )
                    ->whereDate("updated_at", $request->validated("from"))
                    -> groupBy("product_id");
        $data = $query->get();
        dd($data);
        $product_data = [];
        $sales_total = 0;
        $profit_total = 0;
        $bp_sum = 0;
        $from = new Carbon($request->validated("from"));
        $to = new  Carbon($request->validated("to"));
        if($from->gt($to)){
            return back()->withErrors(["dates"=> "from date cant be greater than to date"])->withInput();
        }
        if($from->eq($to)){
            foreach (product::all() as $product){
                $qry = DB::table("sales")
                    ->where("product_id", $product->id)
                    -> whereDate("updated_at", $request->validated("from"))
                    -> groupBy("product_id");
                $profit = $qry->sum("profit");
                $sales = $qry->sum("total");
                $sales_total += $sales;
                $profit_total += $profit;
                $pcs = DB::table("sales")
                    ->where("product_id", $product->id)
                    -> whereDate("updated_at", $request->validated("from"))
                    ->count();
                array_push($product_data, [
                    "product" => $product->name,
                    "pcs" => $pcs,
                    "profit" => $profit
                ]);
            }
            $expenses = DB::table("expenses")
                ->whereDate("updated_at", $request->validated("from"))
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
        foreach (product::all() as $product){
            $qry = DB::table("sales")
            ->where("product_id", $product->id)
            -> whereBetween("updated_at", [$request->validated("from"), $request->validated("to")]);
            $sales = $qry->sum("total");
            $profit = $qry->sum("profit");
            $pcs = $qry->count();
            $sales_total += $sales;
            $profit_total += $profit;
            array_push($product_data, [
                "product" => $product->name,
                "pcs" => $pcs,
                // "bp" => $bp_total,
                "profit" => $profit
            ]);
        }
        $expenses = DB::table("expenses")
            -> whereBetween("updated_at", [$request->validated("from"), $request->validated("to")])
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
