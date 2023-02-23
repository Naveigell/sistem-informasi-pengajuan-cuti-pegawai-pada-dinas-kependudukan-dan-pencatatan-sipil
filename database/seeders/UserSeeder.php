<?php

namespace Database\Seeders;

use App\Models\Biodata;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $faker = Factory::create('id_ID');
        $users = [];

        $hashedPassword = Hash::make(123456);

        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "password" => 123456,
            "role" => User::ROLE_ADMIN,
            "username" => "admin",
        ]);

        foreach (range(1, 50) as $i) {
            $role = User::ROLE_EMPLOYE;

            if ($i > 45) {
                $role = User::ROLE_HEAD_OF_FIELD;
            } elseif ($i > 40) {
                $role = User::ROLE_HEAD_OF_DEPARTMENT;
            } elseif ($i > 35) {
                $role = User::ROLE_ADMIN;
            }

            $users[] = [
                "name" => $faker->name,
                "email" => $faker->unique()->email,
                "password" => $hashedPassword,
                "role" => $role,
                "username" => $faker->unique()->userName,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ];
        }

        User::insert($users);

        $users = User::employee()->get();

        $biodatas = [];

        foreach ($users as $user) {
            $biodatas[] = [
                "user_id" => $user->id,
                "phone" => "08" . $faker->numerify('#########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ];
        }

        Biodata::insert($biodatas);
    }
}
