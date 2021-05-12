<?php

namespace Database\Seeders;

use App\Models\TagsAssign;
use Illuminate\Database\Seeder;

class TagsAssignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagsAssign::factory()->count(50)->create();
    }
}
