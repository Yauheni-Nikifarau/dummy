<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::create(['tag_name' => 'children']);
        Tag::create(['tag_name' => 'beach']);
        Tag::create(['tag_name' => 'rent auto']);
        Tag::create(['tag_name' => 'hot tour']);
        Tag::create(['tag_name' => 'diving']);
        Tag::create(['tag_name' => 'surfing']);
        Tag::create(['tag_name' => 'bbq']);
        Tag::create(['tag_name' => '24 hours bar']);
        Tag::create(['tag_name' => 'self-service buffet']);
    }
}
