<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PhoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Phone');

        foreach (\range(1, 20) as $index) {
            
            DB::table('phones')->insert([
                'phone' => $faker->phoneNumber,
                'customer_id' => $faker->randomDigit
            ]);
        }

    }
}
