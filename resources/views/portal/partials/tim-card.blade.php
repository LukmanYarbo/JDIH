<div class="card border rounded-3 p-3 bg-white h-100 shadow-sm text-center">
    @if($tim->foto)
        <img src="{{ asset($tim->foto) }}" alt="{{ $tim->nama }}" class="rounded-circle border mx-auto mb-2" style="width: 68px; height: 68px; object-fit: cover;">
    @else
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle border mx-auto mb-2 d-flex align-items-center justify-content-center fw-bold" style="width: 68px; height: 68px; font-size: 22px;">
            {{ strtoupper(substr($tim->nama, 0, 1)) }}
        </div>
    @endif
    
    <span class="badge {{ $badgeClass ?? 'bg-primary text-white' }} px-2.5 py-1 fs-9 rounded-pill mx-auto mb-1.5 fw-bold" style="{{ $badgeStyle ?? '' }}">
        {{ $tim->jabatan_tim }}
    </span>

    <h6 class="fw-bold text-dark mb-0.5 fs-7.5">{{ $tim->nama }}</h6>
    
    @if($tim->nip)
        <div class="text-muted fs-9 font-monospace mb-1">NIP. {{ $tim->nip }}</div>
    @endif
    
    @if($tim->jabatan_struktural)
        <div class="text-primary fs-8 fw-semibold mb-1">{{ $tim->jabatan_struktural }}</div>
    @endif

    @if($tim->divisi && $tim->kategori_jabatan === 'bidang')
        <span class="badge bg-light text-dark border px-2 py-0.5 fs-9 rounded-2 mx-auto mb-1">
            {{ $tim->divisi }}
        </span>
    @endif

    @if($tim->tugas)
        <p class="text-muted fs-8 mt-2 mb-0 border-top pt-2 text-start lh-sm">{{ $tim->tugas }}</p>
    @endif
</div>
