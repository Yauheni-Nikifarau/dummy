<?php

namespace App\Repositories;

use App\Http\DTO\TripsFilterFieldsDTO;
use App\Models\Trip as Model;
use Carbon\Carbon;

class TripsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getTripsWithFilter(TripsFilterFieldsDTO $fieldsDTO): array
    {
        $hotelsRepository    = app(HotelsRepository::class);
        $discountsRepository = app(DiscountsRepository::class);
        $tagsRepository      = app(TagsRepository::class);

        $trips = $this->startConditions()->with(['hotel', 'discount', 'tags']);
        $trips = $trips->leftJoin('discounts', 'trips.discount_id', '=', 'discounts.id');
        $trips = $trips->where('reservation', 0);
        $trips = $trips->select('trips.*');

        if ( ! empty($fieldsDTO->people)) {
            $trips = $trips->where('quantity_of_people', $fieldsDTO->people);
        }

        if ( ! empty($fieldsDTO->meal)) {
            $trips = $trips->where('meal_option', $fieldsDTO->meal);
        }

        if ( ! empty($fieldsDTO->min_date_in)) {
            $min_date_in = Carbon::createFromTimestamp($fieldsDTO->min_date_in);
            $trips       = $trips->where('date_in', '>=', $min_date_in);
        }

        if ( ! empty($fieldsDTO->max_date_in)) {
            $max_date_in = Carbon::createFromTimestamp($fieldsDTO->max_date_in);
            $trips       = $trips->where('date_in', '<=', $max_date_in);
        }

        if ( ! empty($fieldsDTO->min_date_out)) {
            $min_date_out = Carbon::createFromTimestamp($fieldsDTO->min_date_out);
            $trips        = $trips->where('date_out', '>=', $min_date_out);
        }

        if ( ! empty($fieldsDTO->max_date_out)) {
            $max_date_out = Carbon::createFromTimestamp($fieldsDTO->max_date_out);
            $trips        = $trips->where('date_out', '<=', $max_date_out);
        }

        if ( ! empty($fieldsDTO->hotel)) {
            $hotelName      = str_replace('_', ' ', $fieldsDTO->hotel);
            $hotels         = $hotelsRepository->getHotelTripsIdByPartOfHotelName($hotelName);
            $arrayOfTripsId = [];
            foreach ($hotels as $hotel) {
                $trips_array = $hotel->trips ?? [];
                foreach ($trips_array as $trip) {
                    $arrayOfTripsId[] = $trip->id;
                }
            }
            $arrayOfTripsId = array_unique($arrayOfTripsId);
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ( ! empty($fieldsDTO->tag)) {
            $tagName        = str_replace('_', ' ', $fieldsDTO->tag);
            $tag            = $tagsRepository->getRelatedToTagTripsIdByTagName($tagName);
            $trips_array    = $tag->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ( ! empty($fieldsDTO->discount)) {
            $discount       = $discountsRepository->getRelatedToDiscountTripsIdByDiscountValue($fieldsDTO->discount);
            $trips_array    = $discount->trips ?? [];
            $arrayOfTripsId = [];
            foreach ($trips_array as $trip) {
                $arrayOfTripsId[] = $trip->id;
            }
            $trips->whereIn('trips.id', $arrayOfTripsId);
        }

        if ( ! empty($fieldsDTO->min_price)) {
            $trips = $trips->whereRaw('trips.price * (100 - value) / 100 >= ?', [$fieldsDTO->min_price]);
        }

        if ( ! empty($fieldsDTO->max_price)) {
            $trips = $trips->whereRaw('trips.price * (100 - value) / 100 <= ?', [$fieldsDTO->max_price]);
        }

        if ( ! empty($fieldsDTO->order)) {
            $trips->orderBy('trips.'.$fieldsDTO->order, $fieldsDTO->direction);
        }

        if ( ! empty($fieldsDTO->limit)) {
            $trips->limit($fieldsDTO->limit);
            $trips = $trips->get();

            return [$trips, 0];
        }

        $count = $trips->count();

        $trips = $trips->paginate(9);

        return [$trips, $count];
    }

    public function getTripForShow(int $id)
    {
        return $this->startConditions()->with(['hotel', 'discount', 'tags'])->find($id);
    }

    public function getTripForCheckReservation(int $tripId)
    {
        $result = $this->startConditions()->find($tripId);

        return $result;
    }
}
