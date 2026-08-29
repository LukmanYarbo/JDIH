@extends('layouts.admin')

@section('title', 'Edit Kategori - JDIH DPRD')
@section('page_title', 'Edit Kategori Dokumen')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="tipe_dokumen" class="form-label fs-7 fw-semibold text-muted">Tipe Dokumen Utama</label>
                        <select name="tipe_dokumen" id="tipe_dokumen" class="form-select @error('tipe_dokumen') is-invalid @enderror" required>
                            <option value="Produk Hukum" {{ old('tipe_dokumen', $category->tipe_dokumen) == 'Produk Hukum' ? 'selected' : '' }}>Produk Hukum</option>
                            <option value="Monografi Hukum" {{ old('tipe_dokumen', $category->tipe_dokumen) == 'Monografi Hukum' ? 'selected' : '' }}>Monografi Hukum</option>
                            <option value="Artikel Hukum" {{ old('tipe_dokumen', $category->tipe_dokumen) == 'Artikel Hukum' ? 'selected' : '' }}>Artikel Hukum</option>
                            <option value="Putusan Pengadilan" {{ old('tipe_dokumen', $category->tipe_dokumen) == 'Putusan Pengadilan' ? 'selected' : '' }}>Putusan Pengadilan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama Kategori</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $category->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="kode" class="form-label fs-7 fw-semibold text-muted">Kode Kategori</label>
                            <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $category->kode) }}" required>
                            @error('kode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="urutan" class="form-label fs-7 fw-semibold text-muted">Nomor Urutan</label>
                            <input type="number" name="urutan" id="urutan" class="form-control" value="{{ old('urutan', $category->urutan) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fs-7 fw-semibold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
