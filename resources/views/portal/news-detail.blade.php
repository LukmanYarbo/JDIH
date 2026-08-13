@extends('layouts.portal')

@section('title', $news->judul . ' - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <div class="d-flex align-items-center gap-2 mb-2">
                <a href="{{ route('portal.news.list') }}" class="text-white-50 text-decoration-none fs-7"><i class="bi bi-arrow-left"></i> Kembali ke Berita</a>
            </div>
            <h3 class="fw-bold m-0">{{ Str::limit($news->judul, 100) }}</h3>
        </div>
    </section>

    <!-- News Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                
                <!-- Main News Column -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                        <div class="d-flex align-items-center gap-3 text-muted fs-8 mb-4">
                            <span><i class="bi bi-calendar3 me-1 text-primary"></i> {{ $news->created_at->format('d F Y') }}</span>
                            <span>|</span>
                            <span><i class="bi bi-person me-1 text-primary"></i> Diposting oleh {{ $news->user->name }}</span>
                        </div>
                        
                        <!-- Post Featured Image -->
                        @if($news->gambar)
                            <div class="mb-4 overflow-hidden rounded-3 border">
                                <img src="{{ asset($news->gambar) }}" alt="{{ $news->judul }}" class="w-100" style="max-height: 450px; object-fit: cover;">
                            </div>
                        @endif

                        <!-- Post content -->
                        <div class="news-content fs-6 text-dark lh-lg">
                            {!! nl2br(e($news->konten)) !!}
                        </div>
                    </div>
                </div>

                <!-- Recent News Sidebar -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 90px; z-index: 10;">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-newspaper me-1"></i> Berita Terbaru</h5>
                        
                        <div class="d-flex flex-column gap-3">
                            @forelse($recentNews as $rn)
                                <div class="d-flex align-items-center gap-3 pb-3 border-bottom">
                                    @if($rn->gambar)
                                        <img src="{{ asset($rn->gambar) }}" alt="{{ $rn->judul }}" class="rounded-2" style="width: 70px; height: 70px; object-fit: cover;">
                                    @else
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                            <i class="bi bi-newspaper fs-4"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <small class="text-muted fs-8 d-block mb-1">{{ $rn->created_at->format('d M Y') }}</small>
                                        <h6 class="fw-bold fs-7 m-0">
                                            <a href="{{ route('portal.news.show', $rn->slug) }}" class="text-dark text-decoration-none">
                                                {{ Str::limit($rn->judul, 50) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted fs-7">Belum ada berita lainnya.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
