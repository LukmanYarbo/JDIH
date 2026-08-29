@extends('layouts.admin')

@section('title', 'Kategori Dokumen - JDIH DPRD')
@section('page_title', 'Kategori & Jenis Dokumen')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </a>
            <div class="text-muted fs-8">
                Total Kategori: <strong>{{ $categories->count() }}</strong>
            </div>
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
                        <th style="width: 60px;">Urutan</th>
                        <th>Tipe Dokumen</th>
                        <th>Kode</th>
                        <th>Nama Jenis Dokumen</th>
                        <th>Jumlah Dokumen</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td class="text-center font-monospace">{{ $cat->urutan }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-9 rounded-pill">
                                    {{ $cat->tipe_dokumen }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary font-monospace">{{ $cat->kode }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $cat->nama }}</div>
                                <small class="text-muted">{{ Str::limit($cat->deskripsi, 60) }}</small>
                            </td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success fs-8 px-2 py-1 rounded-pill">
                                    {{ $cat->dokumen_hukums_count }} Dokumen
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="d-inline delete-form" data-title="Hapus Kategori Dokumen?" data-confirm="Menghapus kategori '{{ $cat->nama }}' dapat mempengaruhi relasi dokumen terkait.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus Kategori">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada kategori yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
