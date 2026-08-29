@extends('layouts.portal')

@section('title', 'Pencarian Produk & Dokumen Hukum - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h3 class="fw-bold mb-1">Katalog Dokumen Hukum</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb fs-8 mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                            <li class="breadcrumb-item active text-warning" aria-current="page">Pencarian Dokumen</li>
                        </ol>
                    </nav>
                </div>
                <div class="text-end text-white-50 fs-8">
                    Total Ditemukan: <strong class="text-warning fs-6">{{ $documents->total() }}</strong> Dokumen
                </div>
            </div>
        </div>
    </section>

    <!-- Search & Filter Area -->
    <section class="py-4">
        <div class="container">
            
            <!-- Filter Bar Card -->
            <div class="card border-0 shadow-sm p-4 rounded-3 mb-4 bg-white">
                <form action="{{ route('portal.search') }}" method="GET" class="row g-2 align-items-center">
                    
                    <!-- Keyword -->
                    <div class="col-lg-4 col-md-12">
                        <label class="form-label fs-8 fw-semibold text-muted mb-1">Kata Kunci / Judul</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-start-0 fs-7" placeholder="Judul, Perihal, atau Subjek...">
                        </div>
                    </div>

                    <!-- Tipe Dokumen -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label fs-8 fw-semibold text-muted mb-1">Tipe Dokumen</label>
                        <select name="tipe_dokumen" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">Semua Tipe</option>
                            <option value="Produk Hukum" {{ request('tipe_dokumen') == 'Produk Hukum' ? 'selected' : '' }}>Produk Hukum</option>
                            <option value="Monografi Hukum" {{ request('tipe_dokumen') == 'Monografi Hukum' ? 'selected' : '' }}>Monografi Hukum</option>
                            <option value="Artikel Hukum" {{ request('tipe_dokumen') == 'Artikel Hukum' ? 'selected' : '' }}>Artikel Hukum</option>
                            <option value="Putusan Pengadilan" {{ request('tipe_dokumen') == 'Putusan Pengadilan' ? 'selected' : '' }}>Putusan Pengadilan</option>
                        </select>
                    </div>

                    <!-- Jenis Dokumen -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label fs-8 fw-semibold text-muted mb-1">Jenis Dokumen</label>
                        <select name="jenis_dokumen_id" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">Semua Jenis</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label fs-8 fw-semibold text-muted mb-1">Tahun</label>
                        <select name="tahun" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>{{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-lg-2 col-md-3 col-6">
                        <label class="form-label fs-8 fw-semibold text-muted mb-1">Status</label>
                        <select name="status" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Berlaku" {{ request('status') == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                            <option value="Mengubah" {{ request('status') == 'Mengubah' ? 'selected' : '' }}>Mengubah</option>
                            <option value="Diubah" {{ request('status') == 'Diubah' ? 'selected' : '' }}>Diubah</option>
                            <option value="Dicabut" {{ request('status') == 'Dicabut' ? 'selected' : '' }}>Dicabut</option>
                            <option value="Tidak Berlaku" {{ request('status') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                        </select>
                    </div>

                    <!-- Submit & Reset Buttons -->
                    <div class="col-12 mt-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary rounded-pill px-4 fs-7 fw-semibold">
                                <i class="bi bi-filter me-1"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('portal.search') }}" class="btn btn-outline-secondary rounded-pill px-3 fs-7">
                                <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Filter
                            </a>
                        </div>

                        <!-- Sorting -->
                        <div class="d-flex align-items-center gap-2">
                            <label class="fs-8 text-muted fw-semibold mb-0">Urutkan:</label>
                            <select name="urutkan" class="form-select form-select-sm fs-8 w-auto rounded-pill" onchange="this.form.submit()">
                                <option value="terbaru" {{ request('urutkan') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ request('urutkan') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="populer" {{ request('urutkan') == 'populer' ? 'selected' : '' }}>Paling Sering Dilihat</option>
                                <option value="unduhan" {{ request('urutkan') == 'unduhan' ? 'selected' : '' }}>Paling Banyak Diunduh</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>

            <!-- Documents Results List -->
            <div class="d-flex flex-column gap-3">
                @forelse($documents as $doc)
                    <div class="doc-item-card">
                        <div class="row align-items-center">
                            
                            <!-- Document Info -->
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
                                            Nomor: <strong>{{ $doc->nomor }}</strong> Tahun <strong>{{ $doc->tahun }}</strong>
                                        </span>
                                        @if($doc->tanggal_ditetapkan)
                                            <span class="text-muted fs-8">
                                                &bull; Ditetapkan: {{ $doc->tanggal_ditetapkan->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <h5 class="fw-bold mb-1">
                                        <a href="{{ route('portal.document.show', $doc->id) }}" class="text-dark text-decoration-none hover-text-primary">
                                            {{ $doc->judul }}
                                        </a>
                                    </h5>

                                    <p class="text-muted fs-8 mb-2">
                                        <strong>Tentang:</strong> {{ Str::limit($doc->abstrak ?: $doc->judul, 160) }}
                                    </p>

                                    <div class="d-flex align-items-center gap-3 text-muted fs-8 flex-wrap">
                                        <span class="badge-status status-{{ Str::slug($doc->status) }}">
                                            {{ $doc->status }}
                                        </span>
                                        <span><i class="bi bi-file-earmark"></i> {{ $doc->file_size ?: '2.4 MB' }}</span>
                                        <span><i class="bi bi-eye"></i> Dilihat: <strong>{{ number_format($doc->hits) }}</strong> kali</span>
                                        <span><i class="bi bi-cloud-arrow-down"></i> Diunduh: <strong>{{ number_format($doc->downloads) }}</strong> kali</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Document Actions -->
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
                    <div class="text-center py-5 bg-white rounded-3 border">
                        <i class="bi bi-search fs-1 text-muted d-block mb-3"></i>
                        <h5 class="fw-bold text-dark">Tidak ada dokumen yang sesuai dengan kriteria pencarian</h5>
                        <p class="text-muted fs-7">Coba ubah kata kunci pencarian atau sesuaikan filter kategori dan tahun.</p>
                        <a href="{{ route('portal.search') }}" class="btn btn-primary rounded-pill px-4">
                            Lihat Semua Dokumen
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $documents->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

@endsection
