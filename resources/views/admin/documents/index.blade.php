@extends('layouts.admin')

@section('title', 'Dokumen Hukum - JDIH DPRD Bolmut')
@section('page_title', 'Dokumen Hukum')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-file-earmark-pdf me-1"></i> Daftar Dokumen Hukum</h5>
            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Dokumen
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-light p-3 rounded mb-4">
            <form action="{{ route('admin.documents.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label fs-7 fw-semibold text-muted">Cari Dokumen</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Judul, nomor, atau tahun..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fs-7 fw-semibold text-muted">Kategori</label>
                    <select name="jenis_dokumen_id" class="form-select form-select-sm">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-sm btn-primary px-3 rounded-pill">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.documents.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th>Kategori</th>
                        <th>Nomor/Tahun</th>
                        <th>Judul Dokumen</th>
                        <th class="text-center">File</th>
                        <th class="text-center">Kunjungan</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr class="fs-7.5">
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 fw-semibold font-monospace">
                                    {{ $doc->jenisDokumen->kode }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark fs-7">{{ $doc->nomor }} / {{ $doc->tahun }}</td>
                            <td class="text-dark">{{ Str::limit($doc->judul, 100) }}</td>
                            <td class="text-center">
                                @if($doc->file_pdf)
                                    <a href="{{ asset($doc->file_pdf) }}" target="_blank" class="text-danger" title="Lihat PDF">
                                        <i class="bi bi-file-earmark-pdf-fill fs-4"></i>
                                    </a>
                                @else
                                    <span class="text-muted"><i class="bi bi-file-earmark-lock fs-5"></i></span>
                                @endif
                            </td>
                            <td class="text-center text-muted fw-semibold">
                                <i class="bi bi-eye text-primary"></i> {{ $doc->hits }}
                            </td>
                            <td>
                                <span class="badge-status status-{{ Str::slug($doc->status) }} fs-8">
                                    {{ $doc->status }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white border" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Belum ada dokumen hukum yang terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {!! $documents->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
