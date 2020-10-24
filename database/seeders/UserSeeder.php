<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\User');

        foreach (\range(1, 20) as $index) {

            DB::table('users')->insert([
                'firstname' => $faker->name,
                'lastname' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make($faker->sentence)
            ]);
        }
    }
}
