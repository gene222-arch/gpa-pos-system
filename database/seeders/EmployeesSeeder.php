<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Employee');

        foreach (\range(1, 50) as $index) {

            DB::table('employees')->insert([
                'first_name' => $faker->firstname,
                'last_name' => $faker->lastname,
                'avatar' => 'no_image.png',
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'salary' => $faker->randomDigit,
                'commission' => $faker->randomDigit
            ]);
        }
    }
}
