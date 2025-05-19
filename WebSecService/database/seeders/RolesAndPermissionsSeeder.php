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

        // Create customer permissions
        $customerPermissions = [
            'make_purchases',
            'view_purchases',
            'manage_wishlist',
        ];

        // Create credit permissions
        $creditPermissions = [
            'manage_credits',
        ];

        // Create all permissions
        $allPermissions = array_merge($userPermissions, $productPermissions, $customerPermissions, $creditPermissions);
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Admin role - gets all permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($allPermissions);

        // Employee role - gets specific permissions
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);
        $employeeRole->syncPermissions([
            'add_products',
            'edit_products',
            'delete_products',
            'view_users',
            'manage_credits'
        ]);

        // Customer role
        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->syncPermissions([
            'make_purchases',
            'view_purchases'
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
                'username' => 'Employee User',
                'password' => Hash::make('P@ssw0rd123'),
                'email_verified_at' => now(),
            ]
        );
        $employee->assignRole('employee');

        // Create test customer user
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'username' => 'Customer User',
                'password' => Hash::make('P@ssw0rd123'),
                'email_verified_at' => now(),
            ]
        );
        $customer->assignRole('customer');

        // Create credit for customer
        if (!$customer->credit) {
            $customer->credit()->create(['amount' => 100.00]);
        }
    }
}
