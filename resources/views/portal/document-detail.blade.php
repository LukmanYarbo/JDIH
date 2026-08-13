@extends('layouts.portal')

@section('title', 'Detail Produk Hukum - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <div class="d-flex align-items-center gap-2 mb-2">
                <a href="{{ route('portal.search') }}" class="text-white-50 text-decoration-none fs-7"><i class="bi bi-arrow-left"></i> Kembali ke Pencarian</a>
            </div>
            <h3 class="fw-bold m-0">{{ $document->jenisDokumen->nama }} Nomor {{ $document->nomor }} Tahun {{ $document->tahun }}</h3>
        </div>
    </section>

    <!-- Details and Preview -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Metadata Info Card -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-info-circle me-1"></i> Informasi Dokumen</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless fs-6">
                                <tbody>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5" style="width: 150px;">Jenis Dokumen</td>
                                        <td class="fw-semibold py-2.5 text-dark">{{ $document->jenisDokumen->nama }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5">Nomor Produk</td>
                                        <td class="fw-semibold py-2.5 text-dark">{{ $document->nomor }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5">Tahun Terbit</td>
                                        <td class="fw-semibold py-2.5 text-dark">{{ $document->tahun }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5">Tanggal Ditetapkan</td>
                                        <td class="fw-semibold py-2.5 text-dark">
                                            {{ $document->tanggal_ditetapkan ? \Carbon\Carbon::parse($document->tanggal_ditetapkan)->translatedFormat('d F Y') : '-' }}
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5">Status Hukum</td>
                                        <td class="py-2.5">
                                            <span class="badge-status status-{{ Str::slug($document->status) }} fs-7">
                                                {{ $document->status }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td class="text-muted py-2.5">Dilihat / Diunduh</td>
                                        <td class="fw-semibold py-2.5 text-dark"><i class="bi bi-eye text-primary me-1"></i> {{ $document->hits }} kali</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-grid gap-2 mt-4">
                            @if($document->file_pdf)
                                <a href="{{ route('portal.document.download', $document->id) }}" class="btn btn-primary rounded-pill py-2.5 fw-semibold shadow-sm">
                                    <i class="bi bi-download me-1"></i> Unduh File PDF
                                </a>
                            @else
                                <button class="btn btn-secondary rounded-pill py-2.5 fw-semibold" disabled>
                                    <i class="bi bi-file-earmark-lock me-1"></i> File PDF Belum Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Title & Abstract & Preview -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm p-4 mb-4">
                        <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-file-earmark-text me-1"></i> Judul &amp; Ringkasan</h4>
                        <h5 class="fw-bold text-dark mb-4">{{ $document->judul }}</h5>
                        
                        <h6 class="fw-bold text-muted mb-2">Abstrak / Ringkasan</h6>
                        <p class="text-muted fs-6 mb-0 lh-base">
                            {{ $document->abstrak ?: 'Ringkasan atau abstrak belum diinput untuk dokumen hukum ini.' }}
                        </p>
                    </div>

                    <!-- PDF Previewer (if file exists) -->
                    @if($document->file_pdf)
                        <div class="card border-0 shadow-sm p-4">
                            <h4 class="fw-bold mb-3 text-primary"><i class="bi bi-file-pdf me-1"></i> Pratinjau Dokumen</h4>
                            <div class="ratio ratio-4x3 rounded overflow-hidden border">
                                <embed src="{{ asset($document->file_pdf) }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="100%">
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
@endsection
