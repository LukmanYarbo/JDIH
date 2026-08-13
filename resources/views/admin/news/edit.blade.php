@extends('layouts.admin')

@section('title', 'Edit Berita - JDIH DPRD Bolmut')
@section('page_title', 'Edit Berita')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.news.update', $news->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Berita</label>
                        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul berita..." value="{{ old('judul', $news->judul) }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gambar" class="form-label fs-7 fw-semibold text-muted">Gambar Cover</label>
                        @if($news->gambar)
                            <div class="mb-2">
                                <img src="{{ asset($news->gambar) }}" alt="{{ $news->judul }}" class="rounded border" style="max-height: 150px; object-fit: cover;">
                                <small class="text-muted d-block mt-1">Cover saat ini</small>
                            </div>
                        @endif
                        <input type="file" name="gambar" id="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-8">Biarkan kosong jika tidak ingin mengubah cover. Max: 2MB. Format: jpeg, png, jpg, webp</small>
                        @error('gambar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="konten" class="form-label fs-7 fw-semibold text-muted">Konten Berita</label>
                        <textarea name="konten" id="konten" rows="12" class="form-control @error('konten') is-invalid @enderror" placeholder="Tuliskan berita lengkap di sini..." required>{{ old('konten', $news->konten) }}</textarea>
                        @error('konten')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
