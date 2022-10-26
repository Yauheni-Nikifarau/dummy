<?php

namespace App\Repositories;

use App\Models\Tag as Model;

class TagsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAllTags()
    {
        $result = $this->startConditions()->all();

        return $result;
    }

    public function getRelatedToTagTripsIdByTagName(string $tagName)
    {
        $result = $this->startConditions()->with(['trips'])->where('tag_name', $tagName)->first();

        return $result;
    }
}
