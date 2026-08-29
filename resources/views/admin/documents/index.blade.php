@extends('layouts.admin')

@section('title', 'Manajemen Dokumen Hukum - JDIH DPRD')
@section('page_title', 'Manajemen Dokumen Hukum')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Dokumen Baru
                </a>
            </div>
            
            <!-- Search & Category Filter -->
            <form action="{{ route('admin.documents.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="tipe_dokumen" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Tipe</option>
                    <option value="Produk Hukum" {{ request('tipe_dokumen') == 'Produk Hukum' ? 'selected' : '' }}>Produk Hukum</option>
                    <option value="Monografi Hukum" {{ request('tipe_dokumen') == 'Monografi Hukum' ? 'selected' : '' }}>Monografi Hukum</option>
                    <option value="Artikel Hukum" {{ request('tipe_dokumen') == 'Artikel Hukum' ? 'selected' : '' }}>Artikel Hukum</option>
                    <option value="Putusan Pengadilan" {{ request('tipe_dokumen') == 'Putusan Pengadilan' ? 'selected' : '' }}>Putusan Pengadilan</option>
                </select>

                <select name="jenis_dokumen_id" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Jenis</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->nama }}
                        </option>
                    @endforeach
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
                        <th>Tipe / Kategori</th>
                        <th>Nomor &amp; Tahun</th>
                        <th>Judul Dokumen</th>
                        <th>Status</th>
                        <th>Statistik</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $doc)
                        <tr>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-9 rounded-pill d-inline-block mb-1">
                                    {{ $doc->tipe_dokumen }}
                                </span>
                                <div class="fw-semibold text-dark fs-8">{{ $doc->jenisDokumen->nama ?? '-' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $doc->nomor }}</div>
                                <small class="text-muted">Tahun {{ $doc->tahun }}</small>
                            </td>
                            <td style="max-width: 320px;">
                                <a href="{{ route('portal.document.show', $doc->id) }}" target="_blank" class="text-dark text-decoration-none fw-semibold d-block mb-1">
                                    {{ Str::limit($doc->judul, 80) }}
                                </a>
                                @if($doc->file_pdf)
                                    <span class="badge bg-danger bg-opacity-10 text-danger fs-9">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF ({{ $doc->file_size ?: 'Tersedia' }})
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-status status-{{ Str::slug($doc->status) }} fs-9">
                                    {{ $doc->status }}
                                </span>
                            </td>
                            <td>
                                <div class="text-muted fs-9">
                                    <div><i class="bi bi-eye"></i> {{ number_format($doc->hits) }}</div>
                                    <div><i class="bi bi-download"></i> {{ number_format($doc->downloads) }}</div>
                                </div>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('portal.document.show', $doc->id) }}" target="_blank" class="btn btn-outline-info" title="Lihat di Portal">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.documents.edit', $doc->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.documents.destroy', $doc->id) }}" method="POST" class="d-inline delete-form" data-title="Hapus Dokumen Hukum?" data-confirm="Dokumen '{{ $doc->judul }}' beserta berkas PDF akan dihapus permanen.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus Dokumen">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Tidak ada dokumen yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $documents->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
