@extends('layouts.admin')

@section('title', 'Manajemen Anggota DPRD - JDIH DPRD Bolmut')
@section('page_title', 'Manajemen Anggota DPRD')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
            <h5 class="fw-bold text-dark m-0"><i class="bi bi-people-fill me-1"></i> Data Anggota DPRD</h5>
            <a href="{{ route('admin.anggota.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-1"></i> Tambah Anggota
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-light p-3 rounded mb-4">
            <form action="{{ route('admin.anggota.index') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-6">
                    <label class="form-label fs-7 fw-semibold text-muted">Cari Nama / Fraksi / Dapil</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Ketikkan nama, fraksi, atau dapil..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label fs-7 fw-semibold text-muted">Jabatan</label>
                    <select name="jabatan" class="form-select form-select-sm">
                        <option value="">Semua Jabatan</option>
                        @foreach(\App\Models\AnggotaDprd::JABATAN_LABELS as $key => $label)
                            <option value="{{ $key }}" {{ request('jabatan') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-sm btn-primary px-3 rounded-pill w-100">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.anggota.index') }}" class="btn btn-sm btn-outline-secondary px-3 rounded-pill w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th style="width: 70px;">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Fraksi</th>
                        <th>Dapil</th>
                        <th class="text-center">Urut</th>
                        <th>Status</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr class="fs-7.5">
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle border text-muted d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-dark fs-7.5">{{ $item->nama }}</td>
                            <td>
                                @if($item->jabatan === 'ketua')
                                    <span class="badge bg-warning text-dark px-2.5 py-1.5 fw-semibold fs-8">
                                        <i class="bi bi-star-fill me-1"></i> Ketua DPRD
                                    </span>
                                @elseif($item->jabatan === 'wakil_ketua')
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1.5 fw-semibold fs-8">
                                        <i class="bi bi-star-half me-1"></i> Wakil Ketua DPRD
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1.5 fw-semibold fs-8">
                                        Anggota DPRD
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted fs-7.5">{{ $item->fraksi ?? '-' }}</td>
                            <td class="text-muted fs-7.5">{{ $item->dapil ?? '-' }}</td>
                            <td class="text-center text-muted fs-7.5">{{ $item->no_urut }}</td>
                            <td>
                                @if($item->aktif)
                                    <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 fw-semibold fs-8">Aktif</span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 fw-semibold fs-8">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.anggota.edit', $item->id) }}" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('admin.anggota.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?')" class="m-0">
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
                            <td colspan="8" class="text-center py-4 text-muted">Belum ada data anggota DPRD terdaftar.</td>
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
