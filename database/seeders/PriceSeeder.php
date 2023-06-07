<?php

namespace Database\Seeders;

use App\Models\order_entry;
use App\Models\Price;
use App\Models\product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        set  a price for every product
        foreach (product::all() as $product)
        {
            $price = new Price();
            $price->sale_price = order_entry::
            where("product_id", $product->id)
            ->inRandomOrder()->first()->retail_price + 100;
            $price->product_id = $product->id;
            $price->save();
        }
    }
}
