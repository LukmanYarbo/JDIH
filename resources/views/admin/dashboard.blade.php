@extends('layouts.admin')

@section('title', 'Dashboard - JDIH DPRD Kabupaten Bolaang Mongondow Utara')
@section('page_title', 'Dashboard Administrasi')

@section('styles')
<style>
    /* Modern Dashboard Custom Styles */
    .dashboard-hero {
        background: linear-gradient(135deg, #071e36 0%, #0d3b66 60%, #1e5285 100%);
        border-radius: 1.25rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(13, 59, 102, 0.2);
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 240px;
        height: 240px;
        background: radial-gradient(circle, rgba(244, 211, 94, 0.25) 0%, rgba(244, 211, 94, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-hero::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 20%;
        width: 180px;
        height: 180px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .metric-card {
        border-radius: 1.15rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid var(--border-color);
        background-color: var(--bg-card);
        position: relative;
        overflow: hidden;
    }

    .metric-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(13, 59, 102, 0.2);
    }

    .metric-icon-box {
        width: 54px;
        height: 54px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .quick-stat-pill {
        border-radius: 12px;
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        padding: 12px 18px;
        transition: all 0.25s ease;
    }

    .quick-stat-pill:hover {
        transform: translateY(-2px);
        border-color: var(--primary-light);
    }

    .chart-card {
        border-radius: 1.15rem;
        border: 1px solid var(--border-color);
        background-color: var(--bg-card);
    }

    /* Activity Feed Styles */
    .activity-feed {
        position: relative;
        padding-left: 24px;
    }

    .activity-feed::before {
        content: '';
        position: absolute;
        top: 8px;
        bottom: 8px;
        left: 8px;
        width: 2px;
        background: var(--border-color);
    }

    .activity-item {
        position: relative;
        margin-bottom: 18px;
    }

    .activity-item:last-child {
        margin-bottom: 0;
    }

    .activity-point {
        position: absolute;
        left: -24px;
        top: 4px;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: var(--bg-card);
        border: 2px solid var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .activity-point::after {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--primary-light);
    }

    /* Soft status badges */
    .badge-soft-success {
        background-color: rgba(16, 185, 129, 0.12) !important;
        color: #059669 !important;
    }

    .badge-soft-danger {
        background-color: rgba(239, 68, 68, 0.12) !important;
        color: #dc2626 !important;
    }

    .badge-soft-warning {
        background-color: rgba(245, 158, 11, 0.12) !important;
        color: #d97706 !important;
    }

    .badge-soft-primary {
        background-color: rgba(13, 59, 102, 0.12) !important;
        color: #0d3b66 !important;
    }

    .badge-soft-info {
        background-color: rgba(2, 132, 199, 0.12) !important;
        color: #0284c7 !important;
    }
</style>
@endsection

@section('content')
    @php
        $hour = (int) now()->format('H');
        if ($hour < 11) {
            $greeting = 'Selamat Pagi';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
        } elseif ($hour < 19) {
            $greeting = 'Selamat Sore';
        } else {
            $greeting = 'Selamat Malam';
        }
    @endphp

    <!-- 1. Hero / Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 text-white">
        <div class="row align-items-center position-relative" style="z-index: 2;">
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                    <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1.5 fs-8">
                        <i class="bi bi-calendar3 me-1"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="badge bg-success bg-opacity-25 text-white border border-success border-opacity-50 rounded-pill px-3 py-1.5 fs-8">
                        <i class="bi bi-shield-check me-1"></i> Keamanan Sesi Aktif (30m)
                    </span>
                </div>
                <h2 class="fw-bold mb-2">
                    {{ $greeting }}, {{ auth()->user()->name }}!
                </h2>
                <p class="text-white-50 m-0 fs-6" style="max-width: 580px;">
                    Selamat datang di Panel Kontrol JDIH DPRD Kabupaten Bolaang Mongondow Utara. Pantau integrasi regulasi hukum, publikasi kegiatan, dan statistik akses secara realtime.
                </p>
            </div>

            <div class="col-lg-5">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.documents.create') }}" class="btn btn-warning text-dark fw-bold rounded-pill px-3.5 py-2 shadow-sm d-inline-flex align-items-center">
                        <i class="bi bi-plus-circle-fill me-1.5 fs-6"></i> Upload Dokumen
                    </a>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-light text-dark fw-semibold rounded-pill px-3.5 py-2 shadow-sm d-inline-flex align-items-center">
                        <i class="bi bi-pencil-square me-1.5 fs-6 text-primary"></i> Tulis Berita
                    </a>
                    <a href="{{ route('admin.agendas.create') }}" class="btn btn-outline-light rounded-pill px-3.5 py-2 d-inline-flex align-items-center">
                        <i class="bi bi-calendar-plus me-1.5 fs-6"></i> Buat Agenda
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. Primary Metrics Cards (4 Core Stats) -->
    <div class="row g-4 mb-4">
        <!-- Metric 1: Dokumen Hukum -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm p-4 h-100">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Total Dokumen Hukum</span>
                        <h3 class="fw-bold text-dark m-0">{{ number_format($totalDokumen) }}</h3>
                    </div>
                    <div class="metric-icon-box text-white" style="background: linear-gradient(135deg, #0d3b66 0%, #1e5285 100%);">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                    <span class="fs-8 badge-soft-success rounded-pill px-2.5 py-1 fw-bold">
                        <i class="bi bi-check-circle-fill me-1"></i> {{ number_format($dokumenBerlaku) }} Berlaku
                    </span>
                    <a href="{{ route('admin.documents.index') }}" class="text-primary text-decoration-none fs-8 fw-semibold">
                        Kelola <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric 2: Interaksi Pembaca & Unduh -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm p-4 h-100">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Total Kunjungan / Hits</span>
                        <h3 class="fw-bold text-dark m-0">{{ number_format($totalHits) }}</h3>
                    </div>
                    <div class="metric-icon-box text-white" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                    <span class="fs-8 badge-soft-info rounded-pill px-2.5 py-1 fw-bold">
                        <i class="bi bi-download me-1"></i> {{ number_format($totalDownloads) }} Unduhan File
                    </span>
                    <span class="text-muted fs-8">Total Interaksi</span>
                </div>
            </div>
        </div>

        <!-- Metric 3: Berita & Publikasi -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm p-4 h-100">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Berita Kegiatan Hukum</span>
                        <h3 class="fw-bold text-dark m-0">{{ number_format($totalBerita) }}</h3>
                    </div>
                    <div class="metric-icon-box text-white" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                        <i class="bi bi-newspaper"></i>
                    </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                    <span class="fs-8 badge-soft-success rounded-pill px-2.5 py-1 fw-bold">
                        <i class="bi bi-calendar-event me-1"></i> {{ $totalAgenda }} Agenda DPRD
                    </span>
                    <a href="{{ route('admin.news.index') }}" class="text-success text-decoration-none fs-8 fw-semibold">
                        Semua Berita <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric 4: Kategori & Regulasi -->
        <div class="col-xl-3 col-md-6">
            <div class="card metric-card shadow-sm p-4 h-100">
                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <span class="text-muted fs-7 fw-semibold d-block mb-1">Kategori Produk Hukum</span>
                        <h3 class="fw-bold text-dark m-0">{{ number_format($totalKategori) }}</h3>
                    </div>
                    <div class="metric-icon-box text-white" style="background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
                <div class="pt-2 border-top d-flex align-items-center justify-content-between">
                    <span class="fs-8 badge-soft-warning rounded-pill px-2.5 py-1 fw-bold">
                        <i class="bi bi-file-earmark-code me-1"></i> {{ $totalRanperda }} Ranperda
                    </span>
                    <a href="{{ route('admin.categories.index') }}" class="text-warning text-decoration-none fs-8 fw-semibold">
                        Lihat Kategori <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Secondary Quick Stats Strip -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="quick-stat-pill d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-calendar-check fs-6"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block lh-1 mb-1 fs-8">Agenda DPRD</small>
                        <span class="fw-bold text-dark fs-6">{{ $totalAgenda }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.agendas.index') }}" class="btn btn-sm btn-link text-muted p-0" title="Buka Agenda">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="quick-stat-pill d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-journal-bookmark fs-6"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block lh-1 mb-1 fs-8">Alur Propemperda</small>
                        <span class="fw-bold text-dark fs-6">{{ $totalRanperda }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.ranperda.index') }}" class="btn btn-sm btn-link text-muted p-0" title="Buka Ranperda">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="quick-stat-pill d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-people fs-6"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block lh-1 mb-1 fs-8">Anggota DPRD</small>
                        <span class="fw-bold text-dark fs-6">{{ $totalAnggota }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.anggota.index') }}" class="btn btn-sm btn-link text-muted p-0" title="Buka Anggota">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="quick-stat-pill d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 text-info rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-person-lock fs-6"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block lh-1 mb-1 fs-8">Pengelola Sistem</small>
                        <span class="fw-bold text-dark fs-6">{{ $totalUsers }} User</span>
                    </div>
                </div>
                @if(auth()->user()->hasRole('Admin'))
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link text-muted p-0" title="Kelola User">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- 4. Interactive Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Chart 1: Tren Publikasi 6 Bulan Terakhir -->
        <div class="col-lg-8">
            <div class="card chart-card shadow-sm p-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold text-dark m-0">
                            <i class="bi bi-graph-up text-primary me-2"></i>Tren Publikasi Dokumen
                        </h5>
                        <small class="text-muted">Statistik jumlah dokumen hukum yang diunggah 6 bulan terakhir</small>
                    </div>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 fw-semibold fs-8">
                        Periode Semester Aktif
                    </span>
                </div>
                <div style="position: relative; height: 260px; width: 100%;">
                    <canvas id="documentTrendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart 2: Distribusi Status & Kategori Dokumen -->
        <div class="col-lg-4">
            <div class="card chart-card shadow-sm p-4 h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-dark m-0">
                        <i class="bi bi-pie-chart text-primary me-2"></i>Status Dokumen
                    </h5>
                    <span class="text-muted fs-8">Distribusi Hukum</span>
                </div>

                <div class="d-flex flex-column gap-3 mb-4">
                    <!-- Status Berlaku -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1 fs-8">
                            <span class="fw-semibold text-dark"><i class="bi bi-circle-fill text-success fs-9 me-1.5"></i> Berlaku</span>
                            <span class="fw-bold text-success">{{ $statusCounts['Berlaku'] }} ({{ $totalDokumen > 0 ? round(($statusCounts['Berlaku'] / $totalDokumen) * 100) : 0 }}%)</span>
                        </div>
                        <div class="progress" style="height: 7px; border-radius: 6px;">
                            <div class="progress-bar bg-success" role="progressbar" 
                                style="width: {{ $totalDokumen > 0 ? round(($statusCounts['Berlaku'] / $totalDokumen) * 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Status Tidak Berlaku / Dicabut -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1 fs-8">
                            <span class="fw-semibold text-dark"><i class="bi bi-circle-fill text-danger fs-9 me-1.5"></i> Tidak Berlaku / Dicabut</span>
                            <span class="fw-bold text-danger">{{ $statusCounts['Tidak Berlaku'] + $statusCounts['Dicabut'] }}</span>
                        </div>
                        <div class="progress" style="height: 7px; border-radius: 6px;">
                            <div class="progress-bar bg-danger" role="progressbar" 
                                style="width: {{ $totalDokumen > 0 ? round((($statusCounts['Tidak Berlaku'] + $statusCounts['Dicabut']) / $totalDokumen) * 100) : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Status Diubah -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1 fs-8">
                            <span class="fw-semibold text-dark"><i class="bi bi-circle-fill text-warning fs-9 me-1.5"></i> Diubah</span>
                            <span class="fw-bold text-warning">{{ $statusCounts['Diubah'] }}</span>
                        </div>
                        <div class="progress" style="height: 7px; border-radius: 6px;">
                            <div class="progress-bar bg-warning" role="progressbar" 
                                style="width: {{ $totalDokumen > 0 ? round(($statusCounts['Diubah'] / $totalDokumen) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-3 border-top">
                    <div style="position: relative; height: 140px;">
                        <canvas id="categoryMiniDoughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Recent Documents & Activity Feeds Row -->
    <div class="row g-4">
        <!-- Recent Documents Table (8 Cols) -->
        <div class="col-lg-8">
            <div class="card chart-card shadow-sm p-4 h-100">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                    <div>
                        <h5 class="fw-bold text-dark m-0">
                            <i class="bi bi-clock-history text-primary me-2"></i>Upload Dokumen Terbaru
                        </h5>
                        <small class="text-muted">Daftar produk hukum yang baru saja ditambahkan</small>
                    </div>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3.5">
                        Lihat Semua Dokumen <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr class="text-muted fs-8 text-uppercase" style="letter-spacing: 0.5px;">
                                <th>Jenis &amp; Nomor</th>
                                <th>Judul Regulasi</th>
                                <th>Status</th>
                                <th class="text-center">Hits</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentDokumens as $doc)
                                <tr>
                                    <td style="min-width: 140px;">
                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-bold fs-8 mb-1 d-inline-block">
                                            {{ $doc->jenisDokumen->kode ?? 'DOK' }}
                                        </span>
                                        <div class="fw-bold text-dark fs-7.5">
                                            No. {{ $doc->nomor ?? '-' }} / {{ $doc->tahun }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark fs-7.5 text-break" style="max-width: 320px;" title="{{ $doc->judul }}">
                                            {{ Str::limit($doc->judul, 75) }}
                                        </div>
                                        <small class="text-muted fs-8">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $doc->created_at ? $doc->created_at->format('d/m/Y') : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if(strtolower($doc->status) === 'berlaku')
                                            <span class="badge badge-soft-success px-2.5 py-1 rounded-pill fs-8 fw-semibold">
                                                <i class="bi bi-check-circle-fill me-1"></i> {{ $doc->status }}
                                            </span>
                                        @elseif(strtolower($doc->status) === 'tidak berlaku' || strtolower($doc->status) === 'dicabut')
                                            <span class="badge badge-soft-danger px-2.5 py-1 rounded-pill fs-8 fw-semibold">
                                                <i class="bi bi-x-circle-fill me-1"></i> {{ $doc->status }}
                                            </span>
                                        @else
                                            <span class="badge badge-soft-warning px-2.5 py-1 rounded-pill fs-8 fw-semibold">
                                                <i class="bi bi-exclamation-circle-fill me-1"></i> {{ $doc->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-2 py-1 fs-8 fw-semibold" title="Jumlah dilihat">
                                            <i class="bi bi-eye text-muted me-1"></i> {{ number_format($doc->hits ?? 0) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('portal.document.show', $doc->id) }}" class="btn btn-light border" target="_blank" title="Lihat di Portal">
                                                <i class="bi bi-box-arrow-up-right text-primary"></i>
                                            </a>
                                            <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-light border" title="Edit Dokumen">
                                                <i class="bi bi-pencil-square text-warning"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-file-earmark-x fs-1 text-muted d-block mb-2"></i>
                                        <span class="text-muted fw-semibold">Belum ada dokumen hukum yang diunggah.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Activity Feeds & System Info (4 Cols) -->
        <div class="col-lg-4">
            <div class="d-flex flex-column gap-4">
                <!-- Activity Logs Feed -->
                <div class="card chart-card shadow-sm p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="fw-bold text-dark m-0">
                            <i class="bi bi-activity text-primary me-2"></i>Aktivitas Terkini
                        </h5>
                        @if(auth()->user()->hasRole('Admin'))
                            <a href="{{ route('admin.activity-logs.index') }}" class="fs-8 text-primary fw-semibold text-decoration-none">
                                Semua Log
                            </a>
                        @endif
                    </div>

                    <div class="activity-feed">
                        @forelse($recentActivities as $log)
                            <div class="activity-item">
                                <div class="activity-point"></div>
                                <div class="d-flex align-items-start justify-content-between gap-1">
                                    <span class="fw-bold text-dark fs-8">{{ $log->user_name ?? ($log->user->name ?? 'User') }}</span>
                                    <small class="text-muted fs-9">{{ $log->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="m-0 text-muted fs-8 text-break lh-sm">
                                    {{ Str::limit($log->description ?? $log->action, 65) }}
                                </p>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-clock-history fs-2 text-muted d-block mb-1"></i>
                                <small class="text-muted">Belum ada catatan aktivitas terbaru.</small>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- System & Environment Card -->
                <div class="card chart-card shadow-sm p-4">
                    <h6 class="fw-bold text-dark mb-3">
                        <i class="bi bi-server text-primary me-2"></i>Informasi Sistem
                    </h6>
                    <div class="d-flex flex-column gap-2 fs-8">
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-muted">Platform</span>
                            <span class="fw-semibold text-dark">Laravel v{{ app()->version() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-muted">PHP Engine</span>
                            <span class="fw-semibold text-dark">PHP {{ phpversion() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pb-2 border-bottom">
                            <span class="text-muted">Auto-Logout Timeout</span>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold">30 Menit (Aktif)</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Koneksi Database</span>
                            <span class="badge bg-success bg-opacity-10 text-success fw-bold"><i class="bi bi-hdd-network me-1"></i> Terhubung</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Theme Colors
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        const textColor = isDark ? '#94a3b8' : '#64748b';
        const gridColor = isDark ? 'rgba(255, 255, 255, 0.06)' : 'rgba(15, 23, 42, 0.06)';

        // 1. Line Chart: Tren Publikasi Dokumen
        const trendCanvas = document.getElementById('documentTrendChart');
        if (trendCanvas) {
            const ctx = trendCanvas.getContext('2d');
            const gradient = ctx.createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(13, 59, 102, 0.35)');
            gradient.addColorStop(1, 'rgba(13, 59, 102, 0.0)');

            const labels = @json($chartLabels);
            const dataCounts = @json($chartData);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Dokumen Diupload',
                        data: dataCounts,
                        borderColor: '#185a9d',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#0d3b66',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.38,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Outfit', size: 13 },
                            bodyFont: { family: 'Outfit', size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y + ' Dokumen Hukum';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { color: gridColor },
                            ticks: { color: textColor, font: { family: 'Outfit', size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: gridColor },
                            ticks: {
                                color: textColor,
                                font: { family: 'Outfit', size: 11 },
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // 2. Mini Doughnut Chart: Kategori Teratas
        const catCanvas = document.getElementById('categoryMiniDoughnut');
        if (catCanvas) {
            const catNames = [];
            const catCounts = [];
            @foreach($dokumenPerKategori->take(5) as $cat)
                catNames.push("{{ $cat->nama }}");
                catCounts.push({{ $cat->dokumen_hukums_count }});
            @endforeach

            const bgPalette = ['#0d3b66', '#0284c7', '#10b981', '#f59e0b', '#8b5cf6'];

            new Chart(catCanvas, {
                type: 'doughnut',
                data: {
                    labels: catNames,
                    datasets: [{
                        data: catCounts.length > 0 ? catCounts : [1],
                        backgroundColor: catCounts.length > 0 ? bgPalette.slice(0, catCounts.length) : ['#e2e8f0'],
                        borderWidth: 2,
                        borderColor: isDark ? '#151f32' : '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { family: 'Outfit', size: 12 },
                            bodyFont: { family: 'Outfit', size: 11 },
                            cornerRadius: 8,
                            padding: 8
                        }
                    },
                    cutout: '68%'
                }
            });
        }
    });
</script>
@endsection
