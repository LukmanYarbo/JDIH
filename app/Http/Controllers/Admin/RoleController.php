<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Map permission prefixes to human-readable modules & icons
     */
    public static function getPermissionModules()
    {
        return [
            'documents' => [
                'name' => 'Dokumen Hukum',
                'icon' => 'bi bi-file-earmark-pdf',
                'color' => 'primary',
                'description' => 'Akses kelola produk hukum, naskah, abstrak, dan publikasi.',
            ],
            'categories' => [
                'name' => 'Kategori & Jenis',
                'icon' => 'bi bi-tags',
                'color' => 'info',
                'description' => 'Pengaturan jenis dokumen dan hirarki perundang-undangan.',
            ],
            'ranperda' => [
                'name' => 'Alur Ranperda',
                'icon' => 'bi bi-file-earmark-code',
                'color' => 'warning',
                'description' => 'Kelola tahapan & progres Propemperda / Ranperda.',
            ],
            'agendas' => [
                'name' => 'Agenda Kegiatan',
                'icon' => 'bi bi-calendar-event',
                'color' => 'success',
                'description' => 'Jadwal paripurna, rapat komisi, dan ticker berjalan.',
            ],
            'news' => [
                'name' => 'Berita Hukum',
                'icon' => 'bi bi-newspaper',
                'color' => 'primary',
                'description' => 'Publikasi artikel, liputan, dan siaran pers hukum.',
            ],
            'gallery' => [
                'name' => 'Galeri Foto & Video',
                'icon' => 'bi bi-images',
                'color' => 'secondary',
                'description' => 'Dokumentasi visual kegiatan legislatif & sosialisasi.',
            ],
            'anggota' => [
                'name' => 'Anggota DPRD',
                'icon' => 'bi bi-people-fill',
                'color' => 'dark',
                'description' => 'Data profil legislator, fraksi, dan dapil.',
            ],
            'alat-kelengkapan' => [
                'name' => 'Alat Kelengkapan (AKD)',
                'icon' => 'bi bi-diagram-3',
                'color' => 'info',
                'description' => 'Struktur pimpinan, komisi, bamus, banggar, dan bapperda.',
            ],
            'tim-pengelola' => [
                'name' => 'Tim Pengelola JDIH',
                'icon' => 'bi bi-person-badge',
                'color' => 'danger',
                'description' => 'Struktur SK tim pembina, pengarah, dan pelaksana JDIH.',
            ],
            'profile' => [
                'name' => 'Profil & Identitas',
                'icon' => 'bi bi-bank',
                'color' => 'warning',
                'description' => 'Pengaturan visi misi, logo, kontak kantor, dan header.',
            ],
            'users' => [
                'name' => 'Manajemen User',
                'icon' => 'bi bi-people',
                'color' => 'danger',
                'description' => 'Kelola akun pengguna, reset password, dan status aktif.',
            ],
            'roles' => [
                'name' => 'Manajemen Role',
                'icon' => 'bi bi-shield-lock',
                'color' => 'danger',
                'description' => 'Pengaturan peran dan pembagian hak akses sistem.',
            ],
            'permissions' => [
                'name' => 'Manajemen Permission',
                'icon' => 'bi bi-key',
                'color' => 'secondary',
                'description' => 'Kelola kunci hak akses granular aplikasi.',
            ],
        ];
    }

    /**
     * Group all permissions by module
     */
    public static function groupPermissions($permissions = null)
    {
        $permissions = $permissions ?: Permission::all();
        $modules = self::getPermissionModules();
        $grouped = [];

        foreach ($modules as $prefix => $meta) {
            $grouped[$prefix] = [
                'meta' => $meta,
                'permissions' => [],
            ];
        }

        $otherGroup = [
            'meta' => [
                'name' => 'Lainnya / Umum',
                'icon' => 'bi bi-grid',
                'color' => 'secondary',
                'description' => 'Hak akses umum lainnya dalam sistem.',
            ],
            'permissions' => [],
        ];

        foreach ($permissions as $perm) {
            $prefix = explode('.', $perm->name)[0];
            if (isset($grouped[$prefix])) {
                $grouped[$prefix]['permissions'][] = $perm;
            } else {
                $otherGroup['permissions'][] = $perm;
            }
        }

        if (!empty($otherGroup['permissions'])) {
            $grouped['other'] = $otherGroup;
        }

        // Filter out empty groups
        return array_filter($grouped, fn($group) => !empty($group['permissions']));
    }

    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->get();
        $totalRoles = $roles->count();
        $totalPermissions = Permission::count();
        $totalUsers = User::count();

        return view('admin.roles.index', compact('roles', 'totalRoles', 'totalPermissions', 'totalUsers'));
    }

    public function create()
    {
        $permissionGroups = self::groupPermissions();
        return view('admin.roles.create', compact('permissionGroups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ], [
            'name.required' => 'Nama Role wajib diisi.',
            'name.unique' => 'Nama Role tersebut sudah ada di sistem.',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        if ($request->filled('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', "Role \"{$role->name}\" berhasil dibuat dengan " . count($request->permissions ?? []) . " hak akses.");
    }

    public function edit(Role $role)
    {
        $permissionGroups = self::groupPermissions();
        $rolePermissions = $role->permissions->pluck('name')->toArray();

        return view('admin.roles.edit', compact('role', 'permissionGroups', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $isProtected = in_array(strtolower($role->name), ['admin']);

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ], [
            'name.required' => 'Nama Role wajib diisi.',
            'name.unique' => 'Nama Role tersebut sudah digunakan oleh role lain.',
        ]);

        if (!$isProtected) {
            $role->name = $request->name;
            $role->save();
        }

        if ($isProtected) {
            // Admin role always has all permissions
            $role->syncPermissions(Permission::all());
        } else {
            $role->syncPermissions($request->permissions ?? []);
        }

        return redirect()->route('admin.roles.index')->with('success', "Perubahan Role \"{$role->name}\" berhasil disimpan.");
    }

    public function destroy(Role $role)
    {
        if (in_array(strtolower($role->name), ['admin'])) {
            return back()->with('error', 'Role "Admin" merupakan role sistem inti dan tidak boleh dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', "Role \"{$role->name}\" tidak dapat dihapus karena masih digunakan oleh {$role->users()->count()} pengguna.");
        }

        $roleName = $role->name;
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', "Role \"{$roleName}\" berhasil dihapus dari sistem.");
    }
}
