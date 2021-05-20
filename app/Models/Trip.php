<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Trip extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'tags_assigns');
    }

    public static function getTripsWithFilter (Request $request) {

        $trips = Trip::with(['hotel', 'discount', 'tags']);
        $trips = $trips->where('reservation', 0);

//        if ($min_price = $request->input('min_price')) {
//            $trips = $trips->where('price', '>=', $min_price);
//        }
//
//        if ($max_price = $request->input('max_price')) {
//            $trips = $trips->where('price', '<=', $max_price);
//        }

        if ($quantity_of_people = $request->input('people')) {
            $trips = $trips->where('quantity_of_people', $quantity_of_people);
        }

        if ($meal_option = $request->input('meal')) {
            $trips = $trips->where('meal_option', $meal_option);
        }

        if ($min_date_in = $request->input('min_date_in')) {
            $min_date_in = Carbon::createFromTimestamp($min_date_in);
            $trips = $trips->where('date_in', '>=', $min_date_in);
        }

        if ($max_date_in = $request->input('max_date_in')) {
            $max_date_in = Carbon::createFromTimestamp($max_date_in);
            $trips = $trips->where('date_in', '<=', $max_date_in);
        }

        if ($min_date_out = $request->input('min_date_out')) {
            $min_date_out = Carbon::createFromTimestamp($min_date_out);
            $trips = $trips->where('date_out', '>=', $min_date_out);
        }

        if ($max_date_out = $request->input('max_date_out')) {
            $max_date_out = Carbon::createFromTimestamp($max_date_out);
            $trips = $trips->where('date_out', '<=', $max_date_out);
        }

        if ($hotel = $request->input('hotel')) {
            preg_match('/_[0-9]+$/', $hotel, $matches);
            $hotel_id = substr(end($matches), 1);
            $trips = $trips->where('hotel_id', $hotel_id);
        }

        if ($tag = $request->input('tag')) {
            preg_match('/_[0-9]+$/', $tag, $matches);
            $tag_id = substr(end($matches),1);
            $trips_array = Tag::find($tag_id)->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('id', $arrayOfTripsId);
        }

        $trips = $trips->get();


        $min_price = $request->input('min_price');
        $max_price = $request->input('max_price');

        if ($min_price || $max_price) {

            $min_price = $min_price ?: 0;
            $max_price = $max_price ?: 9999999999999999999999;

            $trips = $trips->filter(function ($trip) use ($min_price, $max_price) {

                $discount = $trip->discount->value ?? 0;
                $price = $trip->price * (100 - $discount) / 100;
                return $price >= $min_price && $price <= $max_price;

            });
        }

        return $trips;
    }
}
