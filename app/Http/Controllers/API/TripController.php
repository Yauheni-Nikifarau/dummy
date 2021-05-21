<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Tag;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class TripController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $trips = $this->getTripsWithFilter($request);

        return $this->responseSuccess(TripResource::collection($trips));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TripResource|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $trip = Trip::with(['hotel', 'discount', 'tags'])
                ->find($id);

        if ($trip) {
            return $this->responseSuccess(new TripResource($trip));
        } else {
            return $this->responseError('There is no trip with such id', 404);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getTripsWithFilter(Request $request)
    {
        $trips = Trip::with(['hotel', 'discount', 'tags']);
        $trips = $trips->where('reservation', 0);

        if ($request->exists('people')) {
            $trips = $trips->where('quantity_of_people', $request->input('people'));
        }

        if ($request->exists('meal')) {
            $trips = $trips->where('meal_option', $request->input('meal'));
        }

        if ($request->exists('min_date_in')) {
            $min_date_in = Carbon::createFromTimestamp($request->input('min_date_in'));
            $trips = $trips->where('date_in', '>=', $min_date_in);
        }

        if ($request->exists('max_date_in')) {
            $max_date_in = Carbon::createFromTimestamp($request->input('max_date_in'));
            $trips = $trips->where('date_in', '<=', $max_date_in);
        }

        if ($request->exists('min_date_out')) {
            $min_date_out = Carbon::createFromTimestamp($request->input('min_date_out'));
            $trips = $trips->where('date_out', '>=', $min_date_out);
        }

        if ($request->exists('max_date_out')) {
            $max_date_out = Carbon::createFromTimestamp($request->input('max_date_out'));
            $trips = $trips->where('date_out', '<=', $max_date_out);
        }

        if ($request->exists('hotel')) {
            preg_match('/_[0-9]+$/', $request->input('hotel'), $matches);
            $hotel_id = substr(end($matches), 1);
            $trips = $trips->where('hotel_id', $hotel_id);
        }

        if ($request->exists('tag')) {
            preg_match('/_[0-9]+$/', $request->input('tag'), $matches);
            $tag_id = substr(end($matches),1);
            $trips_array = Tag::find($tag_id)->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('id', $arrayOfTripsId);
        }

        $trips = $trips->get();

        if ($request->exists('min_price') && $request->exists('max_price')) {

            $min_price = $request->input('min_price');
            $max_price = $request->input('max_price');

            $trips = $trips->filter(function ($trip) use ($min_price, $max_price) {

                $discount = $trip->discount->value ?? 0;
                $price = $trip->price * (100 - $discount) / 100;
                return $price >= $min_price && $price <= $max_price;

            });

        } elseif ($request->exists('min_price')) {

            $min_price = $request->input('min_price');

            $trips = $trips->filter(function ($trip) use ($min_price) {

                $discount = $trip->discount->value ?? 0;
                $price = $trip->price * (100 - $discount) / 100;
                return $price >= $min_price;

            });

        } elseif ($request->exists('max_price')) {

            $max_price = $request->input('max_price');

            $trips = $trips->filter(function ($trip) use ($max_price) {

                $discount = $trip->discount->value ?? 0;
                $price = $trip->price * (100 - $discount) / 100;
                return $price <= $max_price;

            });
        }

        return $trips;
    }
}
