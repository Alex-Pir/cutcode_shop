<?php

namespace Database\Factories;

use Domain\Catalog\Models\Option;
use Domain\Catalog\Models\OptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OptionValue>
 */
class OptionValueFactory extends Factory
{
    protected $model = OptionValue::class;

    public function definition(): array
    {
        return [
            'title' => ucfirst($this->faker->word()),
            'option_id' => Option::query()->inRandomOrder()->value('id')
        ];
    }
}
