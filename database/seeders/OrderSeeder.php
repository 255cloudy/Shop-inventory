<?php

namespace Database\Seeders;

use App\Models\distributer;
use App\Models\order;
use App\Models\order_entry;
use App\Models\product;
use App\Models\stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<5; $i++){
            $total = 0;
            $distributer = distributer::inRandomOrder()->first();
            $order = order::factory()->create([
                "distributer_id" => $distributer->id,
            ]);
            foreach(product::all() as $product){
                $entry = order_entry::factory()->create(
                    [
                        "product_id"=> $product->id,
                        "order_id" => $order->id
                    ]
                );
                $cost = $entry->qty * $entry->retail_price;
                $stock = stock::where("product_id", $product->id)->get();
                if($stock->isEmpty()){
                    $stock = new Stock();
                    $stock->product_id= $product->id;
                    $stock->retail_price = $entry->retail_price;
                    $stock->qty = $entry->qty;
                    $stock->save();
                }else{
                    $stock[0]->qty += $entry->qty;
                    $stock[0]->retail_price = $entry->retail_price;
                }
                $total += $cost;
            }
            $order->update([
                "total" => $total
            ]);
        }
    }
}
