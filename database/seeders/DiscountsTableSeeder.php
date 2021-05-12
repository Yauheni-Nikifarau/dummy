<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('discounts')->delete();

        Discount::create(['name' => 'hot tour', 'value' => 35]);
        Discount::create(['name' => 'early booking', 'value' => 10]);
        Discount::create(['name' => 'special offer 5', 'value' => 5]);
        Discount::create(['name' => 'special offer 15', 'value' => 15]);
        Discount::create(['name' => 'special offer 25', 'value' => 25]);
    }
}
