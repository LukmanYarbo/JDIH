<!-- Top Navigation Header -->
<header>
    <div class="d-flex align-items-center gap-3">
        <button class="btn btn-outline-primary d-lg-none" type="button" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
        <h5 class="m-0 fw-semibold text-primary">@yield('page_title', 'Admin Panel')</h5>
    </div>
    <div class="d-flex align-items-center gap-3">
        <!-- Theme Toggle Button -->
        <button id="themeToggleBtn" class="btn btn-sm btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" title="Ganti Tema">
            <i class="bi bi-moon-fill" id="themeToggleIcon"></i>
        </button>
        <a href="{{ route('portal.home') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3" target="_blank">
            <i class="bi bi-globe me-1"></i> Kunjungi Portal
        </a>
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</header>
