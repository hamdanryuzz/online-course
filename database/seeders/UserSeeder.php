<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Ryuz Shia',
            'email' => 'ryuz@gmail.com',
            'role' => 'teacher',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'role' => 'student',
            'password' => Hash::make('password'),
        ]);

    }
}
