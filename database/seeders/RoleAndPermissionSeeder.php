<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        \Spatie\Permission\Models\Permission::create(['name' => 'manage-users']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage-documents']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage-categories']);
        \Spatie\Permission\Models\Permission::create(['name' => 'manage-news']);

        // Create roles and assign created permissions
        $roleAdmin = \Spatie\Permission\Models\Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo(\Spatie\Permission\Models\Permission::all());

        $roleOperator = \Spatie\Permission\Models\Role::create(['name' => 'Operator']);
        $roleOperator->givePermissionTo(['manage-documents', 'manage-categories', 'manage-news']);

        $roleUser = \Spatie\Permission\Models\Role::create(['name' => 'User']);
    }
}
