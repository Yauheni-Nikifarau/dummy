<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\HotelResource;
use App\Repositories\HotelsRepository;

class HotelController extends ApiController
{

    private HotelsRepository $hotelsRepository;

    public function __construct()
    {
        parent::__construct();

        $this->hotelsRepository = app(HotelsRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {

        $hotels = $this->hotelsRepository->getAllHotels();

        $count = $this->hotelsRepository->countAllHotels();

        return $this->responseSuccess(HotelResource::collection($hotels), $count);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $hotel = $this->hotelsRepository->getHotelForShow($id);

        if ($hotel) {
            return $this->responseSuccess(new HotelResource($hotel));
        } else {
            return $this->responseError('There is no hotel with such id', 404);
        }
    }

}
