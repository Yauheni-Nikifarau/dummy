<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $trips = Trip::with([

                'hotel',
                'discount' => function (BelongsTo $query) {
                    $query->withDefault([
                        'value' => 0,
                        'name' => null]);
                    },
                'tags'])

                ->where('reservation', '=', 0)
                ->get();

        return TripResource::collection($trips);
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
     * @return TripResource|array
     */
    public function show($id)
    {
        $trip = Trip::with([

            'hotel',
            'discount' => function (BelongsTo $query) {
                $query->withDefault([
                    'value' => 0,
                    'name' => null]);
            },
            'tags'])
            ->find($id);
        return new TripResource($trip);
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
}
