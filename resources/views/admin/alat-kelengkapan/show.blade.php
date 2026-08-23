@extends('layouts.admin')

@section('title', $alat_kelengkapan->nama.' - JDIH DPRD Bolmut')
@section('page_title', $alat_kelengkapan->nama)

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h5 class="fw-bold text-dark m-0">
                <i class="bi {{ $alat_kelengkapan->iconTipe() }} me-1"></i> {{ $alat_kelengkapan->nama }}
            </h5>
            <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-semibold fs-8 mt-1">{{ $alat_kelengkapan->labelTipe() }}</span>
            @if(!$alat_kelengkapan->aktif)
                <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1 fw-semibold fs-8 mt-1">Nonaktif</span>
            @endif
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.alat-kelengkapan.edit', $alat_kelengkapan->id) }}" class="btn btn-light border rounded-pill px-4">
                <i class="bi bi-pencil-square me-1"></i> Edit Info
            </a>
            <a href="{{ route('admin.alat-kelengkapan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali</a>
        </div>
    </div>

    @if($alat_kelengkapan->keterangan)
        <div class="card border-0 shadow-sm p-3 mb-4 bg-white">
            <small class="text-muted fs-7"><i class="bi bi-info-circle me-1"></i> {{ $alat_kelengkapan->keterangan }}</small>
        </div>
    @endif

    <!-- Struktur Organisasi Preview -->
    <div class="card border-0 shadow-sm p-4 bg-white mb-4">
        <h6 class="fw-bold text-dark mb-4"><i class="bi bi-diagram-2 me-1"></i> Pratinjau Struktur</h6>

        @if($pengurus['ketua'] || $pengurus['wakil']->count() || $pengurus['sekretaris'] || $pengurus['anggota']->count())
            @if($pengurus['ketua'])
                <div class="d-flex justify-content-center mb-2">
                    <div class="text-center p-3 rounded-4 shadow-sm border border-warning border-opacity-50" style="min-width: 220px;">
                        <img src="{{ $pengurus['ketua']->anggotaDprd->foto ? asset($pengurus['ketua']->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pengurus['ketua']->anggotaDprd->nama).'&background=0d3b66&color=f4d35e&size=128' }}" alt="{{ $pengurus['ketua']->anggotaDprd->nama }}" class="rounded-circle border border-2 border-warning mb-2" style="width: 72px; height: 72px; object-fit: cover;">
                        <div class="fw-bold text-dark fs-7">{{ $pengurus['ketua']->anggotaDprd->nama }}</div>
                        <span class="badge bg-warning text-dark px-3 py-1 mt-1 fw-semibold fs-8"><i class="bi bi-star-fill me-1"></i> Ketua</span>
                    </div>
                </div>
            @endif

            @if($pengurus['wakil']->count())
                <div class="text-center my-1"><i class="bi bi-arrow-down text-muted"></i></div>
                <div class="row g-2 justify-content-center mb-2">
                    @foreach($pengurus['wakil'] as $wakil)
                        <div class="col-auto">
                            <div class="text-center p-3 rounded-4 shadow-sm border border-primary border-opacity-25" style="min-width: 180px;">
                                <img src="{{ $wakil->anggotaDprd->foto ? asset($wakil->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($wakil->anggotaDprd->nama).'&background=0d3b66&color=ffffff&size=128' }}" alt="{{ $wakil->anggotaDprd->nama }}" class="rounded-circle border mb-2" style="width: 56px; height: 56px; object-fit: cover;">
                                <div class="fw-bold text-dark fs-7.5">{{ $wakil->anggotaDprd->nama }}</div>
                                <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 mt-1 fw-semibold fs-8">Wakil</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($pengurus['sekretaris'])
                <div class="text-center my-1"><i class="bi bi-arrow-down text-muted"></i></div>
                <div class="d-flex justify-content-center mb-2">
                    <div class="text-center p-3 rounded-4 shadow-sm border border-success border-opacity-50" style="min-width: 200px;">
                        <img src="{{ $pengurus['sekretaris']->anggotaDprd->foto ? asset($pengurus['sekretaris']->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pengurus['sekretaris']->anggotaDprd->nama).'&background=198754&color=ffffff&size=128' }}" alt="{{ $pengurus['sekretaris']->anggotaDprd->nama }}" class="rounded-circle border border-2 border-success border-opacity-50 mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="fw-bold text-dark fs-7.5">{{ $pengurus['sekretaris']->anggotaDprd->nama }}</div>
                        <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 mt-1 fw-semibold fs-8">Sekretaris</span>
                    </div>
                </div>
            @endif

            @if($pengurus['anggota']->count())
                <div class="text-center my-1"><i class="bi bi-arrow-down text-muted"></i></div>
                <hr class="border-top border-secondary border-opacity-10 mx-auto my-2" style="max-width: 60%;">
                <div class="row g-2 justify-content-center">
                    @foreach($pengurus['anggota'] as $anggotaRow)
                        <div class="col-auto col-md-3">
                            <div class="text-center p-2 rounded-4 border h-100">
                                <img src="{{ $anggotaRow->anggotaDprd->foto ? asset($anggotaRow->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggotaRow->anggotaDprd->nama).'&background=e9ecef&color=0f172a&size=128' }}" alt="{{ $anggotaRow->anggotaDprd->nama }}" class="rounded-circle border mb-2" style="width: 44px; height: 44px; object-fit: cover;">
                                <div class="fw-semibold text-dark fs-8">{{ $anggotaRow->anggotaDprd->nama }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @else
            <p class="text-muted fs-7 m-0 text-center py-3">Belum ada pengurus terdaftar. Tambahkan melalui formulir di bawah.</p>
        @endif
    </div>

    <!-- Manajemen Pengurus -->
    <div class="card border-0 shadow-sm p-4 bg-white mb-4">
        <h6 class="fw-bold text-dark mb-4"><i class="bi bi-person-plus me-1"></i> Tambah Pengurus</h6>
        <form action="{{ route('admin.alat-kelengkapan.anggota.store', $alat_kelengkapan->id) }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-5">
                <label class="form-label fs-7 fw-semibold text-muted">Anggota DPRD</label>
                <select name="anggota_dprd_id" class="form-select form-select-sm @error('anggota_dprd_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Anggota DPRD --</option>
                    @foreach($anggotaOptions as $option)
                        <option value="{{ $option->id }}" {{ old('anggota_dprd_id') == $option->id ? 'selected' : '' }}>{{ $option->nama }}{{ $option->fraksi ? ' ('.$option->fraksi.')' : '' }}</option>
                    @endforeach
                </select>
                @error('anggota_dprd_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($anggotaOptions->isEmpty())
                    <small class="text-danger fs-8 d-block mt-1">Semua anggota DPRD aktif sudah terdaftar di {{ $alat_kelengkapan->nama }} atau data anggota masih kosong.</small>
                @endif
            </div>
            <div class="col-md-3">
                <label class="form-label fs-7 fw-semibold text-muted">Jabatan</label>
                <select name="jabatan" class="form-select form-select-sm @error('jabatan') is-invalid @enderror" required>
                    <option value="">-- Pilih --</option>
                    @foreach(\App\Models\KeanggotaanAlatKelengkapan::JABATAN_LABELS as $key => $label)
                        <option value="{{ $key }}" {{ old('jabatan') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2">
                <label class="form-label fs-7 fw-semibold text-muted">No. Urut</label>
                <input type="number" name="no_urut" min="0" value="{{ old('no_urut', 0) }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100 rounded-pill"><i class="bi bi-plus-lg me-1"></i> Tambah</button>
            </div>
        </form>
    </div>

    <!-- Daftar Pengurus -->
    <div class="card border-0 shadow-sm p-4 bg-white">
        <h6 class="fw-bold text-dark mb-4"><i class="bi bi-list-check me-1"></i> Daftar Pengurus ({{ $alat_kelengkapan->keanggotaans->count() }} orang)</h6>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr class="text-muted fs-7">
                        <th style="width: 60px;">Foto</th>
                        <th>Nama Anggota</th>
                        <th>Fraksi / Dapil</th>
                        <th style="width: 170px;">Jabatan</th>
                        <th style="width: 100px;">No. Urut</th>
                        <th class="text-end" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alat_kelengkapan->keanggotaans as $row)
                        <tr class="fs-7.5">
                            <td>
                                @if($row->anggotaDprd->foto)
                                    <img src="{{ asset($row->anggotaDprd->foto) }}" alt="{{ $row->anggotaDprd->nama }}" class="rounded-circle border" style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle border text-muted d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-bold text-dark fs-7.5">{{ $row->anggotaDprd->nama }}</td>
                            <td class="text-muted fs-7.5">{{ $row->anggotaDprd->fraksi ?? '-' }}@if($row->anggotaDprd->dapil)<br><small>{{ $row->anggotaDprd->dapil }}</small>@endif</td>
                            <td colspan="2">
                                <form action="{{ route('admin.alat-kelengkapan.anggota.update', [$alat_kelengkapan->id, $row->id]) }}" method="POST" class="row g-1 align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-6">
                                        <select name="jabatan" class="form-select form-select-sm">
                                            @foreach(\App\Models\KeanggotaanAlatKelengkapan::JABATAN_LABELS as $key => $label)
                                                <option value="{{ $key }}" {{ $row->jabatan == $key ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('jabatan_'.$row->id)
                                            <div class="text-danger fs-8">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-3">
                                        <input type="number" name="no_urut" min="0" class="form-control form-control-sm" value="{{ $row->no_urut }}">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-sm btn-light border w-100" title="Simpan Perubahan Jabatan">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </div>
                                </form>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.alat-kelengkapan.anggota.destroy', [$alat_kelengkapan->id, $row->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus {{ $row->anggotaDprd->nama }} dari {{ $alat_kelengkapan->nama }}?')" class="m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger text-white border" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Belum ada pengurus terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
