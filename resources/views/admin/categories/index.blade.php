@extends('layouts.admin')

@section('title', 'Kategori Dokumen - JDIH DPRD Bolmut')
@section('page_title', 'Kategori Dokumen')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-tags me-1"></i> Daftar Kategori</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th style="width: 80px;">Kode</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th class="text-center" style="width: 150px;">Total Dokumen</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr class="fs-7.5">
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 fw-semibold font-monospace fs-7">
                                    {{ $cat->kode }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark fs-6">{{ $cat->nama }}</td>
                            <td class="text-muted">{{ $cat->deskripsi ?: '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border px-3 py-1.5 fw-bold fs-7">
                                    {{ $cat->dokumen_hukums_count }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.categories.edit', $cat->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua dokumen yang terkait juga akan dihapus!')" class="m-0">
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
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada kategori dokumen.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
