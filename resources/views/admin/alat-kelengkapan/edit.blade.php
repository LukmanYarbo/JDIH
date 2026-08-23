@extends('layouts.admin')

@section('title', 'Edit Alat Kelengkapan DPRD - JDIH DPRD Bolmut')
@section('page_title', 'Edit Alat Kelengkapan DPRD')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.alat-kelengkapan.update', $alat_kelengkapan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Komisi I / Badan Anggaran" value="{{ old('nama', $alat_kelengkapan->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tipe" class="form-label fs-7 fw-semibold text-muted">Tipe Alat Kelengkapan</label>
                                <select name="tipe" id="tipe" class="form-select @error('tipe') is-invalid @enderror" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    @foreach(\App\Models\AlatKelengkapan::TIPE_LABELS as $key => $label)
                                        <option value="{{ $key }}" {{ old('tipe', $alat_kelengkapan->tipe) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_urut" class="form-label fs-7 fw-semibold text-muted">Nomor Urut</label>
                                <input type="number" name="no_urut" id="no_urut" min="0" class="form-control @error('no_urut') is-invalid @enderror" value="{{ old('no_urut', $alat_kelengkapan->no_urut) }}">
                                <small class="text-muted fs-8">Untuk pengurutan tampilan.</small>
                                @error('no_urut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-7 fw-semibold text-muted d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" name="aktif" id="aktif" value="1" {{ old('aktif', $alat_kelengkapan->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label fs-7" for="aktif">Aktif (tampilkan di struktur organisasi portal)</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fs-7 fw-semibold text-muted">Keterangan / Bidang Tugas Singkat</label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror">{{ old('keterangan', $alat_kelengkapan->keterangan) }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.alat-kelengkapan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
