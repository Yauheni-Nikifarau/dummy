<?php

namespace App\Repositories;

use App\Models\Trip as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrdersRepository extends CoreRepository
{

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getUserIdOfOrderByOrderId(int $id)
    {
        $order = $this->startConditions()->with(['user'])->find($id);

        if ( ! $order) {
            return false;
        }

        return $order->user->id;
    }

    public function getAdminIdOfOrderByOrderID(int $id)
    {
        $adminId = $this->startConditions()->find($id)->admin->id;

        return $adminId;
    }

    public function getOrdersForUserAllOrdersPage(int $userId)
    {
        $result = $this->startConditions()->with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
            }

        ])->where('user_id', $userId)->get();

        return $result;
    }

    public function getOrderForDetailsPage(int $orderId)
    {
        $result = $this->startConditions()->with([

            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
            },

        ])->find($orderId);

        return $result;
    }

    public function getOrderForBuildingReport(int $orderId)
    {
        $result = $this->startConditions()->with([
            'trip' => function (BelongsTo $query) {
                $query->with(['hotel']);
            }, 'user'
        ])->find($orderId);

        return $result;
    }
}
