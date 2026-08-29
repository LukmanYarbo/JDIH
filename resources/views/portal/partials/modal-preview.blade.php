<div class="p-4">
    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4">
        <div>
            <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-8 rounded-pill">
                {{ $document->tipe_dokumen }} &bull; {{ $document->jenisDokumen->nama ?? '-' }}
            </span>
            <h5 class="fw-bold mt-2 mb-1 text-dark">{{ $document->judul }}</h5>
            <div class="text-muted fs-8">
                <span class="me-3"><i class="bi bi-file-earmark-text"></i> Nomor: <strong>{{ $document->nomor }}</strong></span>
                <span class="me-3"><i class="bi bi-calendar3"></i> Tahun: <strong>{{ $document->tahun }}</strong></span>
                <span><i class="bi bi-clock"></i> Ditetapkan: <strong>{{ $document->tanggal_ditetapkan ? $document->tanggal_ditetapkan->format('d F Y') : '-' }}</strong></span>
            </div>
        </div>
        <div>
            <span class="badge-status status-{{ Str::slug($document->status) }} fs-7">
                <i class="bi bi-check-circle-fill"></i> {{ $document->status }}
            </span>
        </div>
    </div>

    <!-- Embedded PDF Viewer or Preview Area -->
    @if($document->file_pdf && file_exists(public_path($document->file_pdf)))
        <div class="ratio ratio-16x9 border rounded-3 overflow-hidden shadow-sm" style="min-height: 520px;">
            <iframe src="{{ asset($document->file_pdf) }}#toolbar=1" allowfullscreen></iframe>
        </div>
    @else
        <div class="p-5 text-center bg-light rounded-3 border">
            <i class="bi bi-file-earmark-pdf fs-1 text-danger d-block mb-3"></i>
            <h5 class="fw-bold text-dark">Naskah Asli Dokumen Hukum</h5>
            <p class="text-muted fs-7 max-width-500 mx-auto mb-4">
                Dokumen resmi <strong>{{ $document->judul }}</strong> (Nomor: {{ $document->nomor }}) telah terdaftar dalam pangkalan data JDIH DPRD.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('portal.document.show', $document->id) }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-eye me-1"></i> Buka Halaman Lengkap
                </a>
                <a href="{{ route('portal.document.download', $document->id) }}" class="btn btn-teal text-white rounded-pill px-4" style="background-color: #0d9488;">
                    <i class="bi bi-download me-1"></i> Unduh Salinan PDF
                </a>
            </div>
        </div>
    @endif

    <div class="row g-3 mt-4 pt-3 border-top fs-8 text-muted">
        <div class="col-md-4">
            <strong><i class="bi bi-person-fill text-primary"></i> Penandatangan:</strong><br>
            {{ $document->penandatangan ?? 'Pimpinan DPRD / Walikota' }}
        </div>
        <div class="col-md-4">
            <strong><i class="bi bi-building text-primary"></i> Pemrakarsa:</strong><br>
            {{ $document->pemrakarsa ?? 'DPRD' }}
        </div>
        <div class="col-md-4">
            <strong><i class="bi bi-tags-fill text-primary"></i> Subjek / Kata Kunci:</strong><br>
            {{ $document->subjek ?? 'Peraturan Perundang-Undangan Daerah' }}
        </div>
    </div>
</div>
