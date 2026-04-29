<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'name'        => fake()->name(),
            'phone'       => fake()->phoneNumber(),
            'street'      => fake()->streetAddress(),
            'city'        => fake()->city(),
            'country'     => fake()->country(),
            'postal_code' => fake()->postcode(),
            'is_default'  => false,
        ];
    }
}