@extends('layouts.admin')

@section('title', 'Tulis Berita - JDIH DPRD Bolmut')
@section('page_title', 'Tulis Berita')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Berita</label>
                        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul berita..." value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fs-7 fw-semibold text-muted">Gambar Cover</label>
                        <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-8">Rekomendasi ukuran: lanskap (e.g. 800x600 px). Max: 2MB. Format: jpeg, png, jpg, webp</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="konten" class="form-label fs-7 fw-semibold text-muted">Konten Berita</label>
                        <textarea name="konten" id="konten" rows="12" class="form-control @error('konten') is-invalid @enderror" placeholder="Tuliskan berita lengkap di sini..." required>{{ old('konten') }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Terbitkan Berita</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
