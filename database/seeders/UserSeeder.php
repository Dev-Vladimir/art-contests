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
            'name' => 'Пользователь',
            'email' => 'test@test.ru',
            'password' => Hash::make('123'),
            'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => 2,
        ]);
    }
}
