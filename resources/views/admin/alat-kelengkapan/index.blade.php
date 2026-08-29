@extends('layouts.admin')

@section('title', 'Alat Kelengkapan DPRD - JDIH DPRD Bolmut')
@section('page_title', 'Alat Kelengkapan DPRD')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-diagram-3 me-1"></i> Alat Kelengkapan DPRD</h5>
            <a href="{{ route('admin.alat-kelengkapan.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Alat Kelengkapan
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-light p-3 rounded mb-4">
            <form action="{{ route('admin.alat-kelengkapan.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-semibold text-muted">Cari Nama</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Ketikkan nama alat kelengkapan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fs-7 fw-semibold text-muted">Tipe</label>
                    <select name="tipe" class="form-select form-select-sm">
                        <option value="">Semua Tipe</option>
                        @foreach(\App\Models\AlatKelengkapan::TIPE_LABELS as $key => $label)
                            <option value="{{ $key }}" {{ request('tipe') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-sm btn-primary px-3 rounded-pill w-100">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.alat-kelengkapan.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th>Nama</th>
                        <th>Tipe</th>
                        <th>Keterangan</th>
                        <th class="text-center">Jumlah Anggota</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="fs-7.5">
                            <td class="fw-bold text-dark fs-7.5">{{ $item->nama }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 fw-semibold fs-8">
                                    <i class="bi {{ $item->iconTipe() }} me-1"></i> {{ $item->labelTipe() }}
                                </span>
                            </td>
                            <td class="text-muted fs-7.5">{{ $item->keterangan ? Str::limit($item->keterangan, 60) : '-' }}</td>
                            <td class="text-center">
                                <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1.5 fw-semibold fs-8">
                                    {{ $item->keanggotaans_count }} Orang
                                </span>
                            </td>
                            <td>
                                @if($item->aktif)
                                    <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 fw-semibold fs-8">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 fw-semibold fs-8">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.alat-kelengkapan.show', $item->id) }}" class="btn btn-sm btn-warning text-dark border" title="Kelola Pengurus">
                                        <i class="bi bi-person-gear"></i>
                                    </a>
                                    <a href="{{ route('admin.alat-kelengkapan.edit', $item->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.alat-kelengkapan.destroy', $item->id) }}" method="POST" class="m-0 delete-form" data-title="Hapus Alat Kelengkapan Dewan?" data-confirm="Alat Kelengkapan '{{ $item->nama }}' beserta seluruh data keanggotaannya akan dihapus permanen.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white border" title="Hapus AKD">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada data alat kelengkapan DPRD terdaftar.</td>
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
