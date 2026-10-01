<?php

namespace Database\Seeders;

use App\Enums\Role;
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
        $user = User::create([
            'name' => 'User Test',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole(Role::User);
        
        $administrator = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $administrator->assignRole(Role::Administrator);

        $manager = User::create([
            'name' => 'Prakash Dura',
            'email' => 'duraprakash141@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $manager->assignRole(Role::Manager);

    }
}
