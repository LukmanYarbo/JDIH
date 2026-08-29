<!-- Admin Sidebar Panel -->
<aside id="adminSidebar">
    <div class="sidebar-header">
        <a href="{{ route('portal.home') }}" class="sidebar-brand">
            @if(isset($gProfil) && $gProfil->logo)
                <img src="{{ asset($gProfil->logo) }}" alt="Logo DPRD" class="me-2"
                    style="height: 32px; width: auto; object-fit: contain;">
            @else
                <i class="bi bi-bank2 text-warning fs-3 me-2"></i>
            @endif
            <div>
                <span class="fs-6 d-block lh-1 text-white">JDIH DPRD</span>
                <small class="fs-9 text-white-50 font-monospace">KABUPATEN BOLAANG MONGONDOW UTARA</small>
            </div>
        </a>
    </div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.dashboard') }}"
            class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        @if(auth()->user()->hasRole('Admin') || auth()->user()->hasRole('Operator'))
            <div class="text-uppercase text-white-50 fs-9 fw-bold px-3 pt-3 pb-2 font-monospace">Manajemen Hukum</div>
            <a href="{{ route('admin.categories.index') }}"
                class="sidebar-item {{ Route::is('admin.categories.*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Kategori Dokumen
            </a>
            <a href="{{ route('admin.documents.index') }}"
                class="sidebar-item {{ Route::is('admin.documents.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-pdf"></i> Dokumen Hukum
            </a>
            <a href="{{ route('admin.ranperda.index') }}"
                class="sidebar-item {{ Route::is('admin.ranperda.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-code"></i> Alur Ranperda (Propemperda)
            </a>
            <a href="{{ route('admin.agendas.index') }}"
                class="sidebar-item {{ Route::is('admin.agendas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-event"></i> Agenda Kegiatan DPRD
            </a>
            <a href="{{ route('admin.news.index') }}" class="sidebar-item {{ Route::is('admin.news.*') ? 'active' : '' }}">
                <i class="bi bi-newspaper"></i> Berita Kegiatan
            </a>
            <a href="{{ route('admin.gallery.index') }}"
                class="sidebar-item {{ Route::is('admin.gallery.*') ? 'active' : '' }}">
                <i class="bi bi-images"></i> Galeri &amp; Video
            </a>
            <a href="{{ route('admin.anggota.index') }}"
                class="sidebar-item {{ Route::is('admin.anggota.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Anggota DPRD
            </a>
            <a href="{{ route('admin.alat-kelengkapan.index') }}"
                class="sidebar-item {{ Route::is('admin.alat-kelengkapan.*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i> Alat Kelengkapan DPRD
            </a>
            <a href="{{ route('admin.tim-pengelola.index') }}"
                class="sidebar-item {{ Route::is('admin.tim-pengelola.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Tim Pengelola JDIH
            </a>
            <a href="{{ route('admin.profile.edit') }}"
                class="sidebar-item {{ Route::is('admin.profile.*') ? 'active' : '' }}">
                <i class="bi bi-bank"></i> Profil, SOP &amp; Dasar Hukum
            </a>
        @endif

        @if(auth()->user()->hasRole('Admin'))
            <div class="text-uppercase text-white-50 fs-9 fw-bold px-3 pt-3 pb-2 font-monospace">Manajemen Sistem</div>
            <a href="{{ route('admin.users.index') }}"
                class="sidebar-item {{ Route::is('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Manajemen User
            </a>
        @endif
    </div>
    <div class="sidebar-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center text-dark"
                    style="width: 32px; height: 32px; font-weight: bold;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <span class="fs-7 d-block text-white fw-semibold"
                        style="max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ auth()->user()->name }}</span>
                    <small class="fs-8 text-white-50">{{ auth()->user()->roles->pluck('name')->implode(', ') }}</small>
                </div>
            </div>
        </div>
    </div>
</aside>