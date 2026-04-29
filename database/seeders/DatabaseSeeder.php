<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Creează 10 categorii
        $categories = Category::factory()->count(10)->create();

        // Creează 50 produse — fiecare cu o categorie existentă
        Product::factory()->count(50)->create([
            'category_id' => fn() => $categories->random()->id
        ]);

        // Creează 10 useri
        $users = User::factory()->count(10)->create();

        // Fiecare user are 2 adrese și 3 comenzi
        $users->each(function($user) {
            Address::factory()->count(2)->create([
                'user_id' => $user->id
            ]);

            Order::factory()->count(3)->create([
                'user_id' => $user->id
            ]);
        });
    }
}