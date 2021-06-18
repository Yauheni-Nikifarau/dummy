<?php

namespace App\Http\Controllers\API;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountsController extends ApiController
{
    public function index () {
        return $this->responseSuccess(Discount::all());
    }
}
