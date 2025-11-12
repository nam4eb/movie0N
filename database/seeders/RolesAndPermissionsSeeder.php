<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()["cache"]->forget('spatie.permission.cache');

        // create permissions
        Permission::create(['name' => 'manage movies']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'view admin dashboard']);

        // create roles and assign existing permissions
        $role = Role::create(['name' => 'user']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}

