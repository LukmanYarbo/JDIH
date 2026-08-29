<div>
    <div class="border-bottom pb-3 mb-3">
        <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-8 rounded-pill">
            {{ $document->jenisDokumen->nama ?? 'Dokumen Hukum' }}
        </span>
        <h5 class="fw-bold mt-2 mb-1 text-dark">{{ $document->judul }}</h5>
        <div class="text-muted fs-8">
            Nomor {{ $document->nomor }} Tahun {{ $document->tahun }} &bull; Status: <strong class="text-success">{{ $document->status }}</strong>
        </div>
    </div>

    <div class="card border-0 bg-light p-3 mb-3 rounded-3">
        <h6 class="fw-bold text-primary mb-2"><i class="bi bi-card-text me-1"></i> Ringkasan / Abstrak:</h6>
        <p class="text-dark fs-7 lh-base mb-0" style="text-align: justify;">
            {{ $document->abstrak ?: 'Belum ada ringkasan abstrak untuk dokumen ini.' }}
        </p>
    </div>

    @if($document->keterangan_status)
        <div class="alert alert-warning py-2 px-3 fs-8 mb-3">
            <i class="bi bi-info-circle-fill me-1"></i> <strong>Catatan Hubungan Status:</strong> {{ $document->keterangan_status }}
        </div>
    @endif

    <div class="row g-2 fs-8 text-muted mt-2 border-top pt-3">
        <div class="col-6">
            <span>Bidang Hukum: <strong>{{ $document->bidang_hukum ?? 'Hukum Tata Negara' }}</strong></span>
        </div>
        <div class="col-6 text-end">
            <span>Bahasa: <strong>{{ $document->bahasa ?? 'Indonesia' }}</strong></span>
        </div>
    </div>
</div>
