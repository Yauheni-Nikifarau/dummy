<?php

namespace Database\Factories;

use App\Models\Trip;
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
        $in = $this->faker->dateTimeBetween('-1 year', '+1 year');
        $out = $in->add(new \DateInterval('P' . $this->faker->numberBetween(7,20) . 'D'));

        return [
            'name' => $this->faker->words($this->faker->numberBetween(1,5), true),
            'price' => $this->faker->numberBetween(100, 5000),
            'date_in' => $in,
            'date_out' => $out,
            'quantity_of_people' => $this->faker->randomElement([1, 2]),
            'meal_option' => $this->faker->randomElement(['OB', 'HB', 'FB', 'BB', 'AI']),
            'reservation' => false,
            'discount_id' => $this->faker->numberBetween(1,5),
            'image' => $this->faker->image(storage_path(), 300, 300, 'travel')
        ];
    }
}
