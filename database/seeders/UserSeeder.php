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

        $user->roles()->attach(Role::User->value);
        
        $administrator = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $administrator->roles()->attach(Role::Administrator->value);

        $manager = User::create([
            'name' => 'Prakash Dura',
            'email' => 'duraprakash141@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $manager->roles()->attach(Role::Manager->value);

    }
}
