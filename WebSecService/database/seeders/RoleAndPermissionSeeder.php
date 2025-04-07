<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add Customer role (alongside existing Admin and Employee roles)
        Role::create(['name' => 'Customer', 'guard_name' => 'web']);

        // Customer permissions
        Permission::create(['name' => 'make_purchase', 'display_name' => 'Make Purchase', 'guard_name' => 'web']);
        Permission::create(['name' => 'view_purchases', 'display_name' => 'View Purchases', 'guard_name' => 'web']);

        // Employee
        Permission::create(['name' => 'manage_customers', 'display_name' => 'Manage Customers', 'guard_name' => 'web']);
        Permission::create(['name' => 'add_credit', 'display_name' => 'Add Credit', 'guard_name' => 'web']);

        // Assign permissions to roles
        $customerRole = Role::findByName('Customer', 'web');
        $customerRole->givePermissionTo(['make_purchase', 'view_purchases']);

        $employeeRole = Role::findByName('Employee', 'web');
        $employeeRole->givePermissionTo(['add_products', 'edit_products', 'delete_products', 'manage_customers', 'add_credit']);

        $adminRole = Role::findByName('Admin', 'web');
        $adminRole->givePermissionTo(Permission::all());
    }
}
