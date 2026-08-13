@extends('layouts.admin')

@section('title', 'Dashboard - JDIH DPRD Bolmut')
@section('page_title', 'Dashboard')

@section('content')
    <!-- Metrics Grid -->
    <div class="row g-4 mb-5">
        <!-- Total Documents -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Total Dokumen</span>
                        <h3 class="fw-bold text-dark m-0">{{ $totalDokumen }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-file-earmark-pdf fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total News -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Berita Hukum</span>
                        <h3 class="fw-bold text-dark m-0">{{ $totalBerita }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-newspaper fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Hits -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Total Unduh / Kunjungan</span>
                        <h3 class="fw-bold text-dark m-0">{{ $totalHits }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-eye fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="col-lg-3 col-md-6">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Kategori Dokumen</span>
                        <h3 class="fw-bold text-dark m-0">{{ $totalKategori }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-tags fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Documents -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold text-dark m-0"><i class="bi bi-clock-history me-1"></i> Upload Terbaru</h5>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Semua Dokumen</a>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr class="text-muted fs-7">
                                <th>Jenis</th>
                                <th>No / Tahun</th>
                                <th>Judul</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDokumens as $doc)
                                <tr class="fs-7.5">
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-semibold">
                                            {{ $doc->jenisDokumen->kode }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $doc->nomor }} / {{ $doc->tahun }}</td>
                                    <td>{{ Str::limit($doc->judul, 70) }}</td>
                                    <td>
                                        <span class="badge-status status-{{ Str::slug($doc->status) }} fs-8">
                                            {{ $doc->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada dokumen yang diupload.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Category Distributions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 bg-white">
                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-pie-chart me-1"></i> Distribusi Kategori</h5>
                
                <div class="d-flex flex-column gap-3">
                    @foreach($dokumenPerKategori as $cat)
                        <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px; font-weight: bold; font-size: 0.85rem;">
                                    {{ $cat->kode }}
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark m-0">{{ $cat->nama }}</h6>
                                    <small class="text-muted">Kode: {{ $cat->kode }}</small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold">
                                {{ $cat->dokumen_hukums_count }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
