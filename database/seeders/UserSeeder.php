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
        $groups = collect(User::GROUPS)->map(function ($group) {
            return collect($group)->keys();
        })->flatten();

        User::create([
            "name" => "Admin Test",
            "email" => "admin@gmail.com",
            "password" => 123456,
            "role" => User::ROLE_ADMIN,
            "username" => "admin",
        ]);

        User::create([
            "name" => "Karyawan Test",
            "email" => "karyawan@gmail.com",
            "password" => 123456,
            "role" => User::ROLE_EMPLOYEE,
            "group" => $groups->random(),
            "username" => "employee",
        ]);

        User::create([
            "name" => "Kepala Dinas",
            "email" => "kepala.dinas@gmail.com",
            "password" => 123456,
            "role" => User::ROLE_HEAD_OF_DEPARTMENT,
            "username" => "kepala.dinas",
        ]);

        User::create([
            "name" => "Kepala Bidang",
            "email" => "kepala.bidang@gmail.com",
            "password" => 123456,
            "role" => User::ROLE_HEAD_OF_FIELD,
            "username" => "kepala.bidang",
        ]);

        foreach (range(1, 50) as $i) {
            $role = User::ROLE_EMPLOYEE;

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
                "group" => $role == User::ROLE_EMPLOYEE ? $groups->random() : null,
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
                "nip" => $faker->unique()->numerify('################'),
                "phone" => "08" . $faker->unique()->numerify('#########'),
                "address" => $faker->address,
                "created_at" => now()->toDateTimeString(),
                "updated_at" => now()->toDateTimeString(),
            ];
        }

        Biodata::insert($biodatas);
    }
}
