@extends('layouts.portal')

@section('title', $document->judul . ' - JDIH DPRD')

@section('content')

    <!-- Breadcrumb & Header -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portal.search', ['tipe_dokumen' => $document->tipe_dokumen]) }}" class="text-white-50 text-decoration-none">{{ $document->tipe_dokumen }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('portal.search', ['jenis_dokumen_id' => $document->jenis_dokumen_id]) }}" class="text-white-50 text-decoration-none">{{ $document->jenisDokumen->nama ?? '-' }}</a></li>
                    <li class="breadcrumb-item active text-warning text-truncate" style="max-width: 300px;" aria-current="page">{{ $document->nomor }}</li>
                </ol>
            </nav>
            <h4 class="fw-bold mb-0 text-white">{{ $document->judul }}</h4>
        </div>
    </section>

    <!-- Document Detail & Metadata Table -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Main Metadata & PDF Viewer (Col 8) -->
                <div class="col-lg-8">
                    
                    <!-- Meta Table Card -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                        <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 flex-wrap gap-2">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary fs-8 px-3 py-1 rounded-pill fw-semibold">
                                    {{ $document->tipe_dokumen }} &bull; {{ $document->jenisDokumen->nama ?? '-' }}
                                </span>
                            </div>
                            <div>
                                <span class="badge-status status-{{ Str::slug($document->status) }} fs-7">
                                    <i class="bi bi-shield-check"></i> {{ $document->status }}
                                </span>
                            </div>
                        </div>

                        <!-- Full Standard JDIHN Fields Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped fs-8 align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="bg-light text-muted" style="width: 30%;">Tipe Dokumen</th>
                                        <td><strong>{{ $document->tipe_dokumen }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Jenis Produk Hukum</th>
                                        <td>{{ $document->jenisDokumen->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Nomor</th>
                                        <td><strong>{{ $document->nomor }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Tahun Terbit</th>
                                        <td>{{ $document->tahun }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Tanggal Ditetapkan</th>
                                        <td>{{ $document->tanggal_ditetapkan ? $document->tanggal_ditetapkan->format('d F Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Tanggal Pengundangan</th>
                                        <td>{{ $document->tanggal_pengundangan ? $document->tanggal_pengundangan->format('d F Y') : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Penandatangan</th>
                                        <td>{{ $document->penandatangan ?: 'Pimpinan DPRD / Walikota' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Pemrakarsa / Pengusul</th>
                                        <td>{{ $document->pemrakarsa ?: 'DPRD' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Tempat Terbit</th>
                                        <td>{{ $document->tempat_terbit ?: 'Medan' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Sumber / Lembaran Daerah</th>
                                        <td>{{ $document->sumber ?: 'Sekretariat DPRD' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Subjek / Kata Kunci</th>
                                        <td>{{ $document->subjek ?: 'Peraturan Perundang-undangan Daerah' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Bidang Hukum</th>
                                        <td>{{ $document->bidang_hukum ?: 'Hukum Tata Negara' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Bahasa</th>
                                        <td>{{ $document->bahasa ?: 'Indonesia' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light text-muted">Status Dokumen</th>
                                        <td>
                                            <span class="badge-status status-{{ Str::slug($document->status) }}">
                                                {{ $document->status }}
                                            </span>
                                            @if($document->keterangan_status)
                                                <div class="small text-danger mt-1">
                                                    <i class="bi bi-info-circle"></i> {{ $document->keterangan_status }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Abstrak Card -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                        <h5 class="fw-bold text-primary mb-3">
                            <i class="bi bi-card-text me-2 text-warning"></i> Abstrak / Ringkasan Dokumen
                        </h5>
                        <p class="text-dark fs-7 lh-base mb-0" style="text-align: justify;">
                            {{ $document->abstrak ?: 'Belum ada ringkasan abstrak yang ditambahkan untuk dokumen ini.' }}
                        </p>
                    </div>

                    <!-- PDF Viewer -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <h5 class="fw-bold text-primary mb-0">
                                <i class="bi bi-file-earmark-pdf-fill me-2 text-danger"></i> Naskah Dokumen Hukum (PDF)
                            </h5>
                            <a href="{{ route('portal.document.download', $document->id) }}" class="btn btn-teal text-white rounded-pill px-4 fs-7 fw-semibold" style="background-color: #0d9488;">
                                <i class="bi bi-download me-1"></i> Unduh Dokumen Asli
                            </a>
                        </div>

                        @if($document->file_pdf && file_exists(public_path($document->file_pdf)))
                            <div class="ratio ratio-16x9 border rounded-3 overflow-hidden" style="min-height: 600px;">
                                <iframe src="{{ asset($document->file_pdf) }}#toolbar=1" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="p-5 text-center bg-light rounded-3 border">
                                <i class="bi bi-file-earmark-pdf fs-1 text-muted d-block mb-3"></i>
                                <h6 class="fw-bold">Naskah Digital Tersedia di Pangkalan Data</h6>
                                <p class="text-muted fs-8 mb-3">Klik tombol unduh untuk mengunduh salinan resmi dokumen hukum ini.</p>
                                <a href="{{ route('portal.document.download', $document->id) }}" class="btn btn-primary rounded-pill px-4 fs-7">
                                    <i class="bi bi-download me-1"></i> Unduh File PDF
                                </a>
                            </div>
                        @endif
                    </div>

                </div>

                <!-- Right Sidebar (Col 4) -->
                <div class="col-lg-4">
                    
                    <!-- Quick Actions Card -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                        <h6 class="fw-bold text-primary mb-3">Aksi Dokumen</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('portal.document.download', $document->id) }}" class="btn btn-success rounded-pill fw-semibold py-2">
                                <i class="bi bi-cloud-arrow-down-fill me-1"></i> Unduh Salinan PDF
                            </a>
                            <button type="button" class="btn btn-outline-primary rounded-pill fw-semibold py-2" onclick="window.print()">
                                <i class="bi bi-printer-fill me-1"></i> Cetak Halaman Metadata
                            </button>
                        </div>
                        <div class="mt-3 pt-3 border-top text-muted fs-8">
                            <div class="d-flex justify-content-between mb-1">
                                <span><i class="bi bi-eye"></i> Dilihat:</span>
                                <strong>{{ number_format($document->hits) }} kali</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-download"></i> Diunduh:</span>
                                <strong>{{ number_format($document->downloads) }} kali</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Dokumen Terkait -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <h6 class="fw-bold text-primary mb-3">Dokumen Terkait</h6>
                        <div class="d-flex flex-column gap-3 fs-8">
                            @forelse($relatedDocuments as $rel)
                                <div class="border-bottom pb-2">
                                    <a href="{{ route('portal.document.show', $rel->id) }}" class="text-dark text-decoration-none fw-semibold d-block mb-1 hover-text-primary">
                                        {{ Str::limit($rel->judul, 70) }}
                                    </a>
                                    <div class="text-muted fs-9">
                                        No. {{ $rel->nomor }} Tahun {{ $rel->tahun }} &bull; 
                                        <span class="badge-status status-{{ Str::slug($rel->status) }}" style="font-size:0.65rem; padding: 2px 6px;">{{ $rel->status }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-muted">Tidak ada dokumen terkait lainnya.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
