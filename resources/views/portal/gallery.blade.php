@extends('layouts.portal')

@section('title', 'Galeri Foto & Video - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <h2 class="fw-bold m-0"><i class="bi bi-images me-2"></i> Galeri Dokumentasi</h2>
            <p class="text-white-50 m-0 fs-7">Galeri foto kegiatan legislatif dan dokumentasi video Rapat Paripurna DPRD</p>
        </div>
    </section>

    <!-- Gallery Grid & Filter -->
    <section class="py-5">
        <div class="container">
            <!-- Filter Controls -->
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-5">
                <!-- Filter Tabs -->
                <div class="d-flex gap-2 bg-white p-1.5 rounded-pill shadow-sm border" style="width: fit-content;">
                    <a href="{{ route('portal.gallery') }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ !request('type') ? 'btn-primary text-white' : 'btn-light text-muted' }}">Semua</a>
                    <a href="{{ route('portal.gallery', ['type' => 'foto']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ request('type') == 'foto' ? 'btn-primary text-white' : 'btn-light text-muted' }}">Foto</a>
                    <a href="{{ route('portal.gallery', ['type' => 'video']) }}" class="btn btn-sm rounded-pill px-3 py-2 fw-semibold {{ request('type') == 'video' ? 'btn-primary text-white' : 'btn-light text-muted' }}">Video</a>
                </div>
                
                <!-- Search Input -->
                <div style="max-width: 380px; width: 100%;">
                    <form action="{{ route('portal.gallery') }}" method="GET" class="input-group shadow-sm rounded-pill overflow-hidden border">
                        @if(request('type'))
                            <input type="hidden" name="type" value="{{ request('type') }}">
                        @endif
                        <input type="text" name="q" class="form-control border-0 ps-4 py-2" placeholder="Cari galeri..." value="{{ request('q') }}">
                        <button type="submit" class="btn btn-primary px-3 border-0"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <!-- Grid -->
            <div class="row g-4">
                @forelse($items as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card border-0 shadow-sm overflow-hidden hover-lift h-100 d-flex flex-column">
                            @if($item->tipe === 'foto')
                                <div class="position-relative overflow-hidden cursor-pointer" onclick="openPhotoModal('{{ asset($item->file_path) }}', '{{ addslashes($item->judul) }}', '{{ addslashes($item->keterangan) }}')">
                                    <img src="{{ asset($item->file_path) }}" alt="{{ $item->judul }}" class="w-100" style="height: 240px; object-fit: cover;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-20 d-flex align-items-center justify-content-center opacity-0 hover-opacity-100 transition-smooth">
                                        <i class="bi bi-zoom-in text-white display-6"></i>
                                    </div>
                                    <span class="position-absolute top-3 start-3 badge bg-primary rounded-pill px-3 fs-8 fw-semibold">
                                        <i class="bi bi-camera me-1"></i> Foto
                                    </span>
                                </div>
                            @else
                                <div class="position-relative overflow-hidden cursor-pointer" onclick="openVideoModal('{{ $item->video_url }}', '{{ addslashes($item->judul) }}')">
                                    <!-- Video card thumbnail background -->
                                    <div class="bg-dark bg-opacity-95 d-flex align-items-center justify-content-center" style="height: 240px;">
                                        <i class="bi bi-play-circle-fill text-warning display-4"></i>
                                    </div>
                                    <span class="position-absolute top-3 start-3 badge bg-success rounded-pill px-3 fs-8 fw-semibold">
                                        <i class="bi bi-play-btn me-1"></i> Video
                                    </span>
                                </div>
                            @endif

                            <div class="card-body p-4 flex-grow-1 d-flex flex-column">
                                <h5 class="fw-bold text-dark mb-2">{{ $item->judul }}</h5>
                                <p class="text-muted fs-7 mb-0 flex-grow-1">{{ $item->keterangan }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        <i class="bi bi-images display-3 d-block mb-3 text-secondary"></i>
                        <h5>Galeri Belum Ada</h5>
                        <p class="fs-7 m-0">Silakan kembali lagi nanti untuk dokumentasi kegiatan legislatif DPRD Bolmut.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {!! $items->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </section>

    <!-- Photo Lightbox Modal -->
    <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 glass-card">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <img src="" id="photoModalImg" class="img-fluid rounded border mb-3" style="max-height: 500px;">
                    <h5 class="fw-bold text-dark text-start" id="photoModalTitle"></h5>
                    <p class="text-muted fs-7 text-start mb-0" id="photoModalDesc"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Player Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 bg-dark text-white">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="ratio ratio-16x9 rounded overflow-hidden mb-3">
                        <iframe src="" id="videoModalFrame" frameborder="0" allowfullscreen allow="autoplay"></iframe>
                    </div>
                    <h5 class="fw-bold text-start" id="videoModalTitle"></h5>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
        const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));

        function openPhotoModal(src, title, desc) {
            document.getElementById('photoModalImg').src = src;
            document.getElementById('photoModalTitle').innerText = title;
            document.getElementById('photoModalDesc').innerText = desc || '';
            photoModal.show();
        }

        function openVideoModal(url, title) {
            document.getElementById('videoModalFrame').src = url + "?autoplay=1";
            document.getElementById('videoModalTitle').innerText = title;
            videoModal.show();
        }

        // Clear video src on modal close to stop playback
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function () {
            document.getElementById('videoModalFrame').src = '';
        });
    </script>
    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .transition-smooth {
            transition: all 0.3s ease;
        }
        .hover-opacity-100:hover {
            opacity: 1 !important;
        }
    </style>
@endsection
