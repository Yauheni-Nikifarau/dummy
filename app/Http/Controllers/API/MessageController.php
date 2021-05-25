<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\IndexMessageRequest;
use App\Http\Resources\MessageResource;
use App\Mail\DialogueStart;
use App\Models\Message;
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
    public function index(IndexMessageRequest $request)
    {
        $userId = auth()->id();

        $way = $request->input('way', 'inbox');

        switch ($way) {
            case 'inbox':
                $messages = $this->getAllInboxMessages($userId);
                break;
            case 'sent':
                $messages = $this->getAllSentMessages($userId);
                break;
            case 'dialogue':
                $messages = $this->getDialogWith($userId, $request->input('to'));
                break;
        }

        return $this->responseSuccess($messages);
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
            'to' => 'required|integer|exists:users,id',
            'subject' => 'string|max:255|nullable',
            'text' => 'required|string|max:2000',
        ]);

        if (!$validator->passes()) {
            return $this->responseError('Wrong parameters', 400, $validator->errors());
        }

        $userId = auth()->id();

        $toUser = User::find($request->input('to'));

        $message = new Message();

        $message->from_id = $userId;
        $message->to_id = $toUser->id;
        $message->text = $request->input('text');
        $message->subject = $request->input('subject');

        $savingResult = $message->save();

        if ($savingResult) {

            if ($this->isFirstMessage($userId, $toUser->id)) {
                $this->sendEmailToRecepientAboutDialogueStart($toUser->id, $userId);
            }

            return response([
                'success' => true,
                'message' => "Your message to {$toUser->name} {$toUser->surname} has been sent",
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
        $res = Message::with(['from', 'to'])->find($id);

        if ($res) {
            return $this->responseSuccess(new MessageResource($res));
        } else {
            return $this->responseError('There is no message with such id', 404);
        }
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

    private function sendEmailToRecepientAboutDialogueStart($toUserId, $fromUserId)
    {
        Mail::to(User::find($toUserId))->send(new DialogueStart($toUserId, $fromUserId));
    }


}
