@extends('layouts.admin')

@section('title', 'Berita Hukum - JDIH DPRD Bolmut')
@section('page_title', 'Berita Hukum')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-newspaper me-1"></i> Daftar Berita Hukum</h5>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tulis Berita
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-light p-3 rounded mb-4">
            <form action="{{ route('admin.news.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label class="form-label fs-7 fw-semibold text-muted">Cari Berita</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Judul atau kata kunci berita..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-sm btn-primary px-4 rounded-pill w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th style="width: 100px;">Gambar</th>
                        <th>Judul Berita</th>
                        <th>Penulis</th>
                        <th>Tanggal Terbit</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr class="fs-7.5">
                            <td>
                                @if($item->gambar)
                                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" class="rounded" style="width: 60px; height: 45px; object-fit: cover;">
                                @else
                                    <div class="bg-light text-muted rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                        <i class="bi bi-image text-muted fs-6"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('portal.news.show', $item->slug) }}" target="_blank" class="text-dark fw-bold text-decoration-none hover-text-primary">
                                    {{ Str::limit($item->judul, 90) }}
                                </a>
                            </td>
                            <td class="text-muted">{{ $item->user->name }}</td>
                            <td class="text-muted">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="m-0">
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
                            <td colspan="5" class="text-center py-4 text-muted">Belum ada berita terbit.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {!! $news->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </div>
@endsection
