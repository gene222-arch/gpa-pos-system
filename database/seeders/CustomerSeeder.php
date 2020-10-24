<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Customer');

        foreach (\range(1, 20) as $index) {

            DB::table('customers')->insert([
                'first_name' => $faker->name,
                'last_name' => $faker->name,
                'email' => $faker->email,
                'user_id' => $faker->randomDigit,
                'address' => $faker->address,
                'avatar' => 'no_image.png'
            ]);
        }
    }
}
