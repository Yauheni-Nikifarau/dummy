<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Database\Factories\HotelFactory;
use Illuminate\Database\Seeder;

class HotelsLatLonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotels = Hotel::all();
        $factory = new HotelFactory();
        $hotels->each(function ($hotel) use ($factory) {
            $latitude = $factory->fakeLatitude();
            $longitude = $factory->fakeLongitude();
            $hotel->update([
                'latitude' => $latitude,
                'longitude' => $longitude
            ]);
        });
    }
}
