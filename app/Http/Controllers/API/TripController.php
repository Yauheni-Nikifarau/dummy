<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Discount;
use App\Models\Hotel;
use App\Models\Tag;
use App\Models\Trip;
use Carbon\Carbon;
use DB;
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
        list($trips, $count) = $this->getTripsWithFilter($request);

        return $this->responseSuccess(TripResource::collection($trips), $count);
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


    /**
     * Filter trips by different get parameters
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function getTripsWithFilter(Request $request)
    {
        $trips = Trip::with(['hotel', 'discount', 'tags']);
        $trips = $trips->leftJoin('discounts', 'trips.discount_id', '=', 'discounts.id');
        $trips = $trips->where('reservation', 0);
        $trips = $trips->select('trips.*');

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
            $hotel_name = str_replace('_', ' ', $request->input('hotel'));
            $hotels = Hotel::with(['trips'])->where('name', 'like', '%' . $hotel_name . '%')->get();
            $arrayOfTripsId = [];
            foreach ($hotels as $hotel) {
                $trips_array = $hotel->trips ?? [];
                foreach ($trips_array as $trip) {
                    $arrayOfTripsId[] = $trip->id;
                }
            }
            $arrayOfTripsId = array_unique($arrayOfTripsId);
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ($request->exists('tag')) {
            $tag_name = str_replace('_', ' ', $request->input('tag'));
            $tag = Tag::with(['trips'])->where('tag_name', $tag_name)->first();
            $trips_array = $tag->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ($request->exists('discount')) {
            $discount = Discount::with(['trips'])->where('value', $request->input('discount'))->first();
            $trips_array = $discount->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ($request->exists('min_price')) {
            $trips = $trips->whereRaw('trips.price * (100 - value) / 100 >= ?', [$request->input('min_price')]);
        }

        if ($request->exists('max_price')) {
            $trips = $trips->whereRaw('trips.price * (100 - value) / 100 <= ?', [$request->input('max_price')]);
        }

        if ($request->exists('order')) {
            $direction = $request->input('direction', 'asc');
            $trips->orderBy('trips.' . $request->input('order'), $direction);
        }

        if ($request->exists('limit')) {
            $trips->limit($request->input('limit'));
            $trips = $trips->get();
            return [$trips, 0];
        }

        $count = $trips->count();

        $trips = $trips->paginate(9);

        return [$trips, $count];
    }
}
