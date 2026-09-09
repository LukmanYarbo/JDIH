<!-- Admin Sidebar Panel -->
<aside id="adminSidebar">
    <div class="sidebar-header d-flex align-items-center justify-content-between">
        <a href="{{ route('portal.home') }}" class="sidebar-brand text-decoration-none d-flex align-items-center">
            @if(isset($gProfil) && $gProfil->logo)
                <img src="{{ asset($gProfil->logo) }}" alt="Logo {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}" class="sidebar-logo me-2"
                    style="height: 34px; width: auto; object-fit: contain;">
            @else
                <div class="sidebar-logo-fallback me-2 rounded-3 bg-warning text-dark d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; min-width: 34px;">
                    <i class="bi bi-bank2 fs-5"></i>
                </div>
            @endif
            <div class="sidebar-brand-text">
                <span class="fs-6 fw-bold d-block lh-1 text-white">{{ $gProfil->nama_singkat_kantor ?? 'JDIH DPRD' }}</span>
                
            </div>
        </a>
        <!-- Close button for mobile -->
        <button type="button" class="btn btn-sm btn-link text-white-50 d-lg-none p-0" id="sidebarCloseMobile" onclick="window.closeAdminSidebar()" title="Tutup Menu">
            <i class="bi bi-x-lg fs-5"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}"
            title="Dashboard">
            <i class="bi bi-speedometer2"></i>
            <span class="sidebar-text">Dashboard</span>
        </a>

        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Operator'))
            <div class="sidebar-section-title text-uppercase text-white-50 fs-9 fw-bold px-3 pt-3 pb-2 font-monospace">Manajemen Hukum</div>
            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-item {{ Route::is('admin.categories.*') ? 'active' : '' }}"
                title="Kategori Dokumen">
                <i class="bi bi-tags"></i>
                <span class="sidebar-text">Kategori Dokumen</span>
            </a>
            <a href="{{ route('admin.documents.index') }}"
                class="sidebar-item {{ Route::is('admin.documents.*') ? 'active' : '' }}"
                title="Dokumen Hukum">
                <i class="bi bi-file-earmark-pdf"></i>
                <span class="sidebar-text">Dokumen Hukum</span>
            </a>
            <a href="{{ route('admin.ranperda.index') }}"
                class="sidebar-item {{ Route::is('admin.ranperda.*') ? 'active' : '' }}"
                title="Alur Ranperda (Propemperda)">
                <i class="bi bi-file-earmark-code"></i>
                <span class="sidebar-text">Alur Ranperda</span>
            </a>
            <a href="{{ route('admin.agendas.index') }}"
                class="sidebar-item {{ Route::is('admin.agendas.*') ? 'active' : '' }}"
                title="Agenda Kegiatan DPRD">
                <i class="bi bi-calendar-event"></i>
                <span class="sidebar-text">Agenda Kegiatan</span>
            </a>
            <a href="{{ route('admin.news.index') }}" 
                class="sidebar-item {{ Route::is('admin.news.*') ? 'active' : '' }}"
                title="Berita Kegiatan">
                <i class="bi bi-newspaper"></i>
                <span class="sidebar-text">Berita Kegiatan</span>
            </a>
            <a href="{{ route('admin.gallery.index') }}"
                class="sidebar-item {{ Route::is('admin.gallery.*') ? 'active' : '' }}"
                title="Galeri &amp; Video">
                <i class="bi bi-images"></i>
                <span class="sidebar-text">Galeri &amp; Media</span>
            </a>
            <a href="{{ route('admin.anggota.index') }}"
                class="sidebar-item {{ Route::is('admin.anggota.*') ? 'active' : '' }}"
                title="Anggota DPRD">
                <i class="bi bi-people-fill"></i>
                <span class="sidebar-text">Anggota DPRD</span>
            </a>
            <a href="{{ route('admin.alat-kelengkapan.index') }}"
                class="sidebar-item {{ Route::is('admin.alat-kelengkapan.*') ? 'active' : '' }}"
                title="Alat Kelengkapan DPRD">
                <i class="bi bi-diagram-3"></i>
                <span class="sidebar-text">Alat Kelengkapan</span>
            </a>
            <a href="{{ route('admin.tim-pengelola.index') }}"
                class="sidebar-item {{ Route::is('admin.tim-pengelola.*') ? 'active' : '' }}"
                title="Tim Pengelola JDIH">
                <i class="bi bi-person-badge"></i>
                <span class="sidebar-text">Tim Pengelola</span>
            </a>
            <a href="{{ route('admin.profile.edit') }}"
                class="sidebar-item {{ Route::is('admin.profile.*') ? 'active' : '' }}"
                title="Identitas &amp; Profil Lembaga">
                <i class="bi bi-bank"></i>
                <span class="sidebar-text">Identitas &amp; Profil</span>
            </a>
        @endif

        @if(auth()->user()->hasRole('Admin'))
            <div class="sidebar-section-title text-uppercase text-white-50 fs-9 fw-bold px-3 pt-3 pb-2 font-monospace">Manajemen Akses &amp; Sistem</div>
            <a href="{{ route('admin.users.index') }}"
                class="sidebar-item {{ Route::is('admin.users.*') ? 'active' : '' }}"
                title="Manajemen User">
                <i class="bi bi-people"></i>
                <span class="sidebar-text">Manajemen User</span>
            </a>
            <a href="{{ route('admin.roles.index') }}"
                class="sidebar-item {{ Route::is('admin.roles.*') ? 'active' : '' }}"
                title="Role &amp; Hak Akses">
                <i class="bi bi-shield-lock"></i>
                <span class="sidebar-text">Role &amp; Akses</span>
            </a>
            <a href="{{ route('admin.permissions.index') }}"
                class="sidebar-item {{ Route::is('admin.permissions.*') ? 'active' : '' }}"
                title="Daftar Permission">
                <i class="bi bi-key"></i>
                <span class="sidebar-text">Hak Permission</span>
            </a>
            <a href="{{ route('admin.activity-logs.index') }}"
                class="sidebar-item {{ Route::is('admin.activity-logs.*') ? 'active' : '' }}"
                title="Log Aktivitas">
                <i class="bi bi-clock-history"></i>
                <span class="sidebar-text">Log Aktivitas</span>
            </a>
        @endif
    </div>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center">
            <div class="sidebar-user-avatar bg-warning rounded-circle d-flex align-items-center justify-content-center text-dark flex-shrink-0"
                style="width: 36px; height: 36px; font-weight: 700; font-size: 0.95rem;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="sidebar-user-info ms-2 overflow-hidden">
                <span class="fs-7 d-block text-white fw-semibold text-truncate" style="max-width: 140px;">
                    {{ auth()->user()->name }}
                </span>
                <small class="fs-8 text-white-50 text-truncate d-block" style="max-width: 140px;">
                    {{ auth()->user()->roles->pluck('name')->implode(', ') ?: 'User' }}
                </small>
            </div>
        </div>
    </div>
</aside>