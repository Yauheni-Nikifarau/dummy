<?php

namespace Database\Factories;

use App\Models\Trip;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateIn     = $this->faker->dateTimeBetween('-1 year', '+1 year');
        $duration   = $this->faker->numberBetween(7,20);
        $dateOut    = new DateTime( $dateIn->format('Y-m-d H:i:sP'));

        $dateOut->add(new DateInterval("P{$duration}D"));

        $imagePath = $this->faker->image(storage_path('app/public/tripsWallpapers'), 300, 300, 'travel');

        return [
            'name'                 => $this->faker->words($this->faker->numberBetween(1,5), true),
            'price'                => $this->faker->numberBetween(100, 5000),
            'date_in'              => $dateIn,
            'date_out'             => $dateOut,
            'quantity_of_people'   => $this->faker->randomElement([1, 2]),
            'meal_option'          => $this->faker->randomElement(['OB', 'HB', 'FB', 'BB', 'AI']),
            'hotel_id'             => $this->faker->numberBetween(1, 20),
            'reservation'          => false,
            'discount_id'          => $this->faker->randomElement([null, $this->faker->numberBetween(1,5)]),
            'image'                => str_replace(storage_path('app/public/'), '', $imagePath)
        ];
    }
}
