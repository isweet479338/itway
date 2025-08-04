<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $i) {
            Product::create([
                'category_id' => $faker->numberBetween(1, 10), // assumes 10 categories
                'name' => $faker->words(3, true),
                'qty' => $faker->numberBetween(1, 500),
                'unit' => $faker->randomElement(['pcs', 'kg', 'litre', 'box']),
                'buy_price' => $faker->randomFloat(2, 10, 100),
                'sell_price' => $faker->randomFloat(2, 20, 200),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
