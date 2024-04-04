<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $superadminRole = Role::create(['name' => 'superadmin']);
        $adminRole = Role::create(['name' => 'admin']);

        // Define permissions for admin
        $superadminPermissions = [
            'create_feedback',
            'edit_feedback',
            'delete_feedback',
            'view_feedback',
        ];

        // Assign admin permissions
        foreach ($superadminPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $superadminRole->givePermissionTo($permission);
        }

        // Define permissions for customer
        $adminPermissions = [
            'create_feedback',
            'view_feedback',
        ];

        // Assign customer permissions
        foreach ($adminPermissions as $permission) {
            Permission::create(['name' => $permission]);
            $adminRole->givePermissionTo($permission);
        }


    }
}
