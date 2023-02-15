<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => ucfirst($this->faker->words(2, true)),
            'on_home_page' => $this->faker->boolean,
            'sorting' => $this->faker->numberBetween(1, 999),
        ];
    }
}
