@extends('layouts.portal')

@section('title', 'Agenda Kegiatan DPRD - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Agenda DPRD</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Jadwal &amp; Agenda Kegiatan DPRD</h3>
        </div>
    </section>

    <!-- Agenda List Section -->
    <section class="py-5">
        <div class="container">
            
            <div class="d-flex flex-column gap-3">
                @forelse($agendas as $agenda)
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white hover-lift">
                        <div class="row align-items-center">
                            
                            <!-- Date Badge Column -->
                            <div class="col-md-3 text-center border-end-md pb-3 pb-md-0">
                                <div class="bg-primary text-white p-3 rounded-3 d-inline-block text-center shadow-sm" style="min-width: 140px;">
                                    <div class="fs-9 text-uppercase text-warning fw-bold">{{ $agenda->waktu_mulai->format('l') }}</div>
                                    <div class="fs-2 fw-bold font-monospace lh-1 my-1">{{ $agenda->waktu_mulai->format('d') }}</div>
                                    <div class="fs-8 text-uppercase">{{ $agenda->waktu_mulai->format('M Y') }}</div>
                                    <div class="fs-8 text-white-50 mt-1"><i class="bi bi-clock"></i> {{ $agenda->waktu_mulai->format('H:i') }} WIB</div>
                                </div>
                            </div>

                            <!-- Agenda Details Column -->
                            <div class="col-md-9 ps-md-4">
                                <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                    <span class="badge bg-warning text-dark fw-bold px-2.5 py-1.5 fs-8 rounded-pill">
                                        <i class="bi bi-people-fill me-1"></i>
                                        @if($agenda->mitra_kerja)
                                            {{ $agenda->pelaksana ?: 'DPRD' }} &amp; {{ $agenda->mitra_kerja }}
                                        @else
                                            {{ $agenda->pelaksana ?: 'DPRD' }}
                                        @endif
                                    </span>
                                    <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 fs-8 rounded-pill fw-semibold">
                                        {{ $agenda->status }}
                                    </span>
                                </div>

                                <h5 class="fw-bold text-dark mb-2">{{ $agenda->judul }}</h5>

                                <p class="text-muted fs-8 mb-2">
                                    {{ $agenda->deskripsi }}
                                </p>

                                <div class="text-muted fs-8">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> Lokasi: <strong>{{ $agenda->lokasi ?: 'Gedung DPRD' }}</strong>
                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-3 border">
                        <i class="bi bi-calendar-x fs-1 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold">Belum ada agenda rapat yang dijadwalkan</h6>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $agendas->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

@endsection
