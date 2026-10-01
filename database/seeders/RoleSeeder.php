<?php

namespace Database\Seeders;

use App\Enums\Role as RoleEnum;
use App\Models\Role as RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::create(['name' => $role->name]);
        }
    }
}
