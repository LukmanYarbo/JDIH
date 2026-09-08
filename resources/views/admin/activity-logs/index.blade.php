@extends('layouts.admin')

@section('title', 'Log Aktivitas Pengguna - Admin JDIH')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-clock-history text-primary"></i> Log Aktivitas Pengguna
            </h3>
            <p class="text-muted mb-0 small">
                Rekam jejak dan riwayat aktivitas seluruh pengguna sistem JDIH secara real-time. (Khusus Administrator)
            </p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
                <i class="bi bi-trash3 me-1"></i> Bersihkan Log
            </button>
            <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm" title="Segarkan Data">
                <i class="bi bi-arrow-clockwise me-1"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Total Log Tercatat</span>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalLogs) }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-4 fs-3">
                        <i class="bi bi-journal-text"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">Aktivitas Hari Ini</span>
                        <h3 class="fw-bold mb-0 text-success">{{ number_format($todayLogs) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-4 fs-3">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">User Aktif (7 Hari)</span>
                        <h3 class="fw-bold mb-0 text-info">{{ number_format($activeUsers7Days) }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info p-3 rounded-4 fs-3">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-body p-3 p-xl-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-medium d-block mb-1">User Paling Aktif</span>
                        <h6 class="fw-bold mb-0 text-truncate text-warning" style="max-width: 140px;">
                            {{ $topUser ? $topUser->user_name : '-' }}
                        </h6>
                        @if($topUser)
                            <small class="text-muted fs-8">{{ $topUser->total }} aktivitas</small>
                        @endif
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-4 fs-3">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.activity-logs.index') }}" method="GET">
                <div class="row g-2 g-md-3">
                    <div class="col-12 col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Pencarian Kata Kunci</label>
                        <div class="input-group">
                            <span class="input-group-text border-end-0 bg-light"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0" 
                                placeholder="Cari deskripsi, nama, IP..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">Pengguna</label>
                        <select name="user_id" class="form-select bg-light">
                            <option value="">-- Semua Pengguna --</option>
                            @foreach($users as $u)
                                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>
                                    {{ $u->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">Jenis Aksi</label>
                        <select name="action" class="form-select bg-light">
                            <option value="">-- Semua Aksi --</option>
                            @foreach($actions as $act)
                                <option value="{{ $act }}" {{ request('action') == $act ? 'selected' : '' }}>
                                    {{ ucfirst($act) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <label class="form-label small fw-semibold text-muted mb-1">Modul</label>
                        <select name="module" class="form-select bg-light">
                            <option value="">-- Semua Modul --</option>
                            @foreach($modules as $mod)
                                <option value="{{ $mod }}" {{ request('module') == $mod ? 'selected' : '' }}>
                                    {{ $mod }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small fw-semibold text-muted mb-1">Rentang Tanggal</label>
                        <div class="d-flex gap-1">
                            <input type="date" name="date_from" class="form-control form-control-sm bg-light" value="{{ request('date_from') }}" title="Dari Tanggal">
                            <span class="align-self-center text-muted">-</span>
                            <input type="date" name="date_to" class="form-control form-control-sm bg-light" value="{{ request('date_to') }}" title="Sampai Tanggal">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3 pt-2 border-top">
                    @if(request()->hasAny(['search', 'user_id', 'action', 'module', 'date_from', 'date_to']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn btn-sm btn-light border rounded-pill px-3">
                            <i class="bi bi-x-circle me-1"></i> Reset Filter
                        </a>
                    @endif
                    <button type="submit" class="btn btn-sm btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-funnel-fill me-1"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Activity Log Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold text-dark mb-0">Daftar Rekam Aktivitas</h5>
            <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill font-monospace small">
                Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} log
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light border-bottom border-top text-secondary small text-uppercase font-monospace">
                        <tr>
                            <th class="ps-4 py-3" style="width: 170px;">Waktu</th>
                            <th class="py-3" style="width: 220px;">Pengguna</th>
                            <th class="py-3" style="width: 130px;">Aksi</th>
                            <th class="py-3" style="width: 150px;">Modul</th>
                            <th class="py-3">Deskripsi Aktivitas</th>
                            <th class="py-3" style="width: 140px;">IP / Jaringan</th>
                            <th class="pe-4 py-3 text-end" style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($logs as $log)
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark small">{{ $log->created_at->translatedFormat('d M Y') }}</span>
                                        <span class="text-muted fs-8 font-monospace">{{ $log->created_at->format('H:i:s') }} ({{ $log->created_at->diffForHumans() }})</span>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold fs-7"
                                            style="width: 34px; height: 34px; min-width: 34px;">
                                            {{ strtoupper(substr($log->user_name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="d-flex flex-column" style="max-width: 170px;">
                                            <span class="fw-semibold text-dark small text-truncate" title="{{ $log->user_name }}">
                                                {{ $log->user_name ?? 'Tamu / Sistem' }}
                                            </span>
                                            <div class="d-flex align-items-center gap-1">
                                                @if($log->user_role)
                                                    <span class="badge {{ $log->user_role === 'Admin' ? 'bg-danger' : 'bg-secondary' }} px-1 py-0 fs-9 rounded">
                                                        {{ $log->user_role }}
                                                    </span>
                                                @endif
                                                @if($log->user_email)
                                                    <small class="text-muted fs-8 text-truncate" title="{{ $log->user_email }}">
                                                        {{ $log->user_email }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <span class="badge {{ $log->action_badge_class }} rounded-pill px-2 py-1 small fw-semibold">
                                        <i class="bi {{ $log->action_icon }} me-1"></i> {{ $log->action_label }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="badge bg-light text-dark border rounded-pill px-2 py-1 small">
                                        <i class="bi bi-folder2-open me-1 text-primary"></i> {{ $log->module ?? '-' }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="text-dark small d-block" style="max-width: 380px;">
                                        {{ $log->description }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <div class="d-flex flex-column font-monospace fs-8">
                                        <span class="text-dark"><i class="bi bi-hdd-network text-secondary me-1"></i>{{ $log->ip_address ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-2 py-1 btn-detail-log"
                                            data-id="{{ $log->id }}"
                                            data-url="{{ route('admin.activity-logs.show', $log->id) }}"
                                            title="Lihat Rincian">
                                            <i class="bi bi-eye text-primary"></i>
                                        </button>
                                        <form action="{{ route('admin.activity-logs.destroy', $log->id) }}" method="POST" class="d-inline delete-form"
                                            data-title="Hapus Catatan Log?"
                                            data-confirm="Catatan log ini akan dihapus permanen dari sistem."
                                            data-btn-text="Hapus Log">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border rounded-pill px-2 py-1 text-danger" title="Hapus Log">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="py-4">
                                        <i class="bi bi-clipboard-x display-4 text-muted opacity-50"></i>
                                        <h6 class="fw-semibold text-dark mt-3 mb-1">Belum Ada Catatan Log Aktivitas</h6>
                                        <p class="text-muted small mb-0">
                                            Tidak ada riwayat aktivitas yang sesuai dengan kriteria filter yang Anda pilih.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
            <div class="card-footer bg-transparent border-0 p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Halaman {{ $logs->currentPage() }} dari {{ $logs->lastPage() }}
                    </div>
                    <div>
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Detail Log Aktivitas -->
<div class="modal fade" id="detailLogModal" tabindex="-1" aria-labelledby="detailLogModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="detailLogModalLabel">
                    <i class="bi bi-info-circle-fill text-primary"></i> Rincian Log Aktivitas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="detailLogContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Memuat data...</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0 py-2 px-4">
                <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Bersihkan Log (Clear Logs) -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg overflow-hidden">
            <form action="{{ route('admin.activity-logs.clear') }}" method="POST" id="clearLogsForm">
                @csrf
                @method('DELETE')
                <div class="modal-header bg-danger text-white border-0 py-3 px-4">
                    <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="clearLogsModalLabel">
                        <i class="bi bi-exclamation-triangle-fill"></i> Bersihkan Log Aktivitas
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-dark small mb-3">
                        Pilih periode log aktivitas yang ingin Anda bersihkan. Tindakan ini akan menghapus data riwayat dari database secara permanen.
                    </p>

                    <div class="d-flex flex-column gap-2 mb-3">
                        <label class="form-check p-3 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer">
                            <input class="form-check-input ms-0 me-2" type="radio" name="period" value="older_than_30_days" checked>
                            <div>
                                <span class="fw-semibold text-dark d-block">Hapus log yang berusia lebih dari 30 hari</span>
                                <small class="text-muted">Menyimpan riwayat 30 hari terakhir dan menghapus riwayat lama.</small>
                            </div>
                        </label>
                        <label class="form-check p-3 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer">
                            <input class="form-check-input ms-0 me-2" type="radio" name="period" value="older_than_90_days">
                            <div>
                                <span class="fw-semibold text-dark d-block">Hapus log yang berusia lebih dari 90 hari</span>
                                <small class="text-muted">Menyimpan riwayat 3 bulan terakhir.</small>
                            </div>
                        </label>
                        <label class="form-check p-3 border rounded-3 border-danger bg-danger bg-opacity-10 d-flex align-items-center gap-2 cursor-pointer">
                            <input class="form-check-input ms-0 me-2" type="radio" name="period" value="all">
                            <div>
                                <span class="fw-semibold text-danger d-block">Hapus SEMUA riwayat log (Truncate)</span>
                                <small class="text-muted">Semua data log dari awal akan dibersihkan tanpa tersisa.</small>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 btn-sm fw-semibold">
                        <i class="bi bi-trash3-fill me-1"></i> Bersihkan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailModal = new bootstrap.Modal(document.getElementById('detailLogModal'));
        const modalBody = document.getElementById('detailLogContent');

        // Handle clicking view detail button
        document.querySelectorAll('.btn-detail-log').forEach(btn => {
            btn.addEventListener('click', function () {
                const url = this.getAttribute('data-url');
                
                modalBody.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Memuat data...</span>
                        </div>
                    </div>
                `;
                detailModal.show();

                fetch(url)
                    .then(response => response.json())
                    .then(res => {
                        if (!res.success) {
                            modalBody.innerHTML = `<div class="alert alert-danger">Gagal memuat rincian log.</div>`;
                            return;
                        }
                        const d = res.data;

                        let propertiesHtml = '';
                        if (d.properties) {
                            if (d.properties.old && d.properties.new) {
                                // Perubahan data (update diff)
                                let diffRows = '';
                                const allKeys = Array.from(new Set([...Object.keys(d.properties.old), ...Object.keys(d.properties.new)]));
                                allKeys.forEach(k => {
                                    const oldVal = d.properties.old[k] !== null && d.properties.old[k] !== undefined ? String(d.properties.old[k]) : '<em>null</em>';
                                    const newVal = d.properties.new[k] !== null && d.properties.new[k] !== undefined ? String(d.properties.new[k]) : '<em>null</em>';
                                    diffRows += `
                                        <tr>
                                            <td class="fw-semibold font-monospace small text-primary">${k}</td>
                                            <td class="small text-danger bg-danger bg-opacity-10">${oldVal}</td>
                                            <td class="small text-success bg-success bg-opacity-10">${newVal}</td>
                                        </tr>
                                    `;
                                });

                                propertiesHtml = `
                                    <div class="mt-3">
                                        <h6 class="fw-bold text-dark mb-2 small text-uppercase">Perubahan Data (Sebelum vs Sesudah):</h6>
                                        <div class="table-responsive border rounded-3">
                                            <table class="table table-sm table-bordered mb-0">
                                                <thead class="table-light">
                                                    <tr class="small text-secondary">
                                                        <th style="width: 25%;">Kolom/Atribut</th>
                                                        <th style="width: 37.5%;">Nilai Lama</th>
                                                        <th style="width: 37.5%;">Nilai Baru</th>
                                                    </tr>
                                                </thead>
                                                <tbody>${diffRows}</tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
                            } else if (d.properties.attributes) {
                                let attrRows = '';
                                Object.entries(d.properties.attributes).forEach(([k, v]) => {
                                    const val = v !== null && v !== undefined ? String(v) : '<em>null</em>';
                                    attrRows += `
                                        <tr>
                                            <td class="fw-semibold font-monospace small text-secondary" style="width: 30%;">${k}</td>
                                            <td class="small text-dark">${val}</td>
                                        </tr>
                                    `;
                                });

                                propertiesHtml = `
                                    <div class="mt-3">
                                        <h6 class="fw-bold text-dark mb-2 small text-uppercase">Data Atribut Entri:</h6>
                                        <div class="table-responsive border rounded-3" style="max-height: 250px; overflow-y: auto;">
                                            <table class="table table-sm table-striped mb-0">
                                                <tbody>${attrRows}</tbody>
                                            </table>
                                        </div>
                                    </div>
                                `;
                            } else {
                                propertiesHtml = `
                                    <div class="mt-3">
                                        <h6 class="fw-bold text-dark mb-2 small text-uppercase">Informasi Tambahan:</h6>
                                        <pre class="bg-light p-3 rounded-3 border small font-monospace mb-0" style="max-height: 200px; overflow-y: auto;">${JSON.stringify(d.properties, null, 2)}</pre>
                                    </div>
                                `;
                            }
                        }

                        modalBody.innerHTML = `
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <span class="text-muted small d-block mb-1">Pengguna / Pelaku</span>
                                        <h6 class="fw-bold text-dark mb-0">${d.user_name || 'Tamu / Sistem'}</h6>
                                        <small class="text-muted d-block">${d.user_email || '-'}</small>
                                        <span class="badge bg-secondary mt-1">${d.user_role || 'User'}</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <span class="text-muted small d-block mb-1">Waktu Aktivitas</span>
                                        <h6 class="fw-bold text-dark mb-0">${d.created_at}</h6>
                                        <small class="text-muted">${d.diff_for_humans}</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="p-3 bg-light rounded-3 border">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <span class="badge ${d.action_badge_class} px-2 py-1">${d.action_label}</span>
                                            <span class="badge bg-white text-dark border px-2 py-1">${d.module || 'Umum'}</span>
                                        </div>
                                        <span class="text-muted small d-block mb-1">Deskripsi</span>
                                        <p class="text-dark mb-0 fw-medium">${d.description}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="p-2 border rounded-3 font-monospace fs-8">
                                        <span class="text-muted d-block fs-9">IP ADDRESS</span>
                                        <span class="text-dark fw-bold">${d.ip_address || '-'}</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="p-2 border rounded-3 font-monospace fs-8">
                                        <span class="text-muted d-block fs-9">PERANGKAT / USER AGENT</span>
                                        <span class="text-dark text-truncate d-block" title="${d.user_agent || '-'}">${d.user_agent || '-'}</span>
                                    </div>
                                </div>
                            </div>
                            ${propertiesHtml}
                        `;
                    })
                    .catch(err => {
                        modalBody.innerHTML = `<div class="alert alert-danger">Terjadi kesalahan saat memuat rincian log: ${err.message}</div>`;
                    });
            });
        });
    });
</script>
@endsection
