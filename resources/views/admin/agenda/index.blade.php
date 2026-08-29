@extends('layouts.admin')

@section('title', 'Manajemen Agenda DPRD - JDIH DPRD')
@section('page_title', 'Manajemen Jadwal & Agenda Kegiatan DPRD')

@section('content')
    <div class="card border-0 shadow-sm p-4 bg-white">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <a href="{{ route('admin.agendas.create') }}" class="btn btn-primary rounded-pill px-4">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Agenda Kegiatan
                </a>
            </div>

            <!-- Search & Filters -->
            <form action="{{ route('admin.agendas.index') }}" method="GET" class="d-flex flex-wrap gap-2">
                <select name="status" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Akan Datang" {{ request('status') == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="Sedang Berlangsung" {{ request('status') == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Ditunda" {{ request('status') == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                </select>

                <select name="ticker" class="form-select form-select-sm w-auto rounded-pill" onchange="this.form.submit()">
                    <option value="">Semua Tampilan</option>
                    <option value="1" {{ request('ticker') === '1' ? 'selected' : '' }}>Tampil di Ticker</option>
                    <option value="0" {{ request('ticker') === '0' ? 'selected' : '' }}>Tidak Tampil</option>
                </select>

                <div class="input-group input-group-sm w-auto">
                    <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari kegiatan/lokasi..." value="{{ request('search') }}">
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
                        <th style="width: 140px;">Waktu &amp; Tanggal</th>
                        <th>Judul &amp; Uraian Kegiatan</th>
                        <th>Pelaksana &amp; Lokasi</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 130px;">Ticker Bar</th>
                        <th class="text-end" style="width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agendas as $agenda)
                        <tr>
                            <td>
                                <div class="fw-bold text-primary font-monospace">
                                    <i class="bi bi-calendar-event me-1"></i> {{ $agenda->waktu_mulai->format('d/m/Y') }}
                                </div>
                                <div class="text-muted fs-8">
                                    <i class="bi bi-clock"></i> {{ $agenda->waktu_mulai->format('H:i') }} WIB
                                    @if($agenda->waktu_selesai)
                                        - {{ $agenda->waktu_selesai->format('H:i') }}
                                    @endif
                                </div>
                            </td>
                            <td style="max-width: 320px;">
                                <div class="fw-bold text-dark fs-7 mb-1">{{ $agenda->judul }}</div>
                                @if($agenda->deskripsi)
                                    <small class="text-muted d-block">{{ Str::limit($agenda->deskripsi, 80) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary fw-semibold px-2 py-1 fs-9 rounded-pill d-inline-block mb-1">
                                    <i class="bi bi-people-fill"></i> {{ $agenda->pelaksana ?: 'DPRD' }}
                                    @if($agenda->mitra_kerja)
                                        &amp; {{ $agenda->mitra_kerja }}
                                    @endif
                                </span>
                                <div class="text-muted fs-8">
                                    <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $agenda->lokasi ?: 'Gedung DPRD' }}
                                </div>
                            </td>
                            <td>
                                @if($agenda->status == 'Akan Datang')
                                    <span class="badge bg-warning text-dark px-2 py-1 fs-9 rounded-pill">
                                        <i class="bi bi-hourglass-split"></i> {{ $agenda->status }}
                                    </span>
                                @elseif($agenda->status == 'Sedang Berlangsung')
                                    <span class="badge bg-success text-white px-2 py-1 fs-9 rounded-pill">
                                        <i class="bi bi-play-circle"></i> {{ $agenda->status }}
                                    </span>
                                @elseif($agenda->status == 'Selesai')
                                    <span class="badge bg-secondary bg-opacity-25 text-dark px-2 py-1 fs-9 rounded-pill">
                                        <i class="bi bi-check2"></i> {{ $agenda->status }}
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1 fs-9 rounded-pill">
                                        {{ $agenda->status }}
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.agendas.toggle-ticker', $agenda->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($agenda->is_active_ticker)
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-2.5 py-1 fs-9" title="Klik untuk sembunyikan dari Ticker">
                                            <i class="bi bi-broadcast"></i> Tampil
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-secondary rounded-pill px-2.5 py-1 fs-9" title="Klik untuk tampilkan di Ticker">
                                            <i class="bi bi-eye-slash"></i> Sembunyi
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('portal.agenda') }}" target="_blank" class="btn btn-outline-info" title="Lihat di Portal">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.agendas.edit', $agenda->id) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.agendas.destroy', $agenda->id) }}" method="POST" class="d-inline delete-form" data-title="Hapus Agenda Kegiatan?" data-confirm="Agenda '{{ $agenda->judul }}' pada tanggal {{ $agenda->waktu_mulai->format('d/m/Y') }} akan dihapus.">
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada jadwal kegiatan DPRD yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-end">
            {{ $agendas->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
