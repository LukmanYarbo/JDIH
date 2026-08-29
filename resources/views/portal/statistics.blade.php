@extends('layouts.portal')

@section('title', 'Statistik Dokumen Hukum - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Statistik</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Statistik &amp; Pangkalan Data Dokumen Hukum</h3>
        </div>
    </section>

    <!-- Stat Summary Cards -->
    <section class="py-4 bg-white border-bottom shadow-sm">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-muted fs-8 fw-semibold">TOTAL DOKUMEN HUKUM</div>
                        <h2 class="fw-bold text-primary mb-0 font-monospace">{{ number_format($totalDokumen) }}</h2>
                        <small class="text-muted fs-9">Dokumen Terdaftar</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-muted fs-8 fw-semibold">TOTAL PENGUNJUNG / HITS</div>
                        <h2 class="fw-bold text-warning mb-0 font-monospace">{{ number_format($totalHits) }}</h2>
                        <small class="text-muted fs-9">Kali Dilihat</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="text-muted fs-8 fw-semibold">TOTAL UNDUHAN DOKUMEN</div>
                        <h2 class="fw-bold text-success mb-0 font-monospace">{{ number_format($totalDownloads) }}</h2>
                        <small class="text-muted fs-9">Kali Diunduh</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Charts Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Chart 1: Dokumen per Tipe Utama (Donut Chart) -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-pie-chart-fill me-2 text-warning"></i> Komposisi Tipe Dokumen
                        </h5>
                        <div class="chart-container position-relative" style="height: 300px;">
                            <canvas id="chartByType"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 2: Dokumen per Status Hukum (Pie Chart) -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white h-100">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-shield-check me-2 text-success"></i> Status Keberlakuan Peraturan
                        </h5>
                        <div class="chart-container position-relative" style="height: 300px;">
                            <canvas id="chartByStatus"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 3: Dokumen per Tahun (Bar Chart) -->
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-graph-up me-2 text-primary"></i> Tren Produk Hukum per Tahun
                        </h5>
                        <div class="chart-container position-relative" style="height: 320px;">
                            <canvas id="chartByYear"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart 4: Top 10 Kategori Dokumen (Horizontal Bar) -->
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-bar-chart-steps me-2 text-info"></i> Jumlah Dokumen Berdasarkan Jenis Produk Hukum
                        </h5>
                        <div class="chart-container position-relative" style="height: 360px;">
                            <canvas id="chartByCategory"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // 1. Chart by Type
        const byTypeCtx = document.getElementById('chartByType').getContext('2d');
        new Chart(byTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($byType->pluck('tipe_dokumen')) !!},
                datasets: [{
                    data: {!! json_encode($byType->pluck('total')) !!},
                    backgroundColor: ['#1e3a8a', '#f59e0b', '#10b981', '#6366f1'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // 2. Chart by Status
        const byStatusCtx = document.getElementById('chartByStatus').getContext('2d');
        new Chart(byStatusCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($byStatus->pluck('status')) !!},
                datasets: [{
                    data: {!! json_encode($byStatus->pluck('total')) !!},
                    backgroundColor: ['#10b981', '#0ea5e9', '#f59e0b', '#ef4444'],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // 3. Chart by Year
        const byYearCtx = document.getElementById('chartByYear').getContext('2d');
        new Chart(byYearCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($byYear->pluck('tahun')) !!},
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: {!! json_encode($byYear->pluck('total')) !!},
                    backgroundColor: '#1e3a8a',
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 4. Chart by Category (Top 10)
        const byCategoryCtx = document.getElementById('chartByCategory').getContext('2d');
        new Chart(byCategoryCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($byCategory->pluck('nama')) !!},
                datasets: [{
                    label: 'Jumlah Dokumen',
                    data: {!! json_encode($byCategory->pluck('dokumen_hukums_count')) !!},
                    backgroundColor: '#0284c7',
                    borderRadius: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });

    });
</script>
@endsection
