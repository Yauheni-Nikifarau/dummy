<?php

namespace App\Repositories;

use App\Models\Hotel as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class HotelsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getHotelTripsIdByPartOfHotelName(string $hotelName)
    {
        $result = $this->startConditions()->with(['trips'])->where('name', 'like', '%'.$hotelName.'%')->get();

        return $result;
    }

    public function getAllHotels()
    {
        $result = $this->startConditions()->with([

            'trips' => function (HasMany $query) {
                $query->with(['tags', 'discount']);
            },

            'orders' => function (HasManyThrough $query) {
                $query->with(['user', 'trip']);
            }

        ])->paginate(9);

        return $result;
    }

    public function getHotelForShow(int $id)
    {
        $result = $this->startConditions()->with([

            'trips' => function (HasMany $query) {
                $query->with(['tags', 'discount']);
            },

            'orders' => function (HasManyThrough $query) {
                $query->with(['user', 'trip']);
            }

        ])->find($id);

        return $result;
    }

    public function countAllHotels()
    {
        $result = $this->startConditions()->count();

        return $result;
    }

}
