<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        $price = fake()->randomFloat(2, 10, 1000);
        return [
            'category_id' => Category::factory(),
            'name'        => ucfirst($name),
            'slug'        => Str::slug($name),
            'description' => fake()->paragraph(),
            'price'       => $price,
            'sale_price'  => fake()->boolean(30) ? $price * 0.8 : null,
            'stock'       => fake()->numberBetween(0, 100),
            'is_active'   => true,
            'is_featured' => fake()->boolean(20),
        ];
    }
}