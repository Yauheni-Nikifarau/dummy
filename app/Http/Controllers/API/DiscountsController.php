<?php

namespace App\Http\Controllers\API;

use App\Repositories\DiscountsRepository;

class DiscountsController extends ApiController
{
    public function index(DiscountsRepository $discountsRepository)
    {
        return $this->responseSuccess($discountsRepository->getAllDiscounts());
    }
}
