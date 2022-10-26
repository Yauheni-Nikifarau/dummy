<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\AnonymousResourceCollection|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->responseSuccess(UserResource::collection(User::all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return UserResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = User::find($id);
        if ($res) {
            return $this->responseSuccess(new UserResource($res));
        } else {
            return $this->responseError('There is no user with such id', 404);
        }

    }
}
