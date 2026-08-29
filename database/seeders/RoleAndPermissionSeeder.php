<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = ['manage-users', 'manage-documents', 'manage-categories', 'manage-news'];
        foreach ($permissions as $p) {
            Permission::findOrCreate($p, 'web');
        }

        // Create roles and assign permissions
        $roleAdmin = Role::findOrCreate('Admin', 'web');
        $roleAdmin->syncPermissions(Permission::all());

        $roleOperator = Role::findOrCreate('Operator', 'web');
        $roleOperator->syncPermissions(['manage-documents', 'manage-categories', 'manage-news']);

        $roleUser = Role::findOrCreate('User', 'web');
    }
}
