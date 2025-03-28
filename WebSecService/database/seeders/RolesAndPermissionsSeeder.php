<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create user permissions
        $userPermissions = [
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
        ];

        // Create product permissions
        $productPermissions = [
            'add_products',
            'edit_products',
            'delete_products',
        ];

        // Create all permissions
        $allPermissions = array_merge($userPermissions, $productPermissions);
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin role - gets all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($allPermissions);

        // employee role - gets specific permissions
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->syncPermissions([
            'add_products',
            'view_users',
            // Add more permissions as needed for cashiers
        ]);

        // Create admin user if it doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'username' => 'Admin User',
                'password' => Hash::make('P@ssw0rd123'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole('admin');

        // Create employee user if it doesn't exist
        $employee = User::firstOrCreate(
            ['email' => 'employee@example.com'],
            [
                'username' => 'employee User',
                'password' => Hash::make('P@ssw0rd123'),
                'email_verified_at' => now(),
            ]
        );
        $employee->assignRole('employee');

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
