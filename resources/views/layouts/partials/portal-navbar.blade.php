<!-- Top Banner Header -->
@if(isset($gProfil) && $gProfil->banner_header && file_exists(public_path($gProfil->banner_header)))
    <div class="top-banner-wrapper text-center position-relative overflow-hidden" style="background-color: #0a192f; border-bottom: 2px solid #f59e0b;">
        <div class="container d-flex justify-content-center align-items-center py-0">
            <a href="{{ route('portal.home') }}" class="d-inline-block text-decoration-none text-center w-100">
                <img src="{{ asset($gProfil->banner_header) }}" alt="Banner JDIH {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}" class="img-fluid mx-auto d-block" style="max-height: 280px; width: 100%; object-fit: contain; object-position: center;">
            </a>
        </div>
    </div>
@else
    <!-- Default Sleek Banner Header -->
    <div class="top-banner-wrapper py-3 text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 60%, #1e293b 100%); border-bottom: 3px solid #f59e0b;">
        <!-- Subtle Pattern Overlay -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
        
        <div class="container position-relative py-1">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <!-- Left: Branding & Logos -->
                <div class="d-flex align-items-center gap-3">
                    @if(isset($gProfil) && $gProfil->logo)
                        <img src="{{ asset($gProfil->logo) }}" alt="Logo {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}" style="height: 60px; width: auto; object-fit: contain;">
                    @else
                        <div class="bg-white bg-opacity-10 p-2 rounded-3 border border-white border-opacity-20 d-flex align-items-center justify-content-center" style="width: 56px; height: 56px;">
                            <i class="bi bi-bank2 fs-2 text-warning"></i>
                        </div>
                    @endif
                    <div>
                        <span class="badge bg-warning text-dark fw-bold px-2 py-0.5 rounded-pill fs-9 text-uppercase mb-1 d-inline-block">
                            Jaringan Dokumentasi &amp; Informasi Hukum
                        </span>
                        <h4 class="fw-bold mb-0 text-white lh-1">{{ $gProfil->nama_singkat_kantor ?? 'JDIH DPRD' }}</h4>
                        <div class="text-white-50 fs-8 fw-semibold letter-spacing-1 mt-1 text-uppercase">
                            {{ $gProfil->nama_wilayah ?? 'KABUPATEN BOLAANG MONGONDOW UTARA' }}
                        </div>
                    </div>
                </div>

                <!-- Right: JDIHN National Badge & Hotline -->
                <div class="d-none d-md-flex align-items-center gap-4">
                    <div class="text-end text-white-50 fs-8">
                        <div><i class="bi bi-geo-alt-fill text-warning me-1"></i> {{ $gProfil->alamat ?? 'Boroko, Kab. Bolaang Mongondow Utara' }}</div>
                        <div class="mt-1"><i class="bi bi-telephone-fill text-warning me-1"></i> {{ $gProfil->telepon ?? '061-4537728' }}</div>
                    </div>
                    <div class="bg-white bg-opacity-10 p-2 px-3 rounded-3 border border-white border-opacity-20 text-center">
                        <i class="bi bi-shield-check fs-4 text-warning d-block"></i>
                        <small class="text-white fw-bold" style="font-size: 0.68rem; letter-spacing: 0.5px;">TERINTEGRASI JDIHN</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Main Navigation Bar -->
<header class="sticky-top bg-white border-bottom shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light navbar-main">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand d-flex align-items-center py-2" href="{{ route('portal.home') }}">
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary text-white p-2 rounded-3 d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 44px; height: 44px;">
                        <i class="bi bi-bank2 fs-4 text-warning"></i>
                    </div>
                    <div class="lh-1">
                        <div class="fw-bold fs-5 text-dark" style="letter-spacing: -0.5px;">{{ $gProfil->nama_singkat_kantor ?? 'JDIH DPRD' }}</div>
                        <small class="text-muted fw-semibold text-uppercase"
                            style="font-size: 0.72rem; letter-spacing: 0.5px;">{{ $gProfil->nama_wilayah ?? 'KABUPATEN BOLAANG MONGONDOW UTARA' }}</small>
                    </div>
                </div>
            </a>

            <!-- Mobile Hamburger Toggle -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarJdihMain" aria-controls="navbarJdihMain" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarJdihMain">
                <ul class="navbar-nav align-items-lg-center">

                    <!-- 1. Beranda -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.home') ? 'active' : '' }}"
                            href="{{ route('portal.home') }}">
                            Beranda
                        </a>
                    </li>

                    <!-- 2. Tentang Kami (Dropdown) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.about') || Route::is('portal.profile') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Tentang Kami
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('portal.about', 'dasar-hukum') }}"><i
                                        class="fa-solid fa-gavel"></i> Dasar Hukum</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.about', 'sk-tim') }}"><i
                                        class="fa-solid fa-users-gear"></i> SK Tim Pengelola</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.about', 'struktur-organisasi') }}"><i
                                        class="fa-solid fa-sitemap"></i> Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.about', 'sop') }}"><i
                                        class="fa-solid fa-arrows-rotate"></i> Standar Operasional (SOP)</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.about', 'visi-misi') }}"><i
                                        class="fa-solid fa-bullseye"></i> Visi, Misi &amp; Maklumat</a></li>
                        </ul>
                    </li>

                    <!-- 3. Informasi (Dropdown) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.news.*') || Route::is('portal.gallery') || Route::is('portal.video') || Route::is('portal.agenda') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('portal.news.list') }}"><i
                                        class="fa-solid fa-newspaper"></i> Berita Kegiatan &amp; Hukum</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.gallery') }}"><i
                                        class="fa-solid fa-images"></i> Galeri Foto</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.video') }}"><i
                                        class="fa-solid fa-video"></i> Video Kegiatan</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.agenda') }}"><i
                                        class="fa-solid fa-calendar-days"></i> Agenda Kegiatan DPRD</a></li>
                        </ul>
                    </li>

                    <!-- 4. Alur Ranperda (Dropdown) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.ranperda*') ? 'active' : '' }}" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Alur Ranperda
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('portal.ranperda', ['tahun' => 2026]) }}"><i
                                        class="fa-solid fa-file-contract"></i> Propemperda 2026</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.ranperda', ['tahun' => 2025]) }}"><i
                                        class="fa-solid fa-file-contract"></i> Propemperda 2025</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.ranperda', ['tahun' => 2024]) }}"><i
                                        class="fa-solid fa-file-contract"></i> Propemperda 2024</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('portal.ranperda') }}"><i
                                        class="fa-solid fa-route"></i> Tahapan Pembentukan Perda</a></li>
                        </ul>
                    </li>

                    <!-- 5. Dokumen Hukum (Hierarchical Mega Dropdown) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.search') || Route::is('portal.documents') || Route::is('portal.document.*') ? 'active' : '' }}"
                            href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dokumen Hukum
                        </a>
                        <ul class="dropdown-menu">
                            <!-- Produk Hukum Submenu -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle justify-content-between"
                                    href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum']) }}">
                                    <span><i class="fa-solid fa-scale-balanced"></i> Produk Hukum</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 1]) }}">Peraturan
                                            Daerah</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 2]) }}">Peraturan
                                            Kepala Daerah</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 3]) }}">Keputusan
                                            DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 4]) }}">Peraturan
                                            DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 5]) }}">Keputusan
                                            Pimpinan DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 6]) }}">Keputusan
                                            Sekretaris DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 7]) }}">Surat
                                            Edaran</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 8]) }}">Persetujuan
                                            Bersama Walikota &amp; DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 9]) }}">MoU
                                            (Nota Kesepahaman)</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum', 'jenis_dokumen_id' => 10]) }}">Perjanjian
                                            Kerja Sama</a></li>
                                </ul>
                            </li>

                            <!-- Monografi Hukum Submenu -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle justify-content-between"
                                    href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum']) }}">
                                    <span><i class="fa-solid fa-book"></i> Monografi Hukum</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 11]) }}">Rancangan
                                            Peraturan Daerah</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 12]) }}">Naskah
                                            Akademik</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 13]) }}">Risalah
                                            Rapat</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 14]) }}">Koleksi
                                            Buku</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 15]) }}">Hasil
                                            Harmonisasi</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 16]) }}">Evaluasi
                                            / Fasilitasi Ranperda</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 17]) }}">Rancangan
                                            Peraturan DPRD</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 20]) }}">Notulen
                                            Rapat</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum', 'jenis_dokumen_id' => 21]) }}">Jadwal
                                            Acara Rapat DPRD</a></li>
                                </ul>
                            </li>

                            <!-- Artikel Hukum Submenu -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle justify-content-between"
                                    href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum']) }}">
                                    <span><i class="fa-solid fa-feather-pointed"></i> Artikel Hukum</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 22]) }}">Artikel
                                            Ilmiah</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 23]) }}">Kliping
                                            Koran</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 24]) }}">Artikel
                                            Hukum</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 25]) }}">Protokol</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 26]) }}">Artikel
                                            Bahasa Inggris</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum', 'jenis_dokumen_id' => 27]) }}">Piagam
                                            &amp; Dokumen Langka</a></li>
                                </ul>
                            </li>

                            <!-- Putusan Pengadilan Submenu -->
                            <li class="dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle justify-content-between"
                                    href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan']) }}">
                                    <span><i class="fa-solid fa-landmark"></i> Putusan Pengadilan</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan', 'jenis_dokumen_id' => 29]) }}">Putusan
                                            Mahkamah Agung</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan', 'jenis_dokumen_id' => 30]) }}">Penetapan
                                            Pengadilan Negeri</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan', 'jenis_dokumen_id' => 31]) }}">Putusan
                                            Pengadilan Negeri</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan', 'jenis_dokumen_id' => 32]) }}">Putusan
                                            Pengadilan Tinggi</a></li>
                                </ul>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item fw-bold text-primary" href="{{ route('portal.search') }}">
                                    <i class="fa-solid fa-magnifying-glass"></i> Cari Semua Dokumen
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- 6. Buletin -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.buletin*') ? 'active' : '' }}"
                            href="{{ route('portal.buletin') }}">
                            Buletin
                        </a>
                    </li>

                    <!-- 7. Statistik -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.statistics') ? 'active' : '' }}"
                            href="{{ route('portal.statistics') }}">
                            Statistik
                        </a>
                    </li>

                    <!-- 8. Hubungi Kami -->
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.contact') ? 'active' : '' }}"
                            href="{{ route('portal.contact') }}">
                            Hubungi Kami
                        </a>
                    </li>



                </ul>
            </div>
        </div>
    </nav>
</header>