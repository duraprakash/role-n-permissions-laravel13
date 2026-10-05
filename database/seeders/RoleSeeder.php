<?php

namespace Database\Seeders;

use App\Enums\Permission as PermissionEnum;
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
        foreach (RoleEnum::cases() as $role)
        {
            $role = Role::create(['name' => $role->value]);
            $this->syncPermissionsToRole($role);
        }
    }

    private function syncPermissionsToRole(Role $role): void
    {
        $permissions = [];

        switch ($role->name)
        {
            case RoleEnum::Administrator->value:
                $permissions = [
                    PermissionEnum::LIST_TASK,
                    PermissionEnum::CREATE_TASK,
                    PermissionEnum::RETRIEVE_TASK,
                    PermissionEnum::EDIT_TASK,
                    PermissionEnum::DELETE_TASK,
                ];
                break;

            case RoleEnum::Manager->value:
                $permissions = [
                    PermissionEnum::LIST_TASK,
                    PermissionEnum::RETRIEVE_TASK,
                    PermissionEnum::EDIT_TASK,
                ];
                break;

            case RoleEnum::User->value:
                $permissions = [
                    PermissionEnum::LIST_TASK,
                    PermissionEnum::RETRIEVE_TASK,
                ];
                break;
        }

        $role->syncPermissions($permissions);
    }
}
