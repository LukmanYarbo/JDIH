@extends('layouts.portal')

@section('title', 'Berita & Kegiatan Hukum - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <h2 class="fw-bold m-0"><i class="bi bi-newspaper me-2"></i> Berita &amp; Kegiatan</h2>
            <p class="text-white-50 m-0 fs-7">Info terbaru mengenai kegiatan legislatif dan sosialisasi produk hukum</p>
        </div>
    </section>

    <!-- News Grid & Search -->
    <section class="py-5">
        <div class="container">
            <!-- Search & Filters -->
            <div class="row justify-content-end mb-5">
                <div class="col-md-5">
                    <form action="{{ route('portal.news.list') }}" method="GET" class="input-group shadow-sm rounded-pill overflow-hidden">
                        <input type="text" name="q" class="form-control border-0 ps-4 py-2.5" placeholder="Cari berita..." value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <!-- News Grid -->
            <div class="row g-4">
                @forelse($news as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm overflow-hidden hover-lift h-100 d-flex flex-column">
                            @if($item->gambar)
                                <img src="{{ asset($item->gambar) }}" class="card-img-top" alt="{{ $item->judul }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-newspaper text-primary display-4"></i>
                                </div>
                            @endif
                            <div class="card-body p-4 d-flex flex-column flex-grow-1">
                                <div class="text-muted fs-8 mb-2">
                                    <i class="bi bi-calendar3 me-1"></i> {{ $item->created_at->format('d M Y') }}
                                    <span class="mx-2">|</span>
                                    <i class="bi bi-person me-1"></i> {{ $item->user->name }}
                                </div>
                                <h5 class="fw-bold text-dark mb-2">
                                    <a href="{{ route('portal.news.show', $item->slug) }}" class="text-dark text-decoration-none hover-text-primary">
                                        {{ Str::limit($item->judul, 70) }}
                                    </a>
                                </h5>
                                <p class="text-muted fs-7 mb-4 flex-grow-1">
                                    {{ Str::limit(strip_tags($item->konten), 120) }}
                                </p>
                                <a href="{{ route('portal.news.show', $item->slug) }}" class="text-primary fw-semibold fs-7 text-decoration-none mt-auto">
                                    Baca Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-newspaper display-3 d-block mb-3 text-secondary"></i>
                        <h5>Belum Ada Berita Diterbitkan</h5>
                        <p class="fs-7 m-0">Silakan kembali lagi nanti untuk info teranyar.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-5">
                {!! $news->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </section>
@endsection
