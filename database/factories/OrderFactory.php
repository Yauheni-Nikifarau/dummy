<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tripId = $this->faker->numberBetween(1,25);
        $userId = User::where('role', '=', 'client')->inRandomOrder()->first()->id;
//        while (1) {
//            $userId = $this->faker->numberBetween(1,50);
//            if (User::all()->find($userId)->role == 'client') {
//                break;
//            }
//        }
        $paid = $this->faker->boolean();

        //calculate price
        $trip = Trip::all()->find($tripId);
        $startPrice = $trip->price;
        $discount = $trip->discount->value;
        $price = $startPrice * (100 - $discount) / 100;

        $reservation = $this->faker->dateTimeBetween('-3 months', '+3 days');

        return [
            'trip_id' => $tripId,
            'user_id' => $userId,
            'paid' => $paid,
            'price' => $price,
            'reservation_expires' => $reservation
        ];
    }
}
