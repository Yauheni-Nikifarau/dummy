<?php

namespace App\Http\Controllers\API;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends ApiController
{
    public function index () {
        return $this->responseSuccess(Tag::all());
    }
}
