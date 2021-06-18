<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;

class HotelController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {

        $resource = Hotel::with([

            'trips'     => function (HasMany $query) {
                $query->with(['tags', 'discount']);
                },

            'orders'    => function (HasManyThrough $query) {
                $query->with(['user', 'trip']);
                }

            ])->paginate(9);

        $count = Hotel::count();

        return $this->responseSuccess(HotelResource::collection($resource), $count);
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Hotel::with([

            'trips' => function (HasMany $query) {
                $query->with(['tags', 'discount']);
                },

            'orders' => function (HasManyThrough $query) {
                $query->with(['user', 'trip']);
                }

            ])->find($id);

        if ($resource) {
            return $this->responseSuccess(new HotelResource($resource));
        } else {
            return $this->responseError('There is no hotel with such id', 404);
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
}
