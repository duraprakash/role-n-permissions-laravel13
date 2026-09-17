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
                'name' => 'User Test',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ],
            [
                'name' => 'Admin Test',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ],
            [
                'name' => 'Prakash Dura',
                'email' => 'duraprakash141@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ],
        ];
        
        User::insert($users);
    }
}
