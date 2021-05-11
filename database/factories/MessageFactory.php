<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        while (1) {
            $from = $this->faker->numberBetween(1,50);
            $to = $this->faker->numberBetween(1,50);
            if ($from != $to) {
                break;
            }
        }

        return [
            'from_id' => $from,
            'to_id' => $to,
            'subject' => $this->faker->words($this->faker->numberBetween(1,5), true),
            'text' => $this->faker->paragraphs($this->faker->numberBetween(1,5), true)
        ];
    }
}
