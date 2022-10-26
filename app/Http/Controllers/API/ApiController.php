<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseHandler;

class ApiController extends Controller
{
    use ResponseHandler;

    public function __construct()
    {
    }
}
