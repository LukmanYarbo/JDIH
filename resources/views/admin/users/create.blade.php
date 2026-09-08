@extends('layouts.admin')

@section('title', 'Tambah User Baru - JDIH DPRD Bolmut')
@section('page_title', 'Tambah User Baru')

@section('content')
<div class="container-fluid px-0">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row g-4 mb-4">
            <!-- Left Form: User Profile & Security -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 h-100">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-person-plus text-primary me-1"></i> Data Akun Pengguna</h5>
                    <p class="text-muted fs-8 mb-4">Informasi identitas dan kredensial login pengguna.</p>

                    <div class="mb-3">
                        <label for="name" class="form-label fs-7 fw-semibold text-dark">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                            placeholder="Contoh: Rahmat Mokodompis" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fs-7 fw-semibold text-dark">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                            placeholder="Contoh: rahmat@gmail.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted fs-9">Digunakan sebagai username saat login.</small>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="password" class="form-label fs-7 fw-semibold text-dark">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fs-7 fw-semibold text-dark">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" 
                                placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 pt-3 border-top mt-auto">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                            <i class="bi bi-check2 me-1"></i> Simpan User Baru
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2">
                            Batal
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Form: Role & Permissions Assignment -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm bg-white rounded-4 p-4 h-100">
                    <h5 class="fw-bold text-dark mb-1"><i class="bi bi-shield-lock text-primary me-1"></i> Penugasan Role &amp; Hak Akses</h5>
                    <p class="text-muted fs-8 mb-4">Pilih peran (role) untuk menentukan wewenang pengguna di sistem JDIH.</p>

                    <div class="mb-4">
                        <label class="form-label fs-7 fw-semibold text-dark mb-2">Pilih Role / Peran <span class="text-danger">*</span></label>
                        @error('roles')
                            <div class="text-danger fs-8 mb-2">{{ $message }}</div>
                        @enderror

                        <div class="d-flex flex-column gap-2">
                            @foreach($roles as $role)
                                @php
                                    $roleColor = match(strtolower($role->name)) {
                                        'admin' => 'danger',
                                        'operator' => 'primary',
                                        'editor' => 'warning',
                                        'user' => 'info',
                                        default => 'secondary'
                                    };
                                    $roleDesc = match(strtolower($role->name)) {
                                        'admin' => 'Akses penuh ke semua fitur dan manajemen sistem.',
                                        'operator' => 'Kelola dokumen hukum, berita, agenda, dan profil lembaga.',
                                        'editor' => 'Drafting berita, dokumen, dan agenda kegiatan.',
                                        'user' => 'Akses publik dan unduhan dokumen resmi.',
                                        default => 'Role kustom dengan permission tertentu.'
                                    };
                                    $isChecked = in_array($role->name, old('roles', ['Operator']));
                                @endphp
                                <label class="d-flex align-items-start gap-3 p-3 border rounded-3 bg-light bg-opacity-50 cursor-pointer role-select-card {{ $isChecked ? 'active-role' : '' }}">
                                    <input type="checkbox" name="roles[]" value="{{ $role->name }}" class="form-check-input mt-1 role-checkbox" {{ $isChecked ? 'checked' : '' }}>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center justify-content-between mb-1">
                                            <span class="fw-bold text-dark fs-7">{{ $role->name }}</span>
                                            <span class="badge bg-{{ $roleColor }} bg-opacity-10 text-{{ $roleColor }} rounded-pill fs-9 px-2 py-0.5">
                                                {{ $role->permissions->count() }} permissions
                                            </span>
                                        </div>
                                        <small class="text-muted fs-8 d-block">{{ $roleDesc }}</small>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Direct Permission Override (Collapsible) -->
                    <div class="accordion border-0" id="directPermAccordion">
                        <div class="accordion-item border rounded-3 overflow-hidden">
                            <h2 class="accordion-header" id="headingDirect">
                                <button class="accordion-button collapsed bg-light fs-8 fw-semibold py-2.5 px-3 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDirect" aria-expanded="false" aria-controls="collapseDirect">
                                    <i class="bi bi-key me-2 text-primary"></i> Izin Khusus Tambahan (Direct Permissions - Opsional)
                                </button>
                            </h2>
                            <div id="collapseDirect" class="accordion-collapse collapse" aria-labelledby="headingDirect" data-bs-parent="#directPermAccordion">
                                <div class="accordion-body p-3">
                                    <p class="text-muted fs-9 mb-3">Izin di bawah ini dapat diberikan langsung ke user di luar role default-nya.</p>
                                    <div class="row row-cols-1 row-cols-sm-2 g-2" style="max-height: 250px; overflow-y: auto;">
                                        @foreach($permissionGroups as $group)
                                            @foreach($group['permissions'] as $perm)
                                                <div class="col">
                                                    <label class="d-flex align-items-center gap-2 p-2 border rounded bg-white fs-9 cursor-pointer">
                                                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" class="form-check-input mt-0"
                                                            {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}>
                                                        <span class="font-monospace text-dark">{{ $perm->name }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>

<style>
.cursor-pointer { cursor: pointer; }
.role-select-card { transition: all 0.2s ease; }
.role-select-card:hover { background-color: rgba(13, 59, 102, 0.05) !important; border-color: var(--primary-color) !important; }
.role-select-card:has(input:checked), .role-select-card.active-role {
    background-color: rgba(13, 59, 102, 0.08) !important;
    border-color: #0d3b66 !important;
}
</style>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleCards = document.querySelectorAll('.role-select-card');
    roleCards.forEach(card => {
        const checkbox = card.querySelector('.role-checkbox');
        checkbox.addEventListener('change', function() {
            if (this.checked) {
                card.classList.add('active-role');
            } else {
                card.classList.remove('active-role');
            }
        });
    });
});
</script>
@endsection
