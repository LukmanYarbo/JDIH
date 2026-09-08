@extends('layouts.portal')

@section('title', 'Selamat Datang di Portal JDIH ' . ($profil->nama_singkat_kantor ?? ($profil->nama_kantor ?? 'DPRD Kabupaten Bolaang Mongondow Utara')))

@section('content')

    <!-- 1. Running Agenda DPRD Ticker -->
    <div class="agenda-ticker-wrapper">
        <div class="agenda-ticker-label">
            <i class="bi bi-pin-angle-fill"></i> Agenda DPRD
        </div>
        <div class="agenda-ticker-bar">
            <div class="agenda-ticker-track">
                @forelse($tickerAgendas as $agenda)
                    <span class="agenda-ticker-item">
                        <span class="badge-date"><i class="bi bi-calendar2-event me-1"></i> {{ $agenda->waktu_mulai->format('d M Y, H:i') }} WIB</span>
                        <strong>{{ $agenda->judul }}</strong>
                        @if($agenda->pelaksana || $agenda->mitra_kerja)
                            <span class="badge bg-warning text-dark fs-9 ms-1">
                                {{ $agenda->pelaksana ?: 'DPRD' }}@if($agenda->mitra_kerja) &amp; {{ $agenda->mitra_kerja }}@endif
                            </span>
                        @endif
                        @if($agenda->lokasi)
                            <span class="text-muted fs-8">({{ $agenda->lokasi }})</span>
                        @endif
                        <span class="text-warning fw-bold mx-2">&bull;</span>
                    </span>
                @empty
                    <span class="agenda-ticker-item">
                        <span class="badge-date">Hari Ini</span>
                        Pelaksanaan Pelayanan Informasi Produk Hukum di Gedung {{ $profil->nama_sekretariat ?? 'Sekretariat DPRD Kabupaten Bolaang Mongondow Utara' }}
                    </span>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 2. Hero Section with Multi-Criteria Search Card -->
    <section class="hero-search-section">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h2 class="hero-title-main fs-2 fs-md-1">{{ $profil->welcome_title ?? 'JARINGAN DOKUMENTASI DAN INFORMASI HUKUM' }}</h2>
                    <h3 class="hero-subtitle-main fs-4 fs-md-3 text-uppercase">{{ $profil->welcome_subtitle ?? ($profil->nama_kantor ?? 'DEWAN PERWAKILAN RAKYAT DAERAH KABUPATEN BOLAANG MONGONDOW UTARA') }}</h3>

                    <!-- Multi-Criteria Search Card -->
                    <div class="search-card-container text-start">
                        <div class="text-center mb-3">
                            <h4 class="fw-bold mb-1 text-dark">
                                Silahkan Cari <span class="text-primary">Produk Hukum DPRD</span>
                            </h4>
                            <p class="text-muted fs-8 mb-0">Temukan Perda, Peraturan DPRD, Keputusan, dan Monografi Hukum resmi</p>
                        </div>

                        <form action="{{ route('portal.search') }}" method="GET" id="formSearchHero" class="row g-2">
                            <!-- Kata Kunci / Judul -->
                            <div class="col-12">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                    <input type="text" name="q" id="hero_judul_cari" class="form-control bg-light border-start-0 py-2.5 fs-7" placeholder="Ketik Kata Kunci, Judul, atau Subjek Dokumen...">
                                </div>
                            </div>

                            <!-- Tipe Dokumen -->
                            <div class="col-md-3">
                                <select name="tipe_dokumen" id="hero_tipe_dokumen" class="form-select fs-7 py-2" onchange="filterJenisByTipe(this.value)">
                                    <option value="">.:: Tipe Dokumen ::.</option>
                                    <option value="Produk Hukum">Produk Hukum</option>
                                    <option value="Monografi Hukum">Monografi Hukum</option>
                                    <option value="Artikel Hukum">Artikel Hukum</option>
                                    <option value="Putusan Pengadilan">Putusan Pengadilan</option>
                                </select>
                            </div>

                            <!-- Jenis Produk Hukum (Dynamic) -->
                            <div class="col-md-3">
                                <select name="jenis_dokumen_id" id="hero_jenis_dokumen_id" class="form-select fs-7 py-2">
                                    <option value="">.:: Jenis Produk Hukum ::.</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" data-tipe="{{ $cat->tipe_dokumen }}">
                                            {{ $cat->nama }} ({{ $cat->dokumen_hukums_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Nomor -->
                            <div class="col-md-3">
                                <input type="text" name="nomor" id="hero_nomor_cari" class="form-control fs-7 py-2" placeholder="Nomor Dokumen">
                            </div>

                            <!-- Tahun -->
                            <div class="col-md-3">
                                <select name="tahun" id="hero_tahun_cari" class="form-select fs-7 py-2">
                                    <option value="">.:: Semua Tahun ::.</option>
                                    @foreach($years as $yr)
                                        <option value="{{ $yr }}">{{ $yr }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-3">
                                <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2.5 rounded-pill shadow-sm" style="background: linear-gradient(135deg, #f59e0b, #fbbf24); border:none;">
                                    <i class="bi bi-search me-1"></i> Cari Produk Hukum
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- 3. Main Content: Dokumen Terbaru & Sidebar Statistics -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Left Column: Latest Documents List (Col 8) -->
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-3">
                        <div>
                            <h4 class="fw-bold text-primary mb-1">
                                <i class="bi bi-journal-bookmark me-2 text-warning"></i> Dokumen Terbaru
                            </h4>
                            <p class="text-muted fs-7 mb-0">Publikasi produk dan dokumentasi hukum terkini yang telah ditetapkan</p>
                        </div>
                        <a href="{{ route('portal.search') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse($recentDokumens as $doc)
                            <div class="doc-item-card">
                                <div class="row align-items-center">
                                    
                                    <!-- Left Doc Icon & Info -->
                                    <div class="col-md-8 d-flex align-items-start gap-3">
                                        <div class="doc-icon-box">
                                            @if($doc->tipe_dokumen == 'Produk Hukum')
                                                <i class="fa-solid fa-scale-balanced"></i>
                                            @elseif($doc->tipe_dokumen == 'Monografi Hukum')
                                                <i class="fa-solid fa-book-bookmark"></i>
                                            @elseif($doc->tipe_dokumen == 'Artikel Hukum')
                                                <i class="fa-solid fa-newspaper"></i>
                                            @else
                                                <i class="fa-solid fa-landmark"></i>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-0.5 fs-8 rounded-pill">
                                                    {{ $doc->jenisDokumen->nama ?? $doc->tipe_dokumen }}
                                                </span>
                                                <span class="text-muted fs-8">
                                                    No. {{ $doc->nomor }} Tahun {{ $doc->tahun }}
                                                </span>
                                            </div>

                                            <h6 class="fw-bold mb-1">
                                                <a href="{{ route('portal.document.show', $doc->id) }}" class="text-dark text-decoration-none hover-text-primary" title="{{ $doc->judul }}">
                                                    {{ Str::limit($doc->judul, 110) }}
                                                </a>
                                            </h6>

                                            <p class="text-muted fs-8 mb-2 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                <strong>Tentang:</strong> {{ $doc->abstrak ?: $doc->judul }}
                                            </p>

                                            <div class="d-flex align-items-center gap-3 text-muted fs-8 flex-wrap">
                                                <span class="badge-status status-{{ Str::slug($doc->status) }}">
                                                    {{ $doc->status }}
                                                </span>
                                                <span><i class="bi bi-file-earmark"></i> {{ $doc->file_size ?: '2.4 MB' }}</span>
                                                <span><i class="bi bi-cloud-arrow-down"></i> Diunduh: <strong>{{ number_format($doc->downloads) }}</strong> kali</span>
                                                <span><i class="bi bi-eye"></i> Dilihat: <strong>{{ number_format($doc->hits) }}</strong> kali</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Action Buttons -->
                                    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex flex-md-column justify-content-center align-items-md-end gap-2">
                                        <button type="button" class="btn-action-preview" onclick="openPreviewModal({{ $doc->id }})">
                                            <i class="bi bi-eye-fill me-1"></i> Preview
                                        </button>
                                        <button type="button" class="btn-action-abstract" onclick="openAbstractModal({{ $doc->id }})">
                                            <i class="bi bi-card-text me-1"></i> Abstrak
                                        </button>
                                        <a href="{{ route('portal.document.download', $doc->id) }}" class="btn-action-download text-decoration-none">
                                            <i class="bi bi-download me-1"></i> Unduh PDF
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted bg-white rounded-3 border">
                                <i class="bi bi-journal-x fs-1 d-block mb-2"></i>
                                Belum ada dokumen hukum yang dipublikasikan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Sidebar Statistics & Widgets (Col 4) -->
                <div class="col-lg-4">
                    
                    <!-- Fast Statistics Counters Grid -->
                    <div class="mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-bar-chart-fill me-2 text-warning"></i> Dokumen Hukum
                        </h5>
                        <div class="row g-3">
                            <!-- Monografi Hukum -->
                            <div class="col-6">
                                <a href="{{ route('portal.search', ['tipe_dokumen' => 'Monografi Hukum']) }}" class="text-decoration-none">
                                    <div class="stat-card-clean h-100">
                                        <div class="text-primary mb-2"><i class="fa-solid fa-book fs-3"></i></div>
                                        <h3 class="fw-bold text-dark mb-0 font-monospace">{{ number_format($countMonografi) }}</h3>
                                        <div class="text-muted fs-8 fw-semibold mt-1">Monografi Hukum</div>
                                    </div>
                                </a>
                            </div>

                            <!-- Artikel Hukum -->
                            <div class="col-6">
                                <a href="{{ route('portal.search', ['tipe_dokumen' => 'Artikel Hukum']) }}" class="text-decoration-none">
                                    <div class="stat-card-clean h-100">
                                        <div class="text-success mb-2"><i class="fa-solid fa-newspaper fs-3"></i></div>
                                        <h3 class="fw-bold text-dark mb-0 font-monospace">{{ number_format($countArtikel) }}</h3>
                                        <div class="text-muted fs-8 fw-semibold mt-1">Artikel Hukum</div>
                                    </div>
                                </a>
                            </div>

                            <!-- Peraturan -->
                            <div class="col-6">
                                <a href="{{ route('portal.search', ['tipe_dokumen' => 'Produk Hukum']) }}" class="text-decoration-none">
                                    <div class="stat-card-clean h-100">
                                        <div class="text-warning mb-2"><i class="fa-solid fa-gavel fs-3"></i></div>
                                        <h3 class="fw-bold text-dark mb-0 font-monospace">{{ number_format($countPeraturan) }}</h3>
                                        <div class="text-muted fs-8 fw-semibold mt-1">Peraturan</div>
                                    </div>
                                </a>
                            </div>

                            <!-- Yurisprudensi -->
                            <div class="col-6">
                                <a href="{{ route('portal.search', ['tipe_dokumen' => 'Putusan Pengadilan']) }}" class="text-decoration-none">
                                    <div class="stat-card-clean h-100">
                                        <div class="text-info mb-2"><i class="fa-solid fa-landmark fs-3"></i></div>
                                        <h3 class="fw-bold text-dark mb-0 font-monospace">{{ number_format($countPutusan) }}</h3>
                                        <div class="text-muted fs-8 fw-semibold mt-1">Yurisprudensi</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Widget: Indeks Kepuasan Masyarakat (IKM) Polling -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4 bg-white">
                        <h6 class="fw-bold text-primary mb-3 d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-chat-heart-fill text-danger me-2"></i> Indeks Kepuasan (IKM)</span>
                            <span class="badge bg-light text-muted fs-9">Survei Publik</span>
                        </h6>
                        <p class="fs-8 text-muted mb-3 fw-semibold">Bagaimana menurut Anda mengenai kemudahan dan kelengkapan informasi pada portal kami?</p>
                        
                        <form id="formIkmVote" method="POST">
                            @csrf
                            <div class="d-flex flex-column gap-2 mb-3 fs-8">
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2 border bg-light cursor-pointer">
                                    <input type="radio" name="jawaban" value="Sangat Informatif" checked class="form-check-input mt-0">
                                    <span class="text-dark fw-medium">Sangat Informatif</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2 border bg-light cursor-pointer">
                                    <input type="radio" name="jawaban" value="Informatif" class="form-check-input mt-0">
                                    <span class="text-dark fw-medium">Informatif</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2 border bg-light cursor-pointer">
                                    <input type="radio" name="jawaban" value="Biasa Saja" class="form-check-input mt-0">
                                    <span class="text-dark fw-medium">Biasa Saja</span>
                                </label>
                                <label class="d-flex align-items-center gap-2 p-2 rounded-2 border bg-light cursor-pointer">
                                    <input type="radio" name="jawaban" value="Kurang Informatif" class="form-check-input mt-0">
                                    <span class="text-dark fw-medium">Kurang Informatif</span>
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3 flex-grow-1 fw-semibold">
                                    <i class="bi bi-send-check me-1"></i> Simpan Suara
                                </button>
                                <button type="button" class="btn btn-sm btn-info text-white rounded-pill px-3 fw-semibold" onclick="showIkmResults()">
                                    <i class="bi bi-pie-chart me-1"></i> Hasil
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Widget: Social Media Connect -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                        <h6 class="fw-bold text-primary mb-3">
                            <i class="bi bi-share-fill text-primary me-2"></i> Ikuti Media Sosial Kami
                        </h6>
                        <div class="d-flex flex-column gap-2 fs-8">
                            <a href="{{ $profil->facebook ?? '#' }}" target="_blank" class="d-flex align-items-center gap-3 p-2 rounded-2 text-decoration-none bg-light text-dark hover-lift">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:34px; height:34px;">
                                    <i class="fab fa-facebook-f"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Facebook</div>
                                    <small class="text-muted">{{ $profil->nama_sekretariat ?? 'Sekretariat DPRD' }}</small>
                                </div>
                            </a>
                            <a href="{{ $profil->instagram ?? '#' }}" target="_blank" class="d-flex align-items-center gap-3 p-2 rounded-2 text-decoration-none bg-light text-dark hover-lift">
                                <div class="text-white rounded-circle d-flex align-items-center justify-content-center" style="width:34px; height:34px; background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%);">
                                    <i class="fab fa-instagram"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">Instagram</div>
                                    <small class="text-muted">{{ $profil->nama_singkat_kantor ?? 'Instagram Resmi' }}</small>
                                </div>
                            </a>
                            <a href="{{ $profil->youtube ?? '#' }}" target="_blank" class="d-flex align-items-center gap-3 p-2 rounded-2 text-decoration-none bg-light text-dark hover-lift">
                                <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width:34px; height:34px;">
                                    <i class="fab fa-youtube"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">YouTube</div>
                                    <small class="text-muted">{{ $profil->nama_singkat_kantor ?? 'DPRD' }} Channel</small>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- 4. Berita Terbaru Section -->
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="fw-bold text-primary mb-1">
                        <i class="bi bi-newspaper me-2 text-warning"></i> Berita Kegiatan &amp; Hukum
                    </h4>
                    <p class="text-muted fs-7 mb-0">Informasi kegiatan kedewanan, persidangan, dan kajian hukum terbaru</p>
                </div>
                <a href="{{ route('portal.news.list') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Semua Berita <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($recentNews as $news)
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden hover-lift">
                            <div class="position-relative bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 160px;">
                                @if($news->gambar && file_exists(public_path($news->gambar)))
                                    <img src="{{ asset($news->gambar) }}" class="w-100 h-100 object-fit-cover" alt="{{ $news->judul }}">
                                @else
                                    <i class="bi bi-newspaper fs-1 text-primary opacity-50"></i>
                                @endif
                                <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-75 fs-9 font-monospace">
                                    {{ $news->created_at->format('d M Y') }}
                                </span>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="fw-bold mb-2">
                                    <a href="{{ route('portal.news.show', $news->slug) }}" class="text-dark text-decoration-none" title="{{ $news->judul }}">
                                        {{ Str::limit($news->judul, 65) }}
                                    </a>
                                </h6>
                                <p class="text-muted fs-8 mb-3 flex-grow-1">
                                    {{ Str::limit(strip_tags($news->konten), 90) }}
                                </p>
                                <a href="{{ route('portal.news.show', $news->slug) }}" class="text-primary fw-semibold fs-8 text-decoration-none mt-auto">
                                    Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-4">Belum ada berita.</div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 5. Download Aplikasi Smart JDIH Banner Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%); color:white;">
        <div class="container">
            <div class="row align-items-center justify-content-between g-4">
                <div class="col-lg-7">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-warning text-dark p-2 rounded-3 fs-3">
                            <i class="bi bi-phone-fill"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0 text-white">Download Aplikasi <span class="text-warning">Smart JDIH</span></h3>
                            <p class="text-white-50 fs-7 mb-0">Akses produk hukum daerah dalam genggaman Anda</p>
                        </div>
                    </div>
                    <p class="fs-7 text-white-50 mb-4 lh-base">
                        Kini tersedia aplikasi <strong>Smart JDIH {{ $profil->nama_singkat_kantor ?? ($profil->nama_kantor ?? 'DPRD') }}</strong> untuk smartphone Android dan iOS. Dapatkan kemudahan penelusuran peraturan daerah, risalah sidang, rancangan peraturan, dan notifikasi regulasi terbaru kapanpun dan dimanapun secara real-time.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#" class="btn btn-light rounded-pill px-4 py-2 fw-semibold fs-7 d-inline-flex align-items-center gap-2">
                            <i class="fab fa-google-play text-primary fs-5"></i>
                            <div>
                                <small class="d-block text-muted" style="font-size:0.65rem; line-height:1;">TERSEDIA DI</small>
                                <span>Google Play</span>
                            </div>
                        </a>
                        <a href="#" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold fs-7 d-inline-flex align-items-center gap-2">
                            <i class="fab fa-apple fs-5"></i>
                            <div>
                                <small class="d-block text-white-50" style="font-size:0.65rem; line-height:1;">UNDUH DI</small>
                                <span>App Store</span>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="bg-white p-4 rounded-4 shadow-lg d-inline-block text-dark">
                        <div class="bg-light p-3 rounded-3 mb-2">
                            <i class="bi bi-qr-code fs-1 text-primary"></i>
                            <div class="fw-bold fs-7 mt-1">Scan QR Code</div>
                        </div>
                        <small class="text-muted fs-9 d-block">Pindai dengan kamera ponsel untuk unduh cepat</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. Link Terkait / Partner Networks -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h5 class="fw-bold text-primary mb-1">Link Terkait &amp; Mitra JDIH</h5>
            <p class="text-muted fs-8 mb-4">Sinergi jaringan informasi hukum tingkat nasional dan daerah</p>
            
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-7 g-3 align-items-center justify-content-center">
                <div class="col">
                    <a href="https://www.dpr.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-bank2 fs-2 text-primary mb-1"></i>
                        <span class="fs-8 fw-semibold">DPR RI</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://jdihn.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-shield-shaded fs-2 text-warning mb-1"></i>
                        <span class="fs-8 fw-semibold">JDIHN Nasional</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://jdih.kemendagri.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-building fs-2 text-danger mb-1"></i>
                        <span class="fs-8 fw-semibold">Kemendagri</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://jdih.bolmutkab.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-geo-alt-fill fs-2 text-success mb-1"></i>
                        <span class="fs-8 fw-semibold">JDIH Bolmut</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://jdih.sulutprov.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-pin-map-fill fs-2 text-info mb-1"></i>
                        <span class="fs-8 fw-semibold">Provinsi Sulut</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://www.kpk.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-shield-lock-fill fs-2 text-danger mb-1"></i>
                        <span class="fs-8 fw-semibold">KPK RI</span>
                    </a>
                </div>
                <div class="col">
                    <a href="https://bphn.go.id/" target="_blank" class="card p-3 border-0 shadow-sm text-decoration-none text-dark hover-lift h-100 d-flex align-items-center justify-content-center">
                        <i class="bi bi-journal-bookmark-fill fs-2 text-primary mb-1"></i>
                        <span class="fs-8 fw-semibold">BPHN</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    // Dynamic Filter Jenis Dokumen by Tipe Dokumen on Hero Card
    function filterJenisByTipe(selectedTipe) {
        const selectJenis = document.getElementById('hero_jenis_dokumen_id');
        const options = selectJenis.querySelectorAll('option');

        options.forEach(opt => {
            if (opt.value === '') {
                opt.style.display = 'block';
                return;
            }
            const tipe = opt.getAttribute('data-tipe');
            if (!selectedTipe || tipe === selectedTipe) {
                opt.style.display = 'block';
            } else {
                opt.style.display = 'none';
            }
        });
        selectJenis.value = '';
    }
</script>
@endsection
