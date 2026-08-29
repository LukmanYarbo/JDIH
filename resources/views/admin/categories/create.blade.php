@extends('layouts.admin')

@section('title', 'Tambah Kategori - JDIH DPRD')
@section('page_title', 'Tambah Kategori Dokumen')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="tipe_dokumen" class="form-label fs-7 fw-semibold text-muted">Tipe Dokumen Utama</label>
                        <select name="tipe_dokumen" id="tipe_dokumen" class="form-select @error('tipe_dokumen') is-invalid @enderror" required>
                            <option value="Produk Hukum" {{ old('tipe_dokumen') == 'Produk Hukum' ? 'selected' : '' }}>Produk Hukum</option>
                            <option value="Monografi Hukum" {{ old('tipe_dokumen') == 'Monografi Hukum' ? 'selected' : '' }}>Monografi Hukum</option>
                            <option value="Artikel Hukum" {{ old('tipe_dokumen') == 'Artikel Hukum' ? 'selected' : '' }}>Artikel Hukum</option>
                            <option value="Putusan Pengadilan" {{ old('tipe_dokumen') == 'Putusan Pengadilan' ? 'selected' : '' }}>Putusan Pengadilan</option>
                        </select>
                        @error('tipe_dokumen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama Jenis Produk Hukum</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Peraturan Daerah" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kode" class="form-label fs-7 fw-semibold text-muted">Kode Unik Kategori</label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: PERDA" value="{{ old('kode') }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="urutan" class="form-label fs-7 fw-semibold text-muted">Nomor Urutan Tampilan</label>
                            <input type="number" name="urutan" id="urutan" class="form-control" placeholder="1, 2, 3..." value="{{ old('urutan', 1) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fs-7 fw-semibold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Penjelasan singkat mengenai kategori dokumen ini...">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Kategori</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
