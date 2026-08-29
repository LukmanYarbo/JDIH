@extends('layouts.admin')

@section('title', 'Manajemen Tim Pengelola JDIH - JDIH DPRD')
@section('page_title', 'Struktur Organisasi Tim Pengelola JDIH')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <a href="{{ route('admin.tim-pengelola.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Personel Tim Pengelola
                </a>
            </div>

            <!-- Search & Filters -->
            <form action="{{ route('admin.tim-pengelola.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="kategori_jabatan" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Tingkatan Struktur</option>
                    @foreach($kategoriJabatanOptions as $key => $label)
                        <option value="{{ $key }}" {{ request('kategori_jabatan') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="divisi" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Bidang</option>
                    @foreach($divisiOptions as $div)
                        <option value="{{ $div }}" {{ request('divisi') == $div ? 'selected' : '' }}>{{ $div }}</option>
                    @endforeach
                </select>

                <select name="aktif" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('aktif') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('aktif') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="input-group input-group-sm w-auto">
                    <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari nama / NIP / jabatan..." value="{{ request('search') }}">
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
                        <th style="width: 55px;">Foto</th>
                        <th>Nama &amp; NIP</th>
                        <th>Tingkatan &amp; Jabatan Tim</th>
                        <th>Jabatan Struktural</th>
                        <th>Bidang / Divisi Kerja</th>
                        <th class="text-center" style="width: 65px;">Urutan</th>
                        <th class="text-center" style="width: 90px;">Status</th>
                        <th class="text-end" style="width: 110px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>
                                @if($item->foto)
                                    <img src="{{ asset($item->foto) }}" alt="{{ $item->nama }}" class="rounded-circle border" style="width: 42px; height: 42px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle border d-flex align-items-center justify-content-center fw-bold" style="width: 42px; height: 42px; font-size: 15px;">
                                        {{ strtoupper(substr($item->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-7">{{ $item->nama }}</div>
                                @if($item->nip)
                                    <div class="text-muted fs-8 font-monospace">NIP. {{ $item->nip }}</div>
                                @endif
                            </td>
                            <td>
                                @if($item->kategori_jabatan === 'pembina')
                                    <span class="badge bg-warning text-dark px-2.5 py-1 fw-bold fs-8 rounded-pill">
                                        <i class="bi bi-shield-check"></i> {{ $item->jabatan_tim }}
                                    </span>
                                @elseif($item->kategori_jabatan === 'penanggung_jawab')
                                    <span class="badge bg-dark text-white px-2.5 py-1 fw-bold fs-8 rounded-pill">
                                        <i class="bi bi-star-fill text-warning"></i> {{ $item->jabatan_tim }}
                                    </span>
                                @elseif($item->kategori_jabatan === 'ketua')
                                    <span class="badge bg-primary text-white px-2.5 py-1 fw-bold fs-8 rounded-pill">
                                        <i class="bi bi-award-fill"></i> {{ $item->jabatan_tim }}
                                    </span>
                                @elseif($item->kategori_jabatan === 'wakil_ketua')
                                    <span class="badge bg-info text-dark px-2.5 py-1 fw-semibold fs-8 rounded-pill">
                                        {{ $item->jabatan_tim }}
                                    </span>
                                @elseif($item->kategori_jabatan === 'sekretaris')
                                    <span class="badge bg-teal text-white px-2.5 py-1 fw-semibold fs-8 rounded-pill" style="background-color: #0d9488;">
                                        {{ $item->jabatan_tim }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-2.5 py-1 fw-semibold fs-8 rounded-pill">
                                        {{ $item->jabatan_tim }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="text-dark fs-8">{{ $item->jabatan_struktural ?: '-' }}</span>
                            </td>
                            <td>
                                @if($item->divisi)
                                    <span class="badge bg-light text-dark border px-2 py-1 fs-9 rounded-2">
                                        <i class="bi bi-folder2 text-primary me-1"></i> {{ $item->divisi }}
                                    </span>
                                    @if($item->peran_bidang)
                                        <div class="text-muted fs-9 mt-0.5">{{ $item->peran_bidang }}</div>
                                    @endif
                                @else
                                    <span class="text-muted fs-8">-</span>
                                @endif
                            </td>
                            <td class="text-center font-monospace fs-8 text-muted">
                                {{ $item->urutan }}
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.tim-pengelola.toggle-active', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($item->aktif)
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-2.5 py-0.5 fs-9" title="Klik untuk nonaktifkan">
                                            <i class="bi bi-check-circle"></i> Aktif
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-0.5 fs-9" title="Klik untuk aktifkan">
                                            <i class="bi bi-dash-circle"></i> Nonaktif
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.tim-pengelola.edit', $item->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.tim-pengelola.destroy', $item->id) }}" method="POST" class="d-inline delete-form" data-title="Hapus Personel Tim Pengelola?" data-confirm="Data personel '{{ $item->nama }}' ({{ $item->jabatan_tim }}) akan dihapus permanen.">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                Belum ada personil Tim Pengelola JDIH yang didaftarkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $items->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
