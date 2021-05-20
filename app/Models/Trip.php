<?php

namespace App\Models;

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

        //tag_id

        $trips = Trip::with(['hotel', 'discount', 'tags']);
        $trips = $trips->where('reservation', 0);

        if ($min_price = $request->input('min_price')) {
            $trips = $trips->where('price', '>=', $min_price);
        }

        if ($max_price = $request->input('max_price')) {
            $trips = $trips->where('price', '<=', $max_price);
        }

        if ($quantity_of_people = $request->input('quantity_of_people')) {
            $trips = $trips->where('quantity_of_people', $quantity_of_people);
        }

        if ($meal_option = $request->input('meal_option')) {
            $trips = $trips->where('meal_option', $meal_option);
        }

        if ($min_date_in = $request->input('min_date_in')) {
            $min_date_in = (new \DateTime())->setTimestamp($min_date_in);
            $trips = $trips->where('date_in', '>=', $min_date_in);
        }

        if ($max_date_in = $request->input('max_date_in')) {
            $max_date_in = (new \DateTime())->setTimestamp($max_date_in);
            $trips = $trips->where('date_in', '<=', $max_date_in);
        }

        if ($min_date_out = $request->input('min_date_out')) {
            $min_date_out = (new \DateTime())->setTimestamp($min_date_out);
            $trips = $trips->where('date_out', '>=', $min_date_out);
        }

        if ($max_date_out = $request->input('max_date_out')) {
            $max_date_out = (new \DateTime())->setTimestamp($max_date_out);
            $trips = $trips->where('date_out', '<=', $max_date_out);
        }



        $trips = $trips->where('quantity_of_people', '>', 0);

        $trips = $trips->where('price', '<', 10000000);
        $trips = $trips->get();
        return $trips;
    }
}
