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

        Discount::create(['name' => 'testdiscount', 'value' => 25]);
    }
}
