<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\BrandFactory;
use Database\Factories\CategoryFactory;
use Database\Factories\OptionFactory;
use Database\Factories\OptionValueFactory;
use Database\Factories\ProductFactory;
use Database\Factories\PropertyFactory;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        BrandFactory::new()->count(20)->create();

        $properties = PropertyFactory::new()->count(10)->create();

        OptionFactory::new()->count(2)->create();

        $optionValue = OptionValueFactory::new()->count(10)->create();

        CategoryFactory::new()->count(10)
            ->has(
                Product::factory(10)
                    ->hasAttached($optionValue)
                    ->hasAttached($properties, function () {
                        return ['value' => ucfirst(fake()->word())];
                    })
            )
            ->create();
    }
}
