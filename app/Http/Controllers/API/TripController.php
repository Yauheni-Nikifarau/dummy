<?php

namespace App\Http\Controllers\API;

use App\Http\DTO\TripsFilterFieldsDTO;
use App\Http\Requests\GetTripsRequest;
use App\Http\Resources\TripResource;
use App\Repositories\TripsRepository;

class  TripController extends ApiController
{

    private TripsRepository $tripsRepository;

    public function __construct()
    {
        parent::__construct();

        $this->tripsRepository = app(TripsRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(
        GetTripsRequest $request,
        TripsFilterFieldsDTO $fieldsDTO
    ) {
        $filterFields = $request->validated();

        foreach ($filterFields as $fieldName => $fieldValue) {
            $fieldsDTO->$fieldName = $fieldValue;
        }

        list($trips, $count) = $this->tripsRepository->getTripsWithFilter($fieldsDTO);

        return $this->responseSuccess(TripResource::collection($trips), $count);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return TripResource|array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $trip = $this->tripsRepository->getTripForShow($id);

        if ($trip) {
            return $this->responseSuccess(new TripResource($trip));
        } else {
            return $this->responseError('There is no trip with such id', 404);
        }

    }

}
