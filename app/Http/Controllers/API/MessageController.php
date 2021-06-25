<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IndexMessageRequest;
use App\Http\Resources\MessageListResource;
use App\Http\Resources\MessageResource;
use App\Mail\DialogueStart;
use App\Models\Message;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth()->id();

        $subjects = Message::select(['subject'])->where('from_id', $userId)->orWhere('to_id', $userId)->distinct()->get();

        return $this->responseSuccess(MessageListResource::collection($subjects));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subject' => 'required|int',
            'text' => 'required|string|max:2000',
        ]);

        if (!$validator->passes()) {
            return $this->responseError('Wrong parameters', 400, $validator->errors());
        }

        $message = new Message();

        $message->from_id = auth()->id();
        $message->subject = $request->input('subject');
        $message->to_id = Order::find($message->subject)->admin->id;
        $message->text = $request->input('text');

        $savingResult = $message->save();


        if ($savingResult) {

//            if ($this->isFirstMessage($userId, $toUser->id)) {
//                $this->sendEmailToRecepientAboutDialogueStart($toUser->id, $userId);
//            }

            return response([
                'success' => true,
                'message' => "Your message has been sent",
            ], 201);
        } else {
            return $this->responseError('Sorry, but something were wrong. Try again.', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return MessageResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = Message::with(['from', 'to'])->where('subject', $id)->get();

        return $this->responseSuccess(MessageResource::collection($res));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::find($id);

        if (!$message) {
            return $this->responseError('There is no message with such id', 400);
        }

        $userId = auth()->id();

        if ($message->from_id != $userId && $message->to_id != $userId) {
            return $this->responseError('You don\'t have message with such id', 400);
        }

        $res = $message->delete();

        if ($res !== 0) {
            return response([
                'success' => true,
                'message' => 'Deleted successfully',
            ], 202);
        } else {
            return $this->responseError('Sorry, but something were wrong. Try again.', 500);
        }
    }

    /**
     * Returns all inbox messages of concrete user
     *
     * @param $userId
     * @return AnonymousResourceCollection
     */
    private function getAllInboxMessages($userId)
    {
        $messages = Message::with(['from', 'to'])
            ->where('to_id', $userId)
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    /**
     * Returns all sent messages of concrete user
     *
     * @param $userId
     * @return AnonymousResourceCollection
     */
    private function getAllSentMessages($userId)
    {
        $messages = Message::with(['from', 'to'])
            ->where('from_id', $userId)
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    /**
     * Returns dialog between two users
     *
     * @param $userId
     * @param $toId
     * @return AnonymousResourceCollection
     */
    private function getDialogWith($userId, $toId)
    {
        $messages = Message::with(['from', 'to'])
            ->where(function ($query) use ($userId, $toId) {
                $query->where('from_id', $userId)
                    ->where('to_id', $toId);
            })
            ->orWhere(function ($query) use ($userId, $toId) {
                $query->where('from_id', $toId)
                    ->where('to_id', $userId);
            })
            ->orderBy('created_at', 'DESC')
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    /**
     * Checking if it was the first message to receiver
     *
     * @param $from_id
     * @param $to_id
     * @return bool
     */
    private function isFirstMessage($from_id, $to_id)
    {
        $numberOfMessages = Message::where('from_id', $from_id)->where('to_id', $to_id)->get()->count('id');
        return $numberOfMessages == 1;
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
