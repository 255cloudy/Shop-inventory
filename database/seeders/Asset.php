<?php

namespace Database\Seeders;

use App\Models\asset_register;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Asset extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        asset_register::factory(10)->create();
    }
}
