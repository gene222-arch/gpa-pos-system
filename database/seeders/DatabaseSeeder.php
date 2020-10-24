<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Product');

        foreach (\range(1, 20) as $index) {

            DB::table('products')->insert([
                'product_name' => $faker->sentence,
                'description' => $faker->paragraph,
                'barcode' => $faker->sentence,
                'price' => $faker->randomDigit,
                'quantity' => $faker->randomDigit,
                'status' => $faker->boolean,
                'image' => $faker->sentence,
                'created_at' => $faker->dateTimeBetween('-6 month', '+1 month')
            ]);
        }
    }
}
