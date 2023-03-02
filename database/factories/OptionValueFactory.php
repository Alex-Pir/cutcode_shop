<?php

namespace Database\Factories;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OptionValue>
 */
class OptionValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word()),
            'option_id' => Option::query()->inRandomOrder()->value('id')
        ];
    }
}
