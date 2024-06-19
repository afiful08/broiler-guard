<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'admin']);
        $role = Role::create(['name' => 'farmer']);

        Permission::create(['name' => 'dashboard']);
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'device']);
        Permission::create(['name' => 'heater']);
        Permission::create(['name' => 'lamp']);
    }
}
