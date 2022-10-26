<?php

namespace App\Repositories;

use App\Models\Discount as Model;

class DiscountsRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getRelatedToDiscountTripsIdByDiscountValue(int $discountValue)
    {
        $result = $this->startConditions()->with(['trips'])->where('value', $discountValue)->first();

        return $result;
    }

    public function getAllDiscounts()
    {
        $result = $this->startConditions()->all();

        return $result;
    }

}
