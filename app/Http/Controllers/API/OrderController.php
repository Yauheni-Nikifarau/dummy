<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersResource;
use App\Http\Traits\ResponseHandler;
use App\Mail\OrderReport;
use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;


class OrderController extends ApiController
{
    use ResponseHandler;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->id();
        $resource = Order::with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
                }

            ])->where('user_id', $user_id)->get();

        return $this->responseSuccess(OrdersResource::collection($resource));
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
            $order->admin_id            = User::where('role', 'admin')->where('id', '<>', $user_id)->inRandomOrder()->first()->id;

            $trip->update(['reservation' => true]);
            $order->save();

            DB::commit();

            return $this->responseSuccess([
                'success' => true,
                'message' => 'Your order confirmed' . $order->id,
            ], '',201);

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
        $order = Order::with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
                },

            ])->find($id);

        if ($order && $order->user->id == auth()->id()) {
            return $this->responseSuccess(new OrderResource($order));
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

    /**
     * Download or sends by email an order's report file in necessary extension
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
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

        $fileFullPath = $order->createReport();

        $sendViaEmail = $request->input('send_via_email');

        $extension = $request->input('extension', 'docx');

        if ($extension == 'pdf') {
            $phpWord = IOFactory::load($fileFullPath, 'Word2007');
            $domPdfPath = base_path( 'vendor/dompdf/dompdf');
            Settings::setPdfRendererPath($domPdfPath);
            Settings::setPdfRendererName('DomPDF');
            $fileFullPath = str_replace('.docx', '.pdf', $fileFullPath);
            $phpWord->save($fileFullPath, 'PDF');
        }

        preg_match('/ordersReports.*/',$fileFullPath, $relativePath);

        if ($sendViaEmail == 'true') {
            Mail::to($user)->send(new OrderReport($fileFullPath, $extension));
            return $this->responseSuccess([], 'Check your email box');
        } else {
            return $this->responseSuccess($relativePath);
        }
    }
}
