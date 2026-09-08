@extends('layouts.admin')

@section('title', 'Manajemen Role & Hak Akses - JDIH DPRD Bolmut')
@section('page_title', 'Manajemen Role & Hak Akses')

@section('content')
<div class="container-fluid px-0">

    <!-- KPI Statistic Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 bg-white h-100 rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Role</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalRoles }}</h3>
                        <small class="text-primary fs-9 fw-medium"><i class="bi bi-shield-check"></i> Peran Terdaftar</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-shield-lock fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 bg-white h-100 rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Permission</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalPermissions }}</h3>
                        <small class="text-success fs-9 fw-medium"><i class="bi bi-key"></i> Kunci Hak Akses</small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-key-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 bg-white h-100 rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Pengguna</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalUsers }}</h3>
                        <small class="text-info fs-9 fw-medium"><i class="bi bi-people"></i> Akun Pengguna</small>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3 text-info d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm p-3 bg-white h-100 rounded-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Guard System</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">Web</h3>
                        <small class="text-warning fs-9 fw-medium"><i class="bi bi-lock-fill"></i> Spatie RBAC V6</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-cpu fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Role List Table Card -->
    <div class="card border-0 shadow-sm bg-white rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                    <i class="bi bi-shield-shaded text-primary"></i> Daftar Role &amp; Pembagian Akses
                </h5>
                <p class="text-muted fs-8 m-0 mt-1">Kelola peran pengguna dan atur permission granular per modul.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary rounded-pill px-3 fs-8">
                    <i class="bi bi-matrix me-1"></i> Matriks Permission
                </a>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-pill px-4 fs-8">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Role Baru
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted fs-8 text-uppercase font-monospace">
                        <th class="ps-4" style="width: 250px;">Nama Role</th>
                        <th>Hak Akses (Permissions)</th>
                        <th style="width: 140px;">Pengguna</th>
                        <th class="text-end pe-4" style="width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        @php
                            $isAdmin = strtolower($role->name) === 'admin';
                            $badgeColor = match(strtolower($role->name)) {
                                'admin' => 'danger',
                                'operator' => 'primary',
                                'editor' => 'warning',
                                'user' => 'info',
                                default => 'secondary'
                            };
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-3 bg-{{ $badgeColor }} bg-opacity-10 p-2.5 text-{{ $badgeColor }} d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                                        <i class="bi bi-shield-lock-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-dark fs-6">{{ $role->name }}</span>
                                            @if($isAdmin)
                                                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill fs-9 px-2 py-0.5">Sistem</span>
                                            @endif
                                        </div>
                                        <small class="text-muted font-monospace fs-9">guard: {{ $role->guard_name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($isAdmin)
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 fw-semibold fs-8">
                                        <i class="bi bi-stars me-1"></i> Akses Penuh (Super Admin - {{ $totalPermissions }} Permissions)
                                    </span>
                                @else
                                    <div class="d-flex align-items-center flex-wrap gap-1.5">
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1 fw-bold fs-8">
                                            {{ $role->permissions_count }} Permissions
                                        </span>
                                        @foreach($role->permissions->take(4) as $p)
                                            <span class="badge bg-light text-secondary border rounded-pill px-2 py-1 fs-9 font-monospace">
                                                {{ $p->name }}
                                            </span>
                                        @endforeach
                                        @if($role->permissions_count > 4)
                                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 fs-9 font-monospace">
                                                +{{ $role->permissions_count - 4 }} lainnya
                                            </span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1.5 fs-8 fw-semibold">
                                    <i class="bi bi-people me-1 text-muted"></i> {{ $role->users_count }} User
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex align-items-center justify-content-end gap-1.5">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fs-8 d-inline-flex align-items-center gap-1.5" 
                                       title="Atur Permission">
                                        <i class="bi bi-sliders"></i>
                                        <span>Kelola</span>
                                    </a>
                                    @if(!$isAdmin)
                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="m-0 d-inline delete-form" 
                                              data-title="Hapus Role {{ $role->name }}?" 
                                              data-confirm="Role ini akan dihapus dari sistem. Pastikan tidak ada pengguna yang sedang menggunakan role ini.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-8 d-inline-flex align-items-center gap-1" 
                                                    title="Hapus Role">
                                                <i class="bi bi-trash"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1.5 fs-9" title="Role Sistem Terproteksi">
                                            <i class="bi bi-shield-lock-fill text-muted"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <i class="bi bi-shield-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Belum ada role yang dikonfigurasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
