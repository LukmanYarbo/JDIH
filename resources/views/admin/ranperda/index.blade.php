@extends('layouts.admin')

@section('title', 'Manajemen Alur Ranperda - JDIH DPRD')
@section('page_title', 'Manajemen Alur Ranperda (Propemperda)')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <a href="{{ route('admin.ranperda.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Usulan Ranperda
                </a>
            </div>

            <!-- Search & Filters -->
            <form action="{{ route('admin.ranperda.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="tahun" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $yr)
                        <option value="{{ $yr }}" {{ request('tahun') == $yr ? 'selected' : '' }}>Tahun {{ $yr }}</option>
                    @endforeach
                </select>

                <select name="status" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Dalam Pembahasan" {{ request('status') == 'Dalam Pembahasan' ? 'selected' : '' }}>Dalam Pembahasan</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditetapkan" {{ request('status') == 'Ditetapkan' ? 'selected' : '' }}>Ditetapkan</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <div class="input-group input-group-sm w-auto">
                    <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari judul/nomor..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary rounded-end-pill" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fs-7" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 fs-7">
                <thead class="table-light">
                    <tr>
                        <th>Tahun</th>
                        <th>Nomor &amp; Judul Ranperda</th>
                        <th>Pemrakarsa</th>
                        <th>Tahapan Berjalan</th>
                        <th>Status</th>
                        <th>Berkas</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ranperdas as $item)
                        <tr>
                            <td>
                                <span class="badge bg-warning text-dark fw-bold font-monospace px-2 py-1 fs-9 rounded-pill">
                                    {{ $item->tahun }}
                                </span>
                            </td>
                            <td style="max-width: 320px;">
                                @if($item->nomor_propemperda)
                                    <div class="fs-9 text-muted font-monospace">{{ $item->nomor_propemperda }}</div>
                                @endif
                                <div class="fw-bold text-dark">{{ $item->judul }}</div>
                                @if($item->keterangan)
                                    <small class="text-muted d-block mt-1">{{ Str::limit($item->keterangan, 70) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-9 rounded-pill">
                                    {{ $item->pemrakarsa }}
                                </span>
                            </td>
                            <td style="min-width: 180px;">
                                <div class="d-flex justify-content-between align-items-center mb-1 fs-9">
                                    <span class="fw-semibold text-primary">{{ $item->tahapan_name }}</span>
                                    <span class="text-muted font-monospace">{{ $item->tahap_terakhir }}/7</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    @php
                                        $pct = ($item->tahap_terakhir / 7) * 100;
                                    @endphp
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pct }}%"></div>
                                </div>
                                @if($item->tanggal_mulai_pembahasan || $item->tanggal_penetapan)
                                    <div class="mt-1 fs-9 text-muted">
                                        @if($item->tanggal_mulai_pembahasan)
                                            <div><i class="bi bi-clock-history"></i> Bahas: {{ $item->tanggal_mulai_pembahasan->format('d/m/Y') }} @if($item->tanggal_akhir_pembahasan) s.d {{ $item->tanggal_akhir_pembahasan->format('d/m/Y') }} @endif</div>
                                        @endif
                                        @if($item->tanggal_penetapan)
                                            <div class="text-success"><i class="bi bi-check-circle"></i> Tetap: {{ $item->tanggal_penetapan->format('d/m/Y') }}</div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($item->status == 'Ditetapkan' || $item->status == 'Disetujui')
                                    <span class="badge bg-success bg-opacity-10 text-success fs-9 px-2 py-1 rounded-pill">
                                        {{ $item->status }}
                                    </span>
                                @elseif($item->status == 'Ditolak')
                                    <span class="badge bg-danger bg-opacity-10 text-danger fs-9 px-2 py-1 rounded-pill">
                                        {{ $item->status }}
                                    </span>
                                @else
                                    <span class="badge bg-info bg-opacity-10 text-info fs-9 px-2 py-1 rounded-pill">
                                        {{ $item->status }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    @if($item->file_naskah_akademik)
                                        <a href="{{ asset($item->file_naskah_akademik) }}" target="_blank" class="badge bg-light text-primary border text-decoration-none" title="Naskah Akademik">
                                            <i class="bi bi-book"></i> NA
                                        </a>
                                    @endif
                                    @if($item->file_rancangan)
                                        <a href="{{ asset($item->file_rancangan) }}" target="_blank" class="badge bg-light text-success border text-decoration-none" title="Draf Rancangan">
                                            <i class="bi bi-file-earmark-text"></i> Draf
                                        </a>
                                    @endif
                                    @if($item->file_evaluasi)
                                        <a href="{{ asset($item->file_evaluasi) }}" target="_blank" class="badge bg-light text-warning border text-decoration-none" title="Fasilitasi / Evaluasi">
                                            <i class="bi bi-check2-circle"></i> Eval
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('portal.ranperda', ['tahun' => $item->tahun]) }}" target="_blank" class="btn btn-outline-info" title="Lihat di Portal">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.ranperda.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.ranperda.destroy', $item->id) }}" method="POST" class="d-inline delete-form" data-title="Hapus Usulan Ranperda?" data-confirm="Data Ranperda '{{ $item->judul }}' beserta seluruh draf lampiran akan dihapus.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus Ranperda">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                Belum ada data alur Ranperda yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $ranperdas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
