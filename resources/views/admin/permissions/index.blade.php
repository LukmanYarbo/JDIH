@extends('layouts.admin')

@section('title', 'Daftar & Matriks Permission - JDIH DPRD Bolmut')
@section('page_title', 'Daftar & Matriks Permission')

@section('content')
<div class="container-fluid px-0">

    <!-- KPI Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Permission</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalPermissions }}</h3>
                        <small class="text-success fs-9 fw-medium"><i class="bi bi-key-fill"></i> Kunci Akses Terdaftar</small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-key fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Modul Sistem</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ count($permissionGroups) }}</h3>
                        <small class="text-primary fs-9 fw-medium"><i class="bi bi-grid-fill"></i> Modul Terproteksi</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-grid-3x3-gap-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm p-3 bg-white rounded-4 h-100">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-8 text-uppercase fw-semibold font-monospace">Total Role</span>
                        <h3 class="fw-bold text-dark m-0 mt-1">{{ $totalRoles }}</h3>
                        <small class="text-warning fs-9 fw-medium"><i class="bi bi-shield-check"></i> Peran Penugasan</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3 text-warning d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card: Matriks Hak Akses Antar Role -->
    <div class="card border-0 shadow-sm bg-white rounded-4 overflow-hidden mb-4">
        <div class="card-header bg-white border-bottom p-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div>
                <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                    <i class="bi bi-table text-primary"></i> Matriks Hak Akses Antar-Role
                </h5>
                <p class="text-muted fs-8 m-0 mt-1">Pemetaan perbandingan hak akses (Permission) untuk masing-masing peran.</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-outline-primary rounded-pill px-3 fs-8" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Permission Kustom
                </button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-primary rounded-pill px-3 fs-8">
                    <i class="bi bi-shield-lock me-1"></i> Kelola Role
                </a>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="p-3 bg-light border-bottom">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                <input type="text" id="matrixSearch" class="form-control bg-white border-start-0 fs-8" placeholder="Filter nama permission atau modul...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="matrixTable">
                <thead class="bg-light">
                    <tr class="text-muted fs-8 text-uppercase font-monospace">
                        <th class="ps-4" style="min-width: 260px;">Permission Name</th>
                        <th style="min-width: 180px;">Modul</th>
                        @foreach($roles as $role)
                            <th class="text-center" style="min-width: 120px;">
                                <span class="badge bg-white text-dark border px-2.5 py-1 rounded-pill fw-bold">
                                    {{ $role->name }}
                                </span>
                            </th>
                        @endforeach
                        <th class="text-end pe-4" style="width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissionGroups as $modKey => $group)
                        @php
                            $meta = $group['meta'];
                            $perms = $group['permissions'];
                        @endphp
                        <tr class="bg-light bg-opacity-75 module-header-row" data-module="{{ $modKey }}">
                            <td colspan="{{ count($roles) + 3 }}" class="ps-4 py-2">
                                <span class="fw-bold text-dark fs-8">
                                    <i class="{{ $meta['icon'] }} text-{{ $meta['color'] }} me-1.5"></i>
                                    {{ $meta['name'] }}
                                </span>
                                <small class="text-muted fs-9 ms-2">({{ count($perms) }} permission)</small>
                            </td>
                        </tr>
                        @foreach($perms as $p)
                            @php
                                $action = explode('.', $p->name)[1] ?? 'action';
                            @endphp
                            <tr class="perm-row" data-perm-name="{{ $p->name }}" data-module-name="{{ $meta['name'] }}">
                                <td class="ps-4 font-monospace fs-8 fw-semibold text-dark">
                                    <i class="bi bi-key me-1 text-muted"></i> {{ $p->name }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $meta['color'] }} bg-opacity-10 text-{{ $meta['color'] }} rounded-pill px-2.5 py-1 fs-9">
                                        {{ $meta['name'] }}
                                    </span>
                                </td>
                                @foreach($roles as $role)
                                    @php
                                        $hasPerm = strtolower($role->name) === 'admin' || $role->hasPermissionTo($p->name);
                                    @endphp
                                    <td class="text-center">
                                        @if($hasPerm)
                                            <span class="badge bg-success bg-opacity-10 text-success rounded-circle p-1.5" title="Diizinkan">
                                                <i class="bi bi-check-lg fs-7"></i>
                                            </span>
                                        @else
                                            <span class="text-muted opacity-25">
                                                <i class="bi bi-dash fs-6"></i>
                                            </span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="text-end pe-4">
                                    <form action="{{ route('admin.permissions.destroy', $p->id) }}" method="POST" class="m-0 delete-form" data-title="Hapus Permission '{{ $p->name }}'?" data-confirm="Menghapus permission ini akan mencabut akses tersebut dari semua role yang menggunakannya.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border rounded-circle p-1" style="width: 28px; height: 28px;" title="Hapus Permission">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Modal Tambah Permission Kustom -->
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-bottom p-4">
                <h5 class="modal-title fw-bold text-dark" id="addPermissionModalLabel">
                    <i class="bi bi-key-fill text-primary me-1"></i> Tambah Permission Kustom
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.permissions.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="permNameInput" class="form-label fs-7 fw-semibold text-dark">Nama Permission <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="permNameInput" class="form-control font-monospace fs-8" placeholder="format: modul.aksi (contoh: report.export)" required>
                        <small class="text-muted fs-9 mt-1 d-block">Gunakan format standar titik (.) seperti <code>documents.audit</code> atau <code>settings.backup</code>.</small>
                    </div>
                </div>
                <div class="modal-footer border-top p-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Permission</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('matrixSearch');
    const rows = document.querySelectorAll('.perm-row');
    const headerRows = document.querySelectorAll('.module-header-row');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();

        rows.forEach(row => {
            const permName = row.dataset.permName.toLowerCase();
            const modName = row.dataset.moduleName.toLowerCase();

            if (permName.includes(query) || modName.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Hide module headers if no children visible
        headerRows.forEach(header => {
            if (query === '') {
                header.style.display = '';
            } else {
                const modKey = header.dataset.module;
                const visibleSiblings = document.querySelectorAll('.perm-row[data-perm-name*="' + query + '"]');
                header.style.display = visibleSiblings.length > 0 ? '' : 'none';
            }
        });
    });
});
</script>
@endsection
