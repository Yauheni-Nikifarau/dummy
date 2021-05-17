<?php

namespace Database\Factories;

use App\Models\TagsAssign;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagsAssignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TagsAssign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trip_id' => $this->faker->numberBetween(1,25),
            'tag_id' => $this->faker->numberBetween(1,9)
        ];
    }
}
