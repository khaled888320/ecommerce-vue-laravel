<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 20, 1000);
        $tax = $subtotal * 0.19;
        $shipping = fake()->randomFloat(2, 5, 30);

        return [
            'user_id'        => User::factory(),
            'order_number'   => Order::generateOrderNumber(),
            'status'         => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'subtotal'       => $subtotal,
            'tax'            => $tax,
            'shipping'       => $shipping,
            'total'          => $subtotal + $tax + $shipping,
            'payment_status' => fake()->randomElement(['unpaid', 'paid']),
            'payment_method' => fake()->randomElement(['card', 'cash', 'stripe']),
        ];
    }
}