@extends('layouts.portal')

@section('title', 'Buletin Hukum & Majalah JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Buletin JDIH</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Buletin &amp; Rangkuman Hukum JDIH</h3>
        </div>
    </section>

    <!-- Buletin Catalog -->
    <section class="py-5">
        <div class="container">
            
            <!-- Filter Bar -->
            <div class="card border-0 shadow-sm p-3 rounded-3 mb-4 bg-white">
                <form action="{{ route('portal.buletin') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-9">
                        <h6 class="fw-bold text-primary mb-0">Edisi Berkala &amp; Publikasi Majalah Hukum JDIH</h6>
                    </div>
                    <div class="col-md-3">
                        <select name="tahun" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">.:: Semua Tahun ::.</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

            <!-- Buletin Grid Cards -->
            <div class="row g-4">
                @forelse($buletins as $buletin)
                    <div class="col-lg-3 col-md-6">
                        <div class="card border-0 shadow-sm h-100 rounded-3 overflow-hidden hover-lift bg-white">
                            <!-- Cover Mockup -->
                            <div class="p-4 text-center text-white d-flex flex-column justify-content-between" style="height: 220px; background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); border-bottom: 3px solid #f59e0b;">
                                <div>
                                    <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill fs-9">
                                        {{ $buletin->edisi }}
                                    </span>
                                </div>
                                <div class="my-auto">
                                    <i class="bi bi-book-half fs-1 text-warning"></i>
                                    <div class="fw-bold fs-7 mt-2 text-white">{{ $buletin->edisi }}</div>
                                </div>
                                <small class="text-white-50 font-monospace fs-9">Tahun {{ $buletin->tahun }}</small>
                            </div>

                            <div class="card-body p-3 d-flex flex-column">
                                <h6 class="fw-bold mb-2 text-dark">
                                    {{ $buletin->judul }}
                                </h6>
                                <p class="text-muted fs-8 mb-3 flex-grow-1">
                                    {{ Str::limit($buletin->deskripsi, 100) }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between border-top pt-2 mt-auto fs-8">
                                    <span class="text-muted"><i class="bi bi-download"></i> {{ number_format($buletin->downloads) }}</span>
                                    <a href="{{ route('portal.buletin.download', $buletin->id) }}" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold">
                                        <i class="bi bi-cloud-arrow-down me-1"></i> Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-white rounded-3 border">
                        <i class="bi bi-journal-album fs-1 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold">Belum ada buletin yang dipublikasikan</h6>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $buletins->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

@endsection
