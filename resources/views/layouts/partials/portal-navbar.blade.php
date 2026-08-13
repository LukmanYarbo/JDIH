<!-- Main Navigation Bar -->
<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('portal.home') }}">
            @if(isset($gProfil) && $gProfil->logo)
                <img src="{{ asset($gProfil->logo) }}" alt="Logo DPRD" class="me-2" style="height: 38px; width: auto; object-fit: contain;">
            @else
                <i class="bi bi-bank2 text-primary fs-3 me-2"></i>
            @endif
            <div>
                <span class="fs-5 d-block lh-1">JDIH DPRD</span>
                <small class="fs-7 text-muted font-monospace">BOLAANG MONGONDOW UTARA</small>
            </div>
        </a>
        <button class="navbar-expand-lg navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-2 text-primary"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-2 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('portal.home') ? 'active' : '' }}" href="{{ route('portal.home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('portal.search') ? 'active' : '' }}" href="{{ route('portal.search') }}">Produk Hukum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('portal.news.*') ? 'active' : '' }}" href="{{ route('portal.news.list') }}">Berita Hukum</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('portal.profile') ? 'active' : '' }}" href="{{ route('portal.profile') }}">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('portal.gallery') ? 'active' : '' }}" href="{{ route('portal.gallery') }}">Galeri</a>
                </li>
                <li class="nav-item ms-lg-3">
                    @auth
                        <a class="btn btn-outline-primary rounded-pill px-4 fw-semibold" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    @else
                        <a class="btn btn-primary rounded-pill px-4 fw-semibold" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    @endauth
                </li>
            </ul>
        </div>
    </div>
</nav>
