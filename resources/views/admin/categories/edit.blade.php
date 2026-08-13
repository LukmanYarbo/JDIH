@extends('layouts.admin')

@section('title', 'Edit Kategori - JDIH DPRD Bolmut')
@section('page_title', 'Edit Kategori')

@section('content')
    <div class="row">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama Kategori</label>
                        <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Peraturan Daerah" value="{{ old('nama', $category->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kode" class="form-label fs-7 fw-semibold text-muted">Kode Kategori</label>
                        <input type="text" name="kode" id="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: PERDA" value="{{ old('kode', $category->kode) }}" required>
                        <small class="text-muted fs-8">Kode harus unik dan sebaiknya menggunakan huruf kapital.</small>
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fs-7 fw-semibold text-muted">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Penjelasan singkat mengenai kategori dokumen ini...">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
