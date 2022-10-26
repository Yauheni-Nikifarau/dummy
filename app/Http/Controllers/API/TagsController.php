<?php

namespace App\Http\Controllers\API;

use App\Repositories\TagsRepository;

class TagsController extends ApiController
{
    public function index(TagsRepository $tagsRepository)
    {
        return $this->responseSuccess($tagsRepository->getAllTags());
    }
}

