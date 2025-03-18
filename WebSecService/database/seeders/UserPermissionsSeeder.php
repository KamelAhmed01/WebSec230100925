<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create user management permissions
        $permissions = [
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Get or create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Assign all user management permissions to admin role
        $adminRole->givePermissionTo($permissions);

        // Create cashier role if it doesn't exist
        Role::firstOrCreate(['name' => 'cashier']);
    }
}
