@extends('layouts.admin')

@section('title', 'Manajemen User & Pengguna - JDIH DPRD Bolmut')
@section('page_title', 'Manajemen User & Pengguna')

@section('content')
<div class="container-fluid px-0">

    <!-- KPI Statistic Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Pengguna</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalUsers }}</h3>
                        <small class="text-primary fs-9 fw-medium"><i class="bi bi-people-fill"></i> Akun Terdaftar</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-person-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Administrator</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $adminCount }}</h3>
                        <small class="text-danger fs-9 fw-medium"><i class="bi bi-shield-lock-fill"></i> Akses Super Admin</small>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-shield-shaded fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Role Tersedia</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalRoles }}</h3>
                        <small class="text-success fs-9 fw-medium"><i class="bi bi-diagram-3-fill"></i> Variasi Hak Akses</small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-sliders fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card border-0 shadow-sm bg-white rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                    <i class="bi bi-people text-primary"></i> Daftar Akun Pengguna
                </h5>
                <p class="text-muted fs-8 m-0 mt-1">Kelola akun, penugasan role, dan izin khusus pengguna sistem JDIH.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-pill px-3 fs-8">
                    <i class="bi bi-shield-lock me-1"></i> Kelola Role
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-4 fs-8">
                    <i class="bi bi-person-plus me-1"></i> Tambah User Baru
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted fs-8 text-uppercase font-monospace">
                        <th class="ps-4" style="min-width: 240px;">Pengguna</th>
                        <th style="min-width: 200px;">Email</th>
                        <th style="min-width: 200px;">Role &amp; Hak Akses</th>
                        <th style="min-width: 140px;">Terdaftar</th>
                        <th class="text-end pe-4" style="width: 170px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        @php
                            $isCurrentUser = $user->id === auth()->id();
                            $isAdmin = $user->hasRole('Admin');
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: 0.95rem;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold text-dark fs-6">{{ $user->name }}</span>
                                            @if($isCurrentUser)
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill fs-9 px-2 py-0.5">Anda</span>
                                            @endif
                                        </div>
                                        <small class="text-muted fs-9">ID: #{{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fs-8 text-dark fw-medium">{{ $user->email }}</span>
                            </td>
                            <td>
                                <div class="d-flex flex-wrap gap-1.5">
                                    @forelse($user->roles as $role)
                                        @php
                                            $roleColor = match(strtolower($role->name)) {
                                                'admin' => 'danger',
                                                'operator' => 'primary',
                                                'editor' => 'warning',
                                                'user' => 'info',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} rounded-pill px-2.5 py-1 fw-bold fs-8">
                                            <i class="bi bi-shield-check me-1"></i> {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 fs-9">Tanpa Role</span>
                                    @endforelse

                                    @if($user->permissions->count() > 0)
                                        <span class="badge bg-light text-muted border rounded-pill px-2 py-1 fs-9 font-monospace" title="Direct Permissions Khusus">
                                            +{{ $user->permissions->count() }} direct perm
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="text-muted fs-8">{{ $user->created_at ? $user->created_at->translatedFormat('d M Y') : '-' }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex align-items-center justify-content-end gap-1.5">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fs-8 d-inline-flex align-items-center gap-1.5" 
                                       title="Edit Akun & Akses">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </a>
                                    @if(!$isCurrentUser)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="m-0 d-inline delete-form" 
                                              data-title="Hapus Pengguna {{ $user->name }}?" 
                                              data-confirm="Akun '{{ $user->name }}' ({{ $user->email }}) akan dihapus permanen dari sistem JDIH.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger rounded-pill px-2.5 py-1 fs-8 d-inline-flex align-items-center gap-1" 
                                                    title="Hapus Pengguna">
                                                <i class="bi bi-trash"></i>
                                                <span class="d-none d-sm-inline">Hapus</span>
                                            </button>
                                        </form>
                                    @else
                                        <span class="badge bg-light text-muted border rounded-pill px-2.5 py-1.5 fs-9" title="Akun Anda Sendiri">
                                            <i class="bi bi-lock-fill text-muted"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people-slash fs-1 d-block mb-2 text-muted opacity-50"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
