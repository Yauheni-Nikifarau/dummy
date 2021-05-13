<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagsAssignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function tags()
    {
        $res =[];

        $assigns = $this->resource;

        foreach ($assigns as $assign) {
            $res[] = [
                'id'             => $assign->id,
                'name'           => $assign->tag->tag_name
            ];
        }

        return $res;
    }
}
