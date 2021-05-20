<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Trip;
use DateInterval;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;



class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $resource = Order::with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
                },

            'user'

            ])->get();

        return $this->responseSuccess(OrderResource::collection($resource));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|int',
        ]);

        $order = new Order();

        $trip_id = $request->input('trip_id');
        $user_id = auth()->user()->id ?? null;

        $trip = Trip::find($trip_id);

        if ( ! $user_id) {
            return $this->responseError('Who are you?', 400);
        }

        if ( ! $trip) {
            return $this->responseError('There is no trip with such id', 400);
        }

        if ($trip->reservation) {
            return $this->responseError('This trip has been reservated', 400);
        }

        $reservation_expires = new \DateTime();
        $reservation_expires->add(new DateInterval("P3D"));

        $order->trip_id = $trip_id;
        $order->user_id = $user_id;
        $order->paid = false;
        $order->reservation_expires = $reservation_expires;
        $order->price = $trip->price * (100 - ($trip->discount->value ?? 0)) / 100;

        $trip->reservation = true;

        $tripResult = $trip->save();

        if ($tripResult) {
            $orderResult = $order->save();

            if ($orderResult) {
                return response([
                    'success' => true,
                    'message' => 'Your order confirmed',
                ], 201);
            } else {
                $trip->rollback();
            }
        }
        return $this->responseError('Sorry, but something were wrong. Try again.', 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return OrderResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Order::with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
                },

            'user'

            ])->find($id);

        if ($resource) {
            return $this->responseSuccess(new OrderResource($resource));
        } else {
            return $this->responseError('There is no order with such id', 404);
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
