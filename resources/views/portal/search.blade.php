@extends('layouts.portal')

@section('title', 'Pencarian Produk Hukum - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <h2 class="fw-bold m-0"><i class="bi bi-search me-2"></i> Pencarian Produk Hukum</h2>
            <p class="text-white-50 m-0 fs-7">Gunakan filter untuk mempersempit hasil pencarian dokumen legislatif</p>
        </div>
    </section>

    <!-- Content & Filter Sidebar -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Filter Sidebar -->
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 90px; z-index: 10;">
                        <h5 class="fw-bold mb-3 text-primary"><i class="bi bi-filter-left me-1"></i> Filter Pencarian</h5>
                        
                        <form action="{{ route('portal.search') }}" method="GET" class="d-flex flex-column gap-3">
                            <!-- Keyword Input -->
                            <div>
                                <label class="form-label fs-7 fw-semibold text-muted">Kata Kunci</label>
                                <input type="text" name="q" class="form-control" placeholder="Nomor, Tahun, Judul..." value="{{ request('q') }}">
                            </div>

                            <!-- Jenis Dokumen Select -->
                            <div>
                                <label class="form-label fs-7 fw-semibold text-muted">Jenis Dokumen</label>
                                <select name="jenis_dokumen_id" class="form-select">
                                    <option value="">Semua Jenis</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ request('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Tahun Select -->
                            <div>
                                <label class="form-label fs-7 fw-semibold text-muted">Tahun</label>
                                <select name="tahun" class="form-select">
                                    <option value="">Semua Tahun</option>
                                    @foreach($years as $yr)
                                        <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>
                                            {{ $yr }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Select -->
                            <div>
                                <label class="form-label fs-7 fw-semibold text-muted">Status</label>
                                <select name="status" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="Berlaku" {{ request('status') == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                                    <option value="Tidak Berlaku" {{ request('status') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                                    <option value="Diubah" {{ request('status') == 'Diubah' ? 'selected' : '' }}>Diubah</option>
                                    <option value="Mencabut" {{ request('status') == 'Mencabut' ? 'selected' : '' }}>Mencabut</option>
                                </select>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2 pt-2">
                                <button type="submit" class="btn btn-primary rounded-pill fw-semibold">
                                    Terapkan Filter
                                </button>
                                <a href="{{ route('portal.search') }}" class="btn btn-outline-secondary rounded-pill fw-semibold">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Document Results List -->
                <div class="col-lg-9">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <span class="text-muted fs-7">
                            Menampilkan <strong>{{ $documents->firstItem() ?? 0 }} - {{ $documents->lastItem() ?? 0 }}</strong> dari <strong>{{ $documents->total() }}</strong> dokumen ditemukan
                        </span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse($documents as $doc)
                            <div class="card border-0 shadow-sm p-4 hover-lift">
                                <div class="row align-items-start">
                                    <div class="col-md-9">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 fs-8 fw-semibold">
                                                {{ $doc->jenisDokumen->nama }}
                                            </span>
                                            <span class="text-muted fs-8">
                                                Nomor {{ $doc->nomor }} Tahun {{ $doc->tahun }}
                                            </span>
                                        </div>
                                        <h5 class="fw-bold mb-2">
                                            <a href="{{ route('portal.document.show', $doc->id) }}" class="text-dark text-decoration-none hover-text-primary">
                                                {{ $doc->judul }}
                                            </a>
                                        </h5>
                                        <p class="text-muted fs-7 mb-0">
                                            {{ Str::limit($doc->abstrak, 220) }}
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
                            <div class="card border-0 shadow-sm p-5 text-center text-muted">
                                <i class="bi bi-file-earmark-x display-3 mb-3 text-secondary"></i>
                                <h5 class="fw-bold">Dokumen Tidak Ditemukan</h5>
                                <p class="fs-7 m-0">Cobalah kata kunci yang lain atau reset filter pencarian Anda.</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-5">
                        {!! $documents->withQueryString()->links('pagination::bootstrap-5') !!}
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
