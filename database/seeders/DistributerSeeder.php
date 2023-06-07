<?php

namespace Database\Seeders;

use App\Models\distributer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistributerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        distributer::factory()->count(5)->create();
    }
}
