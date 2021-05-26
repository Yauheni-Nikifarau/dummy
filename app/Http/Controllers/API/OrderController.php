<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Mail\OrderReport;
use App\Models\Order;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpWord\TemplateProcessor;


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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|int',
        ]);

        $trip_id = $request->input('trip_id');
        $user_id = auth()->user()->id ?? null;

        $trip = Trip::find($trip_id);

        if ( ! $trip) {
            return $this->responseError('There is no trip with such id', 400);
        }

        if ($trip->reservation) {
            return $this->responseError('This trip has been booked', 400);
        }

        $reservation_expires = Carbon::now()->addDays(3);

        try {

            DB::beginTransaction();

            $order = new Order();

            $order->trip_id             = $trip_id;
            $order->user_id             = $user_id;
            $order->paid                = false;
            $order->reservation_expires = $reservation_expires;
            $order->price               = $trip->price * (100 - ($trip->discount->value ?? 0)) / 100;

            $trip->update(['reservation' => true]);
            $order->save();

            DB::commit();

            return response([
                'success' => true,
                'message' => 'Your order confirmed',
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return $this->responseError('Sorry, but something were wrong. Try again.', 500);
        }

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

    public function report(Request $request, $id)
    {
        $user = auth()->user();

        $order = Order::with([
                    'trip' => function (BelongsTo $query) {
                        $query->with(['hotel']);
                    },
                    'user'
                ])->find($id);


        if (!$order) {
            return $this->responseError('there is no trip with such id', 400);
        }

        if ($order->user != $user) {
            return $this->responseError('It is no your trip', 400);
        }

        $paid = $order->paid ? 'Yes' : 'No';

        $imageFileName = str_replace('storage//', '', $order->trip->image);
        $imagePath = storage_path('app/public') . '/' . $imageFileName;

        $template = new TemplateProcessor('template.docx');

        $template->setValue('name', $user->name);
        $template->setValue('surname', $user->surname);
        $template->setValue('orderId', $order->id);
        $template->setValue('hotelName', $order->trip->hotel->name);
        $template->setValue('hotelCountry', $order->trip->hotel->country);
        $template->setValue('dateIn', $order->trip->date_in);
        $template->setValue('dateOut', $order->trip->date_out);
        $template->setValue('orderCreatedAt', $order->created_at);
        $template->setValue('price', $order->price);
        $template->setValue('paid', $paid);
        $template->setImageValue('image', $imagePath);

        $filename = "dummy_order_{$user->name}_{$user->surname}_{$id}_" . Carbon::now()->format('Y-m-d_H:i:s');
        $fileFullPath = storage_path('app/public/ordersReports') . '/' . $filename . '.docx';

        $template->saveAs($fileFullPath);

        $sendViaEmail = $request->input('send_via_email') ?? null;

        if ($sendViaEmail == 'yes') {
            Mail::to($user)->send(new OrderReport($fileFullPath));
            return $this->responseSuccess([], 'Check your email box');
        } else {
            return \Response::download($fileFullPath);
        }
    }
}
