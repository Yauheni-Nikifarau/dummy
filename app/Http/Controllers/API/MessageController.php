<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageListResource;
use App\Http\Resources\MessageResource;
use App\Mail\DialogueStart;
use App\Models\Message;
use App\Models\User;
use App\Repositories\MessagesRepository;
use App\Repositories\OrdersRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;

class MessageController extends ApiController
{

    private MessagesRepository $messagesRepository;
    private OrdersRepository $ordersRepository;

    public function __construct()
    {
        parent::__construct();

        $this->messagesRepository = app(MessagesRepository::class);
        $this->ordersRepository   = app(OrdersRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->id();

        $dialogues = $this->messagesRepository->getUserDialoguesAboutOrders($userId);

        return $this->responseSuccess(MessageListResource::collection($dialogues));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {

        $message = new Message();

        $message->from_id = auth()->id();
        $message->subject = $request->input('subject');
        $message->to_id   = $this->ordersRepository->getAdminIdOfOrderByOrderID($message->subject);
        $message->text    = $request->input('text');

        $savingResult = $message->save();

        if ($savingResult) {

            return response([
                'success' => true, 'message' => "Your message has been sent",
            ], 201);
        } else {
            return $this->responseError('Sorry, but something were wrong. Try again.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return MessageResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show(int $id)
    {
        if ($this->ordersRepository->getUserIdOfOrderByOrderId($id) !== auth()->id()) {
            return $this->responseError("You didn't have an order with such number", 400);
        }
        $messages = $this->messagesRepository->getMessagesListAboutOrder($id);

        return $this->responseSuccess(MessageResource::collection($messages));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $message = $this->messagesRepository->getMessageForDelete($id);

        if ( ! $message) {
            return $this->responseError('There is no message with such id', 400);
        }

        $userId = auth()->id();

        if ($message->from_id != $userId && $message->to_id != $userId) {
            return $this->responseError('You don\'t have message with such id', 400);
        }

        $res = $message->delete();

        if ($res !== 0) {
            return response([
                'success' => true, 'message' => 'Deleted successfully',
            ], 202);
        } else {
            return $this->responseError('Sorry, but something were wrong. Try again.', 500);
        }
    }

    /**
     * Sends a mail to User with $toUserId ID about starting a conversation with User with $fromUserId ID
     *
     * @param $toUserId
     * @param $fromUserId
     */
    private function sendEmailToRecepientAboutDialogueStart($toUserId, $fromUserId)
    {
        Mail::to(User::find($toUserId))->send(new DialogueStart($toUserId, $fromUserId));
    }
}
