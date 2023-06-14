<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private function monthly_sales(){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        return DB::table("sales")
                        ->whereYear("updated_at", $year)
                        ->whereMonth("updated_at", $month)
                        ->sum("sale_price");
    }
    private function bestDay(){
        $now = Carbon::now();
        $year = $now->year;
        $month = $now->month;
        $monthly_sales = DB::table("sales")
            ->whereYear("updated_at", $year)
            ->whereMonth("updated_at", $month)
            ->get();
        $days = [0, 0, 0, 0, 0, 0, 0];
        foreach ($monthly_sales as $sale){
            $date = new Carbon($sale->updated_at);
            $day = $date->dayOfWeek;
            $days[$day] += 1;
        }
        $index = array_search(max($days), $days);
        $day_in_words = "";
        switch ($index) {
            case 0:
                $day_in_words = "Sunday";
                break;
            case 1:
                $day_in_words = "Monday";
                break;
            case 2:
                $day_in_words = "Tuesday";
                break;
            case 3:
                $day_in_words = "Wednesday";
                break;
            case 4:
                $day_in_words = "Thursday";
                break;
            case 5:
                $day_in_words = "Friday";
                break;
            case 6:
                $day_in_words = "Saturday";
                break;
        }
        return $day_in_words;
    }
    private function bestSeller(){
        $date = Carbon::now();
        $highest = 0;
        $best = "";
        foreach (product::all() as $product){
            $sum = DB::table("sales")
                ->where("product_id", $product->id)
                ->whereYear("updated_at", $date->year)
                ->whereMonth("updated_at", $date->month)
                ->sum("sale_price");
            if($sum>$highest){
                $highest = $sum;
                $best = $product->name;
            }
        }
        return [$best, $highest];
    }
    private function getsalesCashMonthly($year){
        $monthly_totals = [];
        $total = 0;
        for($month=1; $month<=12; $month++){
            $monthly_total = DB::table("sales")
                                    ->whereYear("updated_at", $year)
                                    ->whereMonth("updated_at", $month)
                                    ->sum("sale_price");
            $monthly_totals[$month] = $monthly_total;
            $total += $monthly_total;
        }
        $counter = 1;
        foreach ($monthly_totals as $monthly_total) {
            $monthly_totals[$counter] = $monthly_total*100/$total;
            $counter++;
        }

        return $monthly_totals;
    }
    function getMonthlySalesPcs($year){
        $monthly_totals = [];
        $total = 0;
        for($month=1; $month<=12; $month++){
            $monthly_total = DB::table("sales")
                ->whereYear("updated_at", $year)
                ->whereMonth("updated_at", $month)
                ->count();
            $monthly_totals[$month] = $monthly_total;
            $total += $monthly_total;
        }
        $counter = 1;
        foreach ($monthly_totals as $monthly_total) {
            $monthly_totals[$counter] = $monthly_total*100/$total;
            $counter++;
        }
        return $monthly_totals;
    }
    public function show(){
        $today = Carbon::today()->toDateString();
//        get the sales for a current day
        $sales_today = DB::table("sales")
                ->whereDate("updated_at", $today)
                ->sum("sale_price");
        $sales_this_month = $this->monthly_sales();
        $best_day = $this->bestDay();
        $best_seller = $this->bestSeller();
        $best_product = $best_seller[0];
        $best_product_sales = $best_seller[1];
        return view('dashboard',[
            "sales_today" => $sales_today,
            "sales_this_month" => $sales_this_month,
            "best_day"=> $best_day,
            "best_product" => $best_product,
            "best_product_sales" => $best_product_sales,
            "sales_cash" => $this->getsalesCashMonthly(Carbon::now()->year),
            "sales_pcs" => $this->getMonthlySalesPcs(Carbon::now()->year)
        ]);
    }

}
