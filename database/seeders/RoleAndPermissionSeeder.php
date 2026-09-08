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

        // Granular permissions grouped by module
        $modules = [
            'Dokumen Hukum' => [
                'documents.view',
                'documents.create',
                'documents.edit',
                'documents.delete',
                'documents.publish',
                'documents.download',
            ],
            'Kategori & Jenis Dokumen' => [
                'categories.view',
                'categories.create',
                'categories.edit',
                'categories.delete',
            ],
            'Ranperda (Propemperda)' => [
                'ranperda.view',
                'ranperda.create',
                'ranperda.edit',
                'ranperda.delete',
            ],
            'Agenda Kegiatan' => [
                'agendas.view',
                'agendas.create',
                'agendas.edit',
                'agendas.delete',
                'agendas.toggle-ticker',
            ],
            'Berita Hukum' => [
                'news.view',
                'news.create',
                'news.edit',
                'news.delete',
            ],
            'Galeri & Video' => [
                'gallery.view',
                'gallery.create',
                'gallery.edit',
                'gallery.delete',
            ],
            'Anggota DPRD' => [
                'anggota.view',
                'anggota.create',
                'anggota.edit',
                'anggota.delete',
            ],
            'Alat Kelengkapan DPRD' => [
                'alat-kelengkapan.view',
                'alat-kelengkapan.create',
                'alat-kelengkapan.edit',
                'alat-kelengkapan.delete',
            ],
            'Tim Pengelola' => [
                'tim-pengelola.view',
                'tim-pengelola.create',
                'tim-pengelola.edit',
                'tim-pengelola.delete',
            ],
            'Profil & Identitas' => [
                'profile.view',
                'profile.edit',
            ],
            'User & Hak Akses' => [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'roles.view',
                'roles.create',
                'roles.edit',
                'roles.delete',
                'permissions.view',
                'permissions.manage',
            ],
        ];

        $allPermissions = [];
        foreach ($modules as $moduleName => $perms) {
            foreach ($perms as $perm) {
                Permission::findOrCreate($perm, 'web');
                $allPermissions[] = $perm;
            }
        }

        // 1. Role: Admin (Super Admin - All Permissions)
        $roleAdmin = Role::findOrCreate('Admin', 'web');
        $roleAdmin->syncPermissions(Permission::all());

        // 2. Role: Operator (Content & Operational Manager)
        $operatorPerms = [
            'documents.view', 'documents.create', 'documents.edit', 'documents.publish', 'documents.download',
            'categories.view', 'categories.create', 'categories.edit',
            'ranperda.view', 'ranperda.create', 'ranperda.edit',
            'agendas.view', 'agendas.create', 'agendas.edit', 'agendas.toggle-ticker',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit',
            'anggota.view', 'anggota.create', 'anggota.edit',
            'alat-kelengkapan.view', 'alat-kelengkapan.create', 'alat-kelengkapan.edit',
            'tim-pengelola.view', 'tim-pengelola.create', 'tim-pengelola.edit',
            'profile.view', 'profile.edit',
        ];
        $roleOperator = Role::findOrCreate('Operator', 'web');
        $roleOperator->syncPermissions($operatorPerms);

        // 3. Role: Editor (Drafting & Review)
        $editorPerms = [
            'documents.view', 'documents.create', 'documents.edit',
            'news.view', 'news.create', 'news.edit',
            'gallery.view', 'gallery.create', 'gallery.edit',
            'agendas.view', 'agendas.create', 'agendas.edit',
        ];
        $roleEditor = Role::findOrCreate('Editor', 'web');
        $roleEditor->syncPermissions($editorPerms);

        // 4. Role: User (Public / Basic Access)
        $roleUser = Role::findOrCreate('User', 'web');
        $roleUser->syncPermissions(['documents.view', 'documents.download']);
    }
}
