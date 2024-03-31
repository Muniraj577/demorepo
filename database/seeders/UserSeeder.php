<?php

namespace Database\Seeders;

use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() == 0) {
            User::create([
                "first_name" => "Admin",
                "last_name" => "New",
                "email" => "admin@gmail.com",
                "password" => bcrypt("password"),
                "phone" => "9810256348",
                "dob" => "2000-01-15",
                "gender" => GenderEnum::MALE->value,
                "address" => "New Road, Kathmandu",
                "role" => RoleEnum::SUPER_ADMIN->value,
            ]);
        } else {
            $this->command->info("User already exists");
            echo PHP_EOL;
        }
    }
}
