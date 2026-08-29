@extends('layouts.admin')

@section('title', 'Manajemen Galeri - JDIH DPRD Bolmut')
@section('page_title', 'Manajemen Galeri')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-images me-1"></i> Galeri Foto &amp; Video</h5>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Item Galeri
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-light p-3 rounded mb-4">
            <form action="{{ route('admin.gallery.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-semibold text-muted">Cari Judul</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Ketikkan judul item..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fs-7 fw-semibold text-muted">Tipe</label>
                    <select name="tipe" class="form-select form-select-sm">
                        <option value="">Semua Tipe</option>
                        <option value="foto" {{ request('tipe') == 'foto' ? 'selected' : '' }}>Foto</option>
                        <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-sm btn-primary px-3 rounded-pill w-100">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th style="width: 100px;">Pratinjau</th>
                        <th>Judul</th>
                        <th>Tipe</th>
                        <th>Keterangan</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="fs-7.5">
                            <td>
                                @if($item->tipe === 'foto')
                                    @if($item->file_path)
                                        <img src="{{ asset($item->file_path) }}" alt="{{ $item->judul }}" class="rounded border" style="width: 70px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded border text-muted d-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                            <i class="bi bi-image fs-6"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-dark rounded border text-warning d-flex align-items-center justify-content-center" style="width: 70px; height: 50px;">
                                        <i class="bi bi-play-circle fs-4"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-dark fs-7.5">{{ $item->judul }}</td>
                            <td>
                                @if($item->tipe === 'foto')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 fw-semibold fs-8">
                                        <i class="bi bi-camera me-1"></i> Foto
                                    </span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 fw-semibold fs-8">
                                        <i class="bi bi-play-btn me-1"></i> Video
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted fs-7.5">{{ Str::limit($item->keterangan, 80) }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.gallery.edit', $item->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="m-0 delete-form" data-title="Hapus Media Galeri?" data-confirm="Media '{{ $item->judul }}' akan dihapus permanen.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white border" title="Hapus Media">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada item galeri terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {!! $items->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
