<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Fetch all product_ids from the source table (e.g., 'products')
        $product_ids = DB::table('products')->pluck('id')->toArray();

        // Check if there are products to process
        if (empty($product_ids)) {
            $this->command->info('No products found to seed inventory.');
            return;
        }

        $inventory_data = [];
        $timestamp = now(); // Use Laravel's helper for the current timestamp

        // 2. Prepare the inventory records
        foreach ($product_ids as $product_id) {
            $inventory_data[] = [
                'product_id'   => $product_id,
                'retail_price' => 0.00, // Set to zero (adjust based on your column type)
                'qty'          => 0,    // Set to zero
                'created_at'   => $timestamp,
                'updated_at'   => $timestamp,
            ];
        }
        DB::table('stocks')->insert($inventory_data);

        $this->command->info('Successfully seeded ' . count($inventory_data) . ' inventory records with zeros.');
    }
}