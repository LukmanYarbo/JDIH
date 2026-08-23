@extends('layouts.admin')

@section('title', 'Tambah Anggota DPRD - JDIH DPRD Bolmut')
@section('page_title', 'Tambah Anggota DPRD')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.anggota.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Ketikkan nama lengkap anggota..." value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jabatan" class="form-label fs-7 fw-semibold text-muted">Jabatan</label>
                        <select name="jabatan" id="jabatan" class="form-select @error('jabatan') is-invalid @enderror" required>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="ketua" {{ old('jabatan') == 'ketua' ? 'selected' : '' }}>Ketua DPRD</option>
                            <option value="wakil_ketua" {{ old('jabatan') == 'wakil_ketua' ? 'selected' : '' }}>Wakil Ketua DPRD</option>
                            <option value="anggota" {{ old('jabatan', 'anggota') == 'anggota' ? 'selected' : '' }}>Anggota DPRD</option>
                        </select>
                        @error('jabatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fraksi" class="form-label fs-7 fw-semibold text-muted">Fraksi</label>
                                <input type="text" name="fraksi" id="fraksi" class="form-control @error('fraksi') is-invalid @enderror" placeholder="Contoh: Fraksi Partai Golkar" value="{{ old('fraksi') }}">
                                @error('fraksi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="dapil" class="form-label fs-7 fw-semibold text-muted">Dapil</label>
                                <input type="text" name="dapil" id="dapil" class="form-control @error('dapil') is-invalid @enderror" placeholder="Contoh: Dapil I Bolmut" value="{{ old('dapil') }}">
                                @error('dapil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fs-7 fw-semibold text-muted">Foto Profil</label>
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-8">Max: 2MB. Format: jpeg, png, jpg, webp</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="no_urut" class="form-label fs-7 fw-semibold text-muted">Nomor Urut</label>
                                <input type="number" name="no_urut" id="no_urut" min="0" class="form-control @error('no_urut') is-invalid @enderror" placeholder="0" value="{{ old('no_urut', 0) }}">
                                <small class="text-muted fs-8">Untuk pengurutan tampilan.</small>
                                @error('no_urut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3 pt-1">
                                <label class="form-label fs-7 fw-semibold text-muted d-block">Status Keanggotaan</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" role="switch" name="aktif" id="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                                    <label class="form-check-label fs-7" for="aktif">Aktif (tampilkan di struktur organisasi portal)</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Data</button>
                        <a href="{{ route('admin.anggota.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
