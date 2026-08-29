@extends('layouts.portal')

@section('title', 'Video Kegiatan & Dokumentasi - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Video Kegiatan</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Video Kegiatan &amp; Sidang DPRD</h3>
        </div>
    </section>

    <!-- Video Grid Section -->
    <section class="py-5">
        <div class="container">
            
            <div class="row g-4">
                @forelse($videos as $video)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 bg-white hover-lift">
                            <div class="ratio ratio-16x9">
                                @if($video->video_url)
                                    <iframe src="{{ $video->video_url }}" title="{{ $video->judul }}" allowfullscreen></iframe>
                                @else
                                    <div class="bg-dark text-white d-flex align-items-center justify-content-center">
                                        <i class="bi bi-play-circle fs-1 text-warning"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body p-3">
                                <h6 class="fw-bold text-dark mb-1">{{ $video->judul }}</h6>
                                <p class="text-muted fs-8 mb-0">{{ Str::limit($video->keterangan, 90) }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 bg-white rounded-3 border">
                        <i class="bi bi-camera-video-off fs-1 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold">Belum ada video kegiatan</h6>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $videos->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

@endsection
