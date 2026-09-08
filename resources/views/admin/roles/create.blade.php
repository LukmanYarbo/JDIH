@extends('layouts.admin')

@section('title', 'Tambah Role Baru - JDIH DPRD Bolmut')
@section('page_title', 'Tambah Role Baru')

@section('content')
<div class="container-fluid px-0">
    <form action="{{ route('admin.roles.store') }}" method="POST" id="roleForm">
        @csrf

        <div class="row g-4 mb-4">
            <!-- Left Info Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 sticky-top" style="top: 80px; z-index: 10;">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-shield-plus text-primary me-1"></i> Informasi Role</h5>
                    <p class="text-muted fs-8 mb-4">Tentukan nama peran dan pilih hak akses yang diizinkan.</p>

                    <div class="mb-4">
                        <label for="name" class="form-label fs-7 fw-semibold text-dark">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Contoh: Verifikator Dokumen" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted fs-9 mt-1 d-block">Gunakan nama yang deskriptif dan unik.</small>
                    </div>

                    <div class="p-3 bg-light rounded-3 mb-4 border">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fs-8 fw-semibold text-dark">Total Izin Dipilih</span>
                            <span class="badge bg-primary rounded-pill px-2.5 py-1 fs-8" id="selectedCountBadge">0 Dipilih</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="selectedProgressBar" role="progressbar" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Role Baru
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
                            <p class="text-muted fs-8 m-0 mt-1">Centang izin yang diberikan untuk peran ini berdasarkan modul sistem.</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 fs-8" id="btnSelectAll">
                                <i class="bi bi-check-all me-1"></i> Pilih Semua
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 fs-8" id="btnDeselectAll">
                                <i class="bi bi-x-lg me-1"></i> Batalkan Semua
                            </button>
                        </div>
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
                                        <button type="button" class="btn btn-xs btn-outline-{{ $meta['color'] }} rounded-pill px-2.5 py-1 fs-9 btn-toggle-module" data-module="{{ $key }}">
                                            Pilih Modul
                                        </button>
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
                                            @endphp
                                            <div class="col perm-item-wrapper" data-perm-name="{{ $perm->name }}">
                                                <label class="d-flex align-items-center justify-content-between p-2.5 border rounded-3 bg-light bg-opacity-50 hover-shadow cursor-pointer w-100 m-0 transition-all select-perm-card">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                                            class="form-check-input mt-0 perm-checkbox module-{{ $key }}"
                                                            {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}>
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
.select-perm-card:has(input:checked) {
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

    function updateCounter() {
        const checkedCount = document.querySelectorAll('.perm-checkbox:checked').length;
        countBadge.textContent = checkedCount + ' / ' + totalCount + ' Dipilih';
        const percent = totalCount > 0 ? (checkedCount / totalCount) * 100 : 0;
        progressBar.style.width = percent + '%';
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', updateCounter);
    });

    updateCounter();

    // Select All
    document.getElementById('btnSelectAll').addEventListener('click', function() {
        checkboxes.forEach(cb => {
            // Only check visible ones if filtered
            const wrapper = cb.closest('.perm-item-wrapper');
            if (!wrapper || wrapper.style.display !== 'none') {
                cb.checked = true;
            }
        });
        updateCounter();
    });

    // Deselect All
    document.getElementById('btnDeselectAll').addEventListener('click', function() {
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
