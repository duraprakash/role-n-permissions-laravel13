<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Prakash Dura',
                'email' => 'duraprakash141@gmail.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
            [
                'name' => 'User Test',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ],
            [
                'name' => 'Admin Test',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ],
        ];

        User::insert($users);
    }
}
