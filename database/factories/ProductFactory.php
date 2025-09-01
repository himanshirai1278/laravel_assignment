<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = \App\Models\Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 999),
            'image' => 'images/default-product.png',
            'category' => $this->faker->randomElement(['Electronics','Books','Clothing']),
            'stock' => $this->faker->numberBetween(0, 100),
        ];
    }
}
