<!-- Top Navigation Header -->
<header class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        <!-- Unified Sidebar Toggle Button (Desktop Collapse & Mobile Drawer) -->
        <button class="btn btn-sm btn-light border shadow-sm d-flex align-items-center justify-content-center" 
                type="button" 
                id="sidebarToggle" 
                onclick="window.toggleAdminSidebar()"
                style="width: 40px; height: 40px; border-radius: 10px; cursor: pointer;"
                title="Buka / Tutup Sidebar"
                aria-label="Toggle Sidebar">
            <i class="bi bi-text-indent-left fs-5 text-primary" id="sidebarToggleIcon"></i>
        </button>

        <div>
            <h5 class="m-0 fw-bold text-primary lh-1">@yield('page_title', 'Admin Panel')</h5>
            <small class="text-muted fs-8 d-none d-md-inline-block">Portal JDIH Sekretariat DPRD</small>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        <!-- Quick Portal Home Link -->
        <a href="{{ route('portal.home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 d-none d-sm-inline-flex align-items-center shadow-xs" target="_blank">
            <i class="bi bi-globe me-1 text-primary"></i>
            <span>Lihat Portal</span>
        </a>

        <!-- Theme Toggle Button -->
        <button id="themeToggleBtn" class="btn btn-sm btn-light border rounded-circle d-flex align-items-center justify-content-center shadow-xs" 
                style="width: 36px; height: 36px;" 
                title="Ganti Tema Gelap / Terang">
            <i class="bi bi-moon-fill" id="themeToggleIcon"></i>
        </button>

        <!-- Divider -->
        <div class="vr mx-1 my-auto d-none d-sm-block" style="height: 20px; opacity: 0.2;"></div>

        <!-- Profile Dropdown -->
        <div class="dropdown">
            <button class="btn btn-sm btn-light border rounded-pill px-2 d-inline-flex align-items-center gap-2 shadow-xs dropdown-toggle"
                    type="button"
                    id="profileDropdown"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="true"
                    aria-expanded="false"
                    title="Profil Pengguna">
                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width: 32px; height: 32px; font-size: 0.8rem;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="d-none d-md-inline text-dark fw-semibold" style="font-size: 0.85rem;">
                    {{ Auth::user()->name ?? 'Admin' }}
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2" aria-labelledby="profileDropdown" style="min-width: 200px; border-radius: 12px;">
                <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-dark" style="font-size: 0.9rem;">{{ Auth::user()->name ?? 'Admin' }}</div>
                    <small class="text-muted" style="font-size: 0.75rem;">{{ Auth::user()->email ?? '' }}</small>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>
