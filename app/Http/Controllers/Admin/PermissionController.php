<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        $roles = Role::all();
        $permissionGroups = RoleController::groupPermissions($permissions);
        $totalPermissions = $permissions->count();
        $totalRoles = $roles->count();

        return view('admin.permissions.index', compact('permissions', 'roles', 'permissionGroups', 'totalPermissions', 'totalRoles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:permissions,name',
        ], [
            'name.required' => 'Nama Permission wajib diisi.',
            'name.unique' => 'Permission tersebut sudah ada.',
        ]);

        $permission = Permission::create([
            'name' => strtolower(trim($request->name)),
            'guard_name' => 'web',
        ]);

        // Clear cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Assign to Admin role automatically
        $admin = Role::where('name', 'Admin')->first();
        if ($admin) {
            $admin->givePermissionTo($permission);
        }

        return redirect()->route('admin.permissions.index')->with('success', "Permission \"{$permission->name}\" berhasil ditambahkan.");
    }

    public function destroy(Permission $permission)
    {
        $name = $permission->name;
        $permission->delete();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('admin.permissions.index')->with('success', "Permission \"{$name}\" berhasil dihapus.");
    }
}
