<?php


namespace App\Http\Traits;


trait ResponseHandler
{
    /**
     * Returns JSON Response designed for ajax based applications about success request
     *
     * @param $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function responseSuccess ($data, $message = '', $code = 200)
    {
        return response([
            'message' => $message,
            'data' => $data,
            'success' => true
        ], $code);
    }

    /**
     * Returns JSON Response designed for ajax based applications about error request
     *
     * @param string $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function responseError ($message = '', $code = 200, $data = [])
    {
        return response([
            'message' => $message,
            'data' => $data,
            'success' => false
        ], $code);
    }
}
