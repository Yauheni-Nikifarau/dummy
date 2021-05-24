<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class MessageController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'way' => 'string',
            'to'  => 'integer',
        ]);

        if ( ! $validator->passes()) {
            return $this->responseError('Wrong parameters', 400, $validator->errors());
        }

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
        $validator = \Validator::make($request->all(), [
            'to' => 'required|integer',
            'subject' => 'string|max:255|nullable',
            'text' => 'required|string|max:2000',
        ]);

        if ( ! $validator->passes()) {
            return $this->responseError('Wrong parameters', 400, $validator->errors());
        }

        $user_id = auth()->user()->id;

        $to_user = User::find($request->input('to'));

        if ( ! $to_user) {
            return $this->responseError('There is now user with such id', 400, ['to' => ['wrong user id']]);
        }

        try {

            DB::beginTransaction();

            $message = new Message();

            $message->from_id = $user_id;
            $message->to_id = $to_user->id;
            $message->text = $request->input('text');

            if ($request->exists('subject')) {
                $message->subject = $request->input('subject');
            }

            $message->save();

            DB::commit();

            return response([
                'success' => true,
                'message' => "Your message to {$to_user->name} {$to_user->surname} has been sent",
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
        $message = Message::find($id);

        if ( ! $message) {
            return $this->responseError('There is no message with such id', 400);
        }

        $user_id = auth()->user()->id;

        if ($message->from_id != $user_id && $message->to_id != $user_id) {
            return $this->responseError('You don\'t have message with such id', 400);
        }

        $res = Message::destroy($id);

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
     * @param $user_id
     * @return AnonymousResourceCollection
     */
    private function getAllInboxMessages($user_id)
    {
        $messages = Message::with('from', 'to')
                            ->where('to_id', $user_id)
                            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    /**
     * Returns all sent messages of concrete user
     *
     * @param $user_id
     * @return AnonymousResourceCollection
     */
    private function getAllSentMessages($user_id)
    {
        $messages = Message::with('from', 'to')
            ->where('from_id', $user_id)
            ->get();

        $messages = MessageResource::collection($messages);

        return $messages;
    }

    /**
     * Returns dialog between two users
     *
     * @param $user_id
     * @param $to_id
     * @return AnonymousResourceCollection
     */
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
