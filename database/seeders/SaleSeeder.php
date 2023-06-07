<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Models\product;
use App\Models\sale;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = product::all();
        for ($i=0; $i<12; $i++){
            foreach ($products as $product){
                $no_of_sales = rand(2, 20);
                    for($z=0; $z<$no_of_sales; $z++){
                        $sale = new sale();
                        $sale->product_id = $product->id;
                        $sale->qty = 1;
                        $sale->sale_price = Price::where("product_id", $product->id)->get()[0]->sale_price;
                        $sale->total = $sale->sale_price;
                        $now = Carbon::now();
                        $date = Carbon::create(
                            $now->year,
                            $i,
                            rand(0, 29),
                            rand(0, 60),
                            rand(0, 60),
                            "UTC"
                        );
                        $sale->created_at = $date->toDayDateTimeString();
                        $sale->updated_at = $date->toDayDateTimeString();
                        $sale->save();
                    }


            }
        }
    }
}
