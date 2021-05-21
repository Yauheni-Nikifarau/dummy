<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //TODO:make validation
        //$messages = $this->responseSuccess(MessageResource::collection(Message::with('from', 'to')->get()));
        $user_id = auth()->user()->id;

        $way = $request->input('way') ?? 'inbox';

        switch ($way) {
            case 'inbox':
                $messages = $this->getAllInboxMessages($user_id);
                break;
            case 'sent':
                $messages = $this->getAllSentMessages($user_id);
                break;
            case 'dialog':
                if ($request->exists('to')) {

                    $to_id = User::find($request->input('to'))->id;

                    if ($to_id) {
                        $messages = $this->getDialogWith($user_id, $to_id);
                    } else {
                        return $this->responseError('No user with such id', 400);
                    }

                } else {
                    return $this->responseError('No opponent id', 400);
                }
                break;
            default:
                return $this->responseError('Wrong messaging way', 400);
        }

        dd($messages);

        return $this->responseSuccess($messages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO: make messages storing
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return MessageResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = Message::with('from', 'to')->find($id);

        if ($res) {
            return $this->responseSuccess(new MessageResource($res));
        } else {
            return $this->responseError('There is no message with such id', 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO: make messages deleting
    }

    private function getAllInboxMessages($user_id)
    {
        $messages = Message::with('from', 'to')
                            ->where('to_id', $user_id)
                            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    private function getAllSentMessages($user_id)
    {
        $messages = Message::with('from', 'to')
            ->where('from_id', $user_id)
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    private function getDialogWith($user_id, $to_id)
    {
        $messages = Message::with('from', 'to')
            ->where(function ($query) use ($user_id, $to_id) {
                $query->where('from_id', $user_id)
                        ->where('to_id', $to_id);
            })
            ->orWhere(function ($query) use ($user_id, $to_id) {
                $query->where('from_id', $to_id)
                    ->where('to_id', $user_id);
            })
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }


}
