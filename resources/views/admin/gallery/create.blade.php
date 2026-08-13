@extends('layouts.admin')

@section('title', 'Tambah Galeri - JDIH DPRD Bolmut')
@section('page_title', 'Tambah Galeri')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Galeri</label>
                        <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul galeri..." value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fs-7 fw-semibold text-muted d-block">Tipe Item</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="tipeFoto" value="foto" {{ old('tipe', 'foto') == 'foto' ? 'checked' : '' }}>
                            <label class="form-check-label fs-7" for="tipeFoto">
                                <i class="bi bi-camera me-1"></i> Foto / Gambar
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipe" id="tipeVideo" value="video" {{ old('tipe') == 'video' ? 'checked' : '' }}>
                            <label class="form-check-label fs-7" for="tipeVideo">
                                <i class="bi bi-play-btn me-1"></i> Video Embed
                            </label>
                        </div>
                    </div>

                    <!-- Photo Upload Container -->
                    <div class="mb-3" id="photoGroup">
                        <label for="file_path" class="form-label fs-7 fw-semibold text-muted">Pilih Berkas Foto</label>
                        <input type="file" name="file_path" id="file_path" class="form-control @error('file_path') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-8">Max: 5MB. Format: jpeg, png, jpg, webp</small>
                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Video Embed URL Container -->
                    <div class="mb-3 d-none" id="videoGroup">
                        <label for="video_url" class="form-label fs-7 fw-semibold text-muted">URL Embed Video (e.g. YouTube)</label>
                        <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" placeholder="Contoh: https://www.youtube.com/embed/dQw4w9WgXcQ" value="{{ old('video_url') }}">
                        <small class="text-muted fs-8">Gunakan URL embed Youtube (misal URL yang mengandung kata /embed/).</small>
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="keterangan" class="form-label fs-7 fw-semibold text-muted">Keterangan / Deskripsi Singkat</label>
                        <textarea name="keterangan" id="keterangan" rows="4" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Tuliskan keterangan mengenai foto atau video ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Item</button>
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const photoGroup = document.getElementById('photoGroup');
        const videoGroup = document.getElementById('videoGroup');
        const fileInput = document.getElementById('file_path');
        const urlInput = document.getElementById('video_url');

        function toggleInputs() {
            if (document.getElementById('tipeFoto').checked) {
                photoGroup.classList.remove('d-none');
                videoGroup.classList.add('d-none');
                fileInput.required = true;
                urlInput.required = false;
            } else {
                photoGroup.classList.add('d-none');
                videoGroup.classList.remove('d-none');
                fileInput.required = false;
                urlInput.required = true;
            }
        }

        document.getElementById('tipeFoto').addEventListener('change', toggleInputs);
        document.getElementById('tipeVideo').addEventListener('change', toggleInputs);

        // Run on page load
        toggleInputs();
    </script>
@endsection
