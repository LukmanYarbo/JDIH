@extends('layouts.admin')

@section('title', 'Profil DPRD - JDIH DPRD Bolmut')
@section('page_title', 'Profil DPRD Kabupaten Bolaang Mongondow Utara')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-bank me-1"></i> Edit Profil &amp; Informasi DPRD</h5>

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left column: Text Content -->
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="visi" class="form-label fs-7 fw-semibold text-muted">Visi DPRD</label>
                                <textarea name="visi" id="visi" rows="3" class="form-control @error('visi') is-invalid @enderror" required placeholder="Tuliskan visi lembaga...">{{ old('visi', $profile->visi) }}</textarea>
                                @error('visi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="misi" class="form-label fs-7 fw-semibold text-muted">Misi DPRD</label>
                                <textarea name="misi" id="misi" rows="6" class="form-control @error('misi') is-invalid @enderror" required placeholder="Tuliskan misi lembaga (baris baru untuk setiap poin)...">{{ old('misi', $profile->misi) }}</textarea>
                                @error('misi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="sejarah" class="form-label fs-7 fw-semibold text-muted">Sejarah DPRD</label>
                                <textarea name="sejarah" id="sejarah" rows="6" class="form-control @error('sejarah') is-invalid @enderror" placeholder="Tuliskan ringkasan sejarah DPRD Bolmut...">{{ old('sejarah', $profile->sejarah) }}</textarea>
                                @error('sejarah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3"><i class="bi bi-telephone-inbound me-1"></i> Informasi Kontak &amp; Alamat</h6>
                            
                            <div class="mb-3">
                                <label for="alamat" class="form-label fs-7 fw-semibold text-muted">Alamat Kantor</label>
                                <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $profile->alamat) }}">
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="telepon" class="form-label fs-7 fw-semibold text-muted">Nomor Telepon</label>
                                    <input type="text" name="telepon" id="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $profile->telepon) }}">
                                    @error('telepon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fs-7 fw-semibold text-muted">Alamat Email Resmi</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email) }}">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Right column: File Uploads (Logo & Org Chart) -->
                        <div class="col-md-4 border-start ps-md-4">
                            <!-- Logo Upload -->
                            <div class="mb-4">
                                <label class="form-label fs-7 fw-semibold text-muted">Logo DPRD / Portal</label>
                                <div class="mb-2">
                                    @if($profile->logo)
                                        <img src="{{ asset($profile->logo) }}" alt="Logo DPRD" class="rounded border p-2 bg-light d-block mb-2" style="max-height: 120px; object-fit: contain;">
                                    @else
                                        <div class="bg-light rounded border p-4 text-center text-muted fs-8 mb-2">
                                            <i class="bi bi-image fs-1 d-block mb-1"></i> Belum ada logo diunggah
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="logo" class="form-control form-control-sm @error('logo') is-invalid @enderror" accept="image/*">
                                <small class="text-muted fs-8">Unggah file logo DPRD. Ukuran maksimal: 2MB.</small>
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Struktur Organisasi Upload -->
                            <div class="mb-4">
                                <label class="form-label fs-7 fw-semibold text-muted">Struktur Organisasi (Gambar)</label>
                                <div class="mb-2">
                                    @if($profile->struktur_organisasi)
                                        <img src="{{ asset($profile->struktur_organisasi) }}" alt="Struktur Organisasi" class="rounded border d-block mb-2 img-fluid" style="max-height: 150px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded border p-4 text-center text-muted fs-8 mb-2">
                                            <i class="bi bi-diagram-3 fs-1 d-block mb-1"></i> Belum ada gambar struktur
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="struktur_organisasi" class="form-control form-control-sm @error('struktur_organisasi') is-invalid @enderror" accept="image/*">
                                <small class="text-muted fs-8">Bagan struktur organisasi. Ukuran maksimal: 5MB.</small>
                                @error('struktur_organisasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-4 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
