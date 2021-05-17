<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function responseSuccess ($data, $message = '')
    {
        return response([
            'message' => $message,
            'data' => $data,
            'success' => true
        ]);
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
