<?php


namespace App\Http\Traits;


trait ResponseHandler
{
    public function responseSuccess ($data, $message = '', $code = 200)
    {
        return response([
            'message' => $message,
            'data' => $data,
            'success' => true
        ], $code);
    }

    public function responseError ($message = '', $code = 200, $data = [])
    {
        return response([
            'message' => $message,
            'data' => $data,
            'success' => false
        ], $code);
    }
}
