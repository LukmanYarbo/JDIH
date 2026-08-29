@extends('layouts.portal')

@section('title', 'Alur Ranperda & Program Pembentukan Perda (Propemperda) - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Alur Ranperda &amp; Propemperda</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Alur Pembentukan &amp; Program Pembentukan Perda (Propemperda)</h3>
        </div>
    </section>

    <!-- 7 Tahapan Visual Workflow Banner -->
    <section class="py-4 bg-white border-bottom shadow-sm">
        <div class="container">
            <h5 class="fw-bold text-primary mb-3 text-center">Tahapan Alur Pembentukan Peraturan Daerah</h5>
            <div class="row row-cols-2 row-cols-md-4 row-cols-lg-7 g-2 text-center">
                @foreach($tahapanLabels as $stepNum => $stepLabel)
                    <div class="col">
                        <div class="p-3 bg-light rounded-3 h-100 border position-relative hover-lift">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 fw-bold" style="width:32px; height:32px; font-size:0.85rem;">
                                {{ $stepNum }}
                            </div>
                            <div class="fw-semibold fs-8 text-dark lh-sm">{{ $stepLabel }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Propemperda List & Tracking Table -->
    <section class="py-5">
        <div class="container">
            
            <!-- Filter Bar -->
            <div class="card border-0 shadow-sm p-3 rounded-3 mb-4 bg-white">
                <form action="{{ route('portal.ranperda') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control bg-light border-start-0 fs-7" placeholder="Cari judul rancangan peraturan daerah...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="tahun" class="form-select fs-7" onchange="this.form.submit()">
                            <option value="">.:: Semua Tahun Propemperda ::.</option>
                            @foreach($years as $yr)
                                <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>Propemperda Tahun {{ $yr }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary rounded-pill w-100 fs-7 fw-semibold">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- List of Ranperdas with Visual Stepper -->
            <div class="d-flex flex-column gap-4">
                @forelse($ranperdas as $ranperda)
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white hover-lift">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                            <div>
                                <span class="badge bg-warning text-dark fw-bold px-3 py-1 rounded-pill fs-8">
                                    Propemperda {{ $ranperda->tahun }}
                                </span>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 rounded-pill fs-8 ms-1">
                                    Pemrakarsa: {{ $ranperda->pemrakarsa }}
                                </span>
                                <h5 class="fw-bold text-dark mt-2 mb-1">{{ $ranperda->judul }}</h5>
                                <small class="text-muted">Nomor Registrasi: <strong>{{ $ranperda->nomor_propemperda ?: '-' }}</strong></small>
                            </div>
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1 rounded-pill fs-8 fw-semibold">
                                    Status: {{ $ranperda->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar & Stepper -->
                        <div class="my-3">
                            <div class="d-flex justify-content-between align-items-center mb-1 fs-8">
                                <span class="text-muted fw-semibold">Tahapan Saat Ini: <strong class="text-primary">{{ $ranperda->tahapan_name }}</strong></span>
                                <span class="text-muted font-monospace">Tahap {{ $ranperda->tahap_terakhir }} dari 7</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                @php
                                    $progressPercent = ($ranperda->tahap_terakhir / 7) * 100;
                                @endphp
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: {{ $progressPercent }}%" aria-valuenow="{{ $progressPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <!-- Jadwal Pembahasan & Penetapan Info -->
                        @if($ranperda->tanggal_mulai_pembahasan || $ranperda->tanggal_penetapan)
                            <div class="d-flex align-items-center gap-3 flex-wrap fs-8 py-2 border-top border-bottom my-2 text-muted">
                                @if($ranperda->tanggal_mulai_pembahasan)
                                    <div>
                                        <i class="bi bi-calendar-event text-primary me-1"></i>
                                        Jadwal Pembahasan: <strong>{{ $ranperda->tanggal_mulai_pembahasan->format('d F Y') }}</strong>
                                        @if($ranperda->tanggal_akhir_pembahasan)
                                            s.d <strong>{{ $ranperda->tanggal_akhir_pembahasan->format('d F Y') }}</strong>
                                        @endif
                                    </div>
                                @endif
                                @if($ranperda->tanggal_penetapan)
                                    <div>
                                        <i class="bi bi-award-fill text-success me-1"></i>
                                        Tanggal Penetapan: <strong class="text-success">{{ $ranperda->tanggal_penetapan->format('d F Y') }}</strong>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Description & Stage Details -->
                        @if($ranperda->keterangan)
                            <div class="bg-light p-3 rounded-2 fs-8 text-muted mt-2">
                                <i class="bi bi-info-circle-fill text-primary me-1"></i> {{ $ranperda->keterangan }}
                            </div>
                        @endif

                        <!-- Download Attachments if any -->
                        @if($ranperda->file_naskah_akademik || $ranperda->file_rancangan || $ranperda->file_evaluasi)
                            <div class="d-flex gap-2 mt-3 pt-2 border-top flex-wrap">
                                @if($ranperda->file_naskah_akademik)
                                    <a href="{{ asset($ranperda->file_naskah_akademik) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill fs-8">
                                        <i class="bi bi-file-earmark-pdf me-1"></i> Naskah Akademik
                                    </a>
                                @endif
                                @if($ranperda->file_rancangan)
                                    <a href="{{ asset($ranperda->file_rancangan) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill fs-8">
                                        <i class="bi bi-file-earmark-text me-1"></i> Draf Ranperda
                                    </a>
                                @endif
                                @if($ranperda->file_evaluasi)
                                    <a href="{{ asset($ranperda->file_evaluasi) }}" target="_blank" class="btn btn-sm btn-outline-warning rounded-pill fs-8">
                                        <i class="bi bi-check2-circle me-1"></i> Hasil Fasilitasi / Evaluasi
                                    </a>
                                @endif
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="text-center py-5 bg-white rounded-3 border">
                        <i class="bi bi-file-earmark-code fs-1 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold">Belum ada data Propemperda yang terdaftar</h6>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $ranperdas->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </section>

@endsection
