<?php

namespace Database\Factories;

use App\Models\Concerns\ProductType;
use App\Models\Concerns\ProductStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "price" => rand(10, 100),
            "status" => $this->faker->randomElement(ProductStatus::list()),
            "type" => $this->faker->randomElement(ProductType::list()),
        ];
    }
}
