@extends('layouts.admin')

@section('title', 'Edit Role: ' . $role->name . ' - JDIH DPRD Bolmut')
@section('page_title', 'Edit Role: ' . $role->name)

@section('content')
@php
    $isAdmin = strtolower($role->name) === 'admin';
@endphp

<div class="container-fluid px-0">
    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST" id="roleEditForm">
        @csrf
        @method('PUT')

        <div class="row g-4 mb-4">
            <!-- Left Info Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 sticky-top" style="top: 80px; z-index: 10;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0"><i class="bi bi-shield-check text-primary me-1"></i> Pengaturan Role</h5>
                        @if($isAdmin)
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2.5 py-1 fs-9 fw-semibold">Role Inti</span>
                        @endif
                    </div>
                    <p class="text-muted fs-8 mb-4">Sesuaikan nama role dan centang permissions yang diberikan.</p>

                    <div class="mb-4">
                        <label for="name" class="form-label fs-7 fw-semibold text-dark">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Contoh: Operator Dokumen" value="{{ old('name', $role->name) }}" required {{ $isAdmin ? 'readonly' : '' }}>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if($isAdmin)
                            <small class="text-danger fs-9 mt-1 d-block"><i class="bi bi-lock-fill"></i> Nama role Admin dilindungi dan tidak dapat diubah.</small>
                        @endif
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-8 fw-semibold text-dark">Total Izin Aktif</span>
                            <span class="badge bg-primary rounded-pill px-2.5 py-1 fs-8" id="selectedCountBadge">
                                {{ $isAdmin ? 'Akses Penuh' : count($rolePermissions) . ' Dipilih' }}
                            </span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="selectedProgressBar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                            <i class="bi bi-save me-1"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary rounded-pill py-2.5">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Permission Matrix -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 pb-3 border-bottom mb-4">
                        <div>
                            <h5 class="fw-bold text-dark m-0 d-flex align-items-center gap-2">
                                <i class="bi bi-grid-3x3-gap-fill text-primary"></i> Matriks Hak Akses (Permissions)
                            </h5>
                            <p class="text-muted fs-8 m-0 mt-1">
                                @if($isAdmin)
                                    <span class="text-success fw-semibold"><i class="bi bi-shield-lock-fill"></i> Role Admin secara otomatis memiliki seluruh hak akses dalam sistem JDIH.</span>
                                @else
                                    Sesuaikan izin spesifik yang diizinkan untuk peran ini.
                                @endif
                            </p>
                        </div>
                        @if(!$isAdmin)
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fs-8" id="btnSelectAll">
                                    <i class="bi bi-check-all me-1"></i> Pilih Semua
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fs-8" id="btnDeselectAll">
                                    <i class="bi bi-x-lg me-1"></i> Batalkan Semua
                                </button>
                            </div>
                        @endif
                    </div>

                    <!-- Live Search Filter for Permissions -->
                    <div class="mb-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" id="searchPermissions" class="form-control bg-light border-start-0 fs-8" placeholder="Ketik untuk mencari permission (misal: documents, create, edit, news, delete)...">
                        </div>
                    </div>

                    <!-- Permission Module Cards -->
                    <div class="d-flex flex-column gap-3" id="permissionModulesContainer">
                        @foreach($permissionGroups as $key => $group)
                            @php
                                $meta = $group['meta'];
                                $perms = $group['permissions'];
                            @endphp
                            <div class="card border rounded-4 overflow-hidden module-block" data-module-key="{{ $key }}">
                                <div class="card-header bg-light p-3 d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-3 bg-{{ $meta['color'] }} bg-opacity-10 text-{{ $meta['color'] }} p-2 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                            <i class="{{ $meta['icon'] }} fs-5"></i>
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark m-0 fs-7">{{ $meta['name'] }}</h6>
                                            <small class="text-muted fs-9">{{ $meta['description'] }}</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-white text-muted border rounded-pill px-2 py-1 fs-9 font-monospace">
                                            {{ count($perms) }} Hak Akses
                                        </span>
                                        @if(!$isAdmin)
                                            <button type="button" class="btn btn-xs btn-outline-{{ $meta['color'] }} rounded-pill px-2.5 py-1 fs-9 btn-toggle-module" data-module="{{ $key }}">
                                                Pilih Modul
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row row-cols-1 row-cols-md-2 g-2">
                                        @foreach($perms as $perm)
                                            @php
                                                $action = explode('.', $perm->name)[1] ?? 'general';
                                                $actionColor = match($action) {
                                                    'view' => 'primary',
                                                    'create' => 'success',
                                                    'edit' => 'warning',
                                                    'delete' => 'danger',
                                                    'publish' => 'info',
                                                    'download' => 'secondary',
                                                    default => 'dark'
                                                };
                                                $isChecked = $isAdmin || in_array($perm->name, old('permissions', $rolePermissions));
                                            @endphp
                                            <div class="col perm-item-wrapper" data-perm-name="{{ $perm->name }}">
                                                <label class="d-flex align-items-center justify-content-between p-2.5 border rounded-3 bg-light bg-opacity-50 hover-shadow cursor-pointer w-100 m-0 transition-all select-perm-card {{ $isChecked ? 'active-perm' : '' }}">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                                            class="form-check-input mt-0 perm-checkbox module-{{ $key }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                            {{ $isAdmin ? 'disabled' : '' }}>
                                                        <span class="font-monospace fs-8 text-dark fw-medium">{{ $perm->name }}</span>
                                                    </div>
                                                    <span class="badge bg-{{ $actionColor }} bg-opacity-10 text-{{ $actionColor }} rounded-pill fs-9 px-2 py-0.5 text-uppercase">
                                                        {{ $action }}
                                                    </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<style>
.cursor-pointer { cursor: pointer; }
.hover-shadow:hover { background-color: rgba(13, 59, 102, 0.05) !important; border-color: var(--primary-color) !important; }
.select-perm-card:has(input:checked), .select-perm-card.active-perm {
    background-color: rgba(13, 59, 102, 0.08) !important;
    border-color: #0d3b66 !important;
}
.btn-xs { font-size: 0.75rem; padding: 2px 8px; }
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.perm-checkbox');
    const totalCount = checkboxes.length;
    const countBadge = document.getElementById('selectedCountBadge');
    const progressBar = document.getElementById('selectedProgressBar');
    const searchInput = document.getElementById('searchPermissions');
    const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

    function updateCounter() {
        if (isAdmin) {
            countBadge.textContent = 'Akses Penuh (Semua)';
            progressBar.style.width = '100%';
            return;
        }
        const checkedCount = document.querySelectorAll('.perm-checkbox:checked').length;
        countBadge.textContent = checkedCount + ' / ' + totalCount + ' Dipilih';
        const percent = totalCount > 0 ? (checkedCount / totalCount) * 100 : 0;
        progressBar.style.width = percent + '%';
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCounter);
    });

    updateCounter();

    if (!isAdmin) {
        // Select All
        document.getElementById('btnSelectAll')?.addEventListener('click', function() {
            checkboxes.forEach(cb => {
                const wrapper = cb.closest('.perm-item-wrapper');
                if (!wrapper || wrapper.style.display !== 'none') {
                    cb.checked = true;
                }
            });
            updateCounter();
        });

        // Deselect All
        document.getElementById('btnDeselectAll')?.addEventListener('click', function() {
            checkboxes.forEach(cb => {
                const wrapper = cb.closest('.perm-item-wrapper');
                if (!wrapper || wrapper.style.display !== 'none') {
                    cb.checked = false;
                }
            });
            updateCounter();
        });

        // Toggle per module
        document.querySelectorAll('.btn-toggle-module').forEach(btn => {
            btn.addEventListener('click', function() {
                const modKey = this.dataset.module;
                const modCheckboxes = document.querySelectorAll('.module-' + modKey);
                const allChecked = Array.from(modCheckboxes).every(c => c.checked);
                modCheckboxes.forEach(c => c.checked = !allChecked);
                updateCounter();
            });
        });
    }

    // Live search filter
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().trim();
        document.querySelectorAll('.module-block').forEach(moduleBlock => {
            let visibleInModule = 0;
            moduleBlock.querySelectorAll('.perm-item-wrapper').forEach(item => {
                const name = item.dataset.permName.toLowerCase();
                if (name.includes(query)) {
                    item.style.display = '';
                    visibleInModule++;
                } else {
                    item.style.display = 'none';
                }
            });

            if (visibleInModule === 0 && query !== '') {
                moduleBlock.style.display = 'none';
            } else {
                moduleBlock.style.display = '';
            }
        });
    });
});
</script>
@endsection
