@extends('layouts.portal')

@section('title', 'JDIH DPRD Kabupaten Bolaang Mongondow Utara')

@section('content')
    <!-- Hero Section -->
    <section class="position-relative py-5 overflow-hidden" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%); min-height: 480px; display: flex; align-items: center;">
        <!-- Backdrop elements -->
        <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 20px 20px;"></div>
        <div class="position-absolute top-50 start-50 translate-middle w-75 h-75 bg-warning rounded-circle opacity-5 blur-50" style="filter: blur(120px);"></div>
        
        <div class="container position-relative z-1 py-4 text-center">
            <h1 class="text-white fw-bold mb-2 display-5" style="letter-spacing: -1px;">
                Jaringan Dokumentasi &amp; Informasi Hukum
            </h1>
            <p class="lead text-white-50 mb-4 max-width-600 mx-auto fs-6">
                Temukan Peraturan Daerah dan Keputusan resmi dari Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara secara cepat, akurat, dan transparan.
            </p>
            
            <!-- Large Search Engine -->
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <form action="{{ route('portal.search') }}" method="GET" class="p-2 bg-white rounded-pill shadow-lg d-flex align-items-center">
                        <div class="d-flex align-items-center flex-grow-1 px-3">
                            <i class="bi bi-search text-muted fs-5 me-2"></i>
                            <input type="text" name="q" class="form-control border-0 shadow-none py-2 text-dark fs-6" placeholder="Cari Peraturan, Nomor, Tahun, atau Kata Kunci..." required>
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold">
                            Cari Dokumen
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-white-50 fs-7">
                <span class="me-2"><i class="bi bi-fire text-warning me-1"></i> Populer:</span>
                <a href="{{ route('portal.search', ['jenis_dokumen_id' => 1]) }}" class="text-warning text-decoration-none me-3">Peraturan Daerah</a>
                <a href="{{ route('portal.search', ['q' => 'APBD']) }}" class="text-warning text-decoration-none me-3">APBD</a>
                <a href="{{ route('portal.search', ['q' => 'Tata Tertib']) }}" class="text-warning text-decoration-none">Tata Tertib</a>
            </div>
        </div>
    </section>

    <!-- Stats & Categories Section -->
    <section class="py-5 mt-n5 position-relative z-2">
        <div class="container">
            <!-- Categories Grid -->
            <div class="row g-4">
                @foreach($categories as $category)
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 glass-card hover-lift h-100 p-4">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                    @if($category->kode == 'PERDA')
                                        <i class="bi bi-journal-bookmark fs-3"></i>
                                    @elseif($category->kode == 'PER-DPRD')
                                        <i class="bi bi-file-earmark-person fs-3"></i>
                                    @elseif($category->kode == 'KEP-DPRD')
                                        <i class="bi bi-patch-check fs-3"></i>
                                    @else
                                        <i class="bi bi-file-earmark-text fs-3"></i>
                                    @endif
                                </div>
                                <span class="fs-2 fw-bold text-primary opacity-25 font-monospace">
                                    {{ sprintf('%02d', $category->dokumen_hukums_count) }}
                                </span>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">{{ $category->nama }}</h5>
                            <p class="text-muted fs-7 mb-4 flex-grow-1">{{ Str::limit($category->deskripsi, 80) }}</p>
                            <a href="{{ route('portal.search', ['jenis_dokumen_id' => $category->id]) }}" class="text-primary fw-semibold fs-7 text-decoration-none mt-auto">
                                Lihat Dokumen <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Recent Documents & Sidebar News -->
    <section class="py-4">
        <div class="container">
            <div class="row g-5">
                <!-- Latest Documents -->
                <div class="col-lg-8">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <h3 class="fw-bold m-0 text-primary">Dokumen Terbaru</h3>
                            <p class="text-muted m-0 fs-7">Produk hukum legislative teranyar yang telah ditetapkan</p>
                        </div>
                        <a href="{{ route('portal.search') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    
                    <div class="d-flex flex-column gap-3">
                        @forelse($recentDokumens as $doc)
                            <div class="card border-0 shadow-sm p-4 hover-lift">
                                <div class="row align-items-start">
                                    <div class="col-md-9">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 fs-8 fw-semibold">
                                                {{ $doc->jenisDokumen->nama }}
                                            </span>
                                            <span class="text-muted fs-8">
                                                No. {{ $doc->nomor }} Tahun {{ $doc->tahun }}
                                            </span>
                                        </div>
                                        <h5 class="fw-bold mb-2">
                                            <a href="{{ route('portal.document.show', $doc->id) }}" class="text-dark text-decoration-none hover-text-primary">
                                                {{ $doc->judul }}
                                            </a>
                                        </h5>
                                        <p class="text-muted fs-7 mb-0">
                                            {{ Str::limit($doc->abstrak, 150) }}
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-md-end mt-3 mt-md-0 d-flex flex-md-column justify-content-between align-items-end h-100 gap-2">
                                        <span class="badge-status status-{{ Str::slug($doc->status) }} fs-8">
                                            {{ $doc->status }}
                                        </span>
                                        <div class="d-flex gap-2 w-100 justify-content-md-end">
                                            <a href="{{ route('portal.document.show', $doc->id) }}" class="btn btn-sm btn-light rounded-pill px-3">
                                                Detail
                                            </a>
                                            @if($doc->file_pdf)
                                                <a href="{{ route('portal.document.download', $doc->id) }}" class="btn btn-sm btn-primary rounded-pill px-3">
                                                    <i class="bi bi-download"></i> PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-file-earmark-lock fs-1 d-block mb-3"></i>
                                Belum ada dokumen hukum yang diterbitkan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Latest News / Activities -->
                <div class="col-lg-4">
                    <h3 class="fw-bold mb-4 text-primary">Berita Hukum</h3>
                    <div class="d-flex flex-column gap-4">
                        @forelse($recentNews as $news)
                            <div class="card border-0 shadow-sm overflow-hidden hover-lift h-100">
                                @if($news->gambar)
                                    <img src="{{ asset($news->gambar) }}" class="card-img-top" alt="{{ $news->judul }}" style="height: 180px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 140px;">
                                        <i class="bi bi-newspaper text-primary display-5"></i>
                                    </div>
                                @endif
                                <div class="card-body p-4">
                                    <div class="text-muted fs-8 mb-2">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $news->created_at->format('d M Y') }}
                                    </div>
                                    <h5 class="fw-bold mb-2">
                                        <a href="{{ route('portal.news.show', $news->slug) }}" class="text-dark text-decoration-none">
                                            {{ Str::limit($news->judul, 60) }}
                                        </a>
                                    </h5>
                                    <p class="text-muted fs-7 mb-3">
                                        {{ Str::limit(strip_tags($news->konten), 100) }}
                                    </p>
                                    <a href="{{ route('portal.news.show', $news->slug) }}" class="text-primary fw-semibold fs-7 text-decoration-none">
                                        Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                Belum ada berita yang diterbitkan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Information banner / callout -->
    <section class="py-5 bg-white border-top border-bottom my-5">
        <div class="container text-center py-3">
            <h4 class="fw-bold mb-2">Butuh bantuan mencari Produk Hukum?</h4>
            <p class="text-muted mb-4 max-width-600 mx-auto fs-6">
                Layanan informasi hukum JDIH DPRD Bolaang Mongondow Utara melayani publik secara transparan. Anda juga dapat menggunakan modul pencarian lanjut untuk filter yang lebih terperinci.
            </p>
            <a href="{{ route('portal.search') }}" class="btn btn-primary rounded-pill px-4 py-2.5 fw-semibold shadow-sm">
                Gunakan Pencarian Lanjut
            </a>
        </div>
    </section>
@endsection
