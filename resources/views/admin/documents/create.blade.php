@extends('layouts.admin')

@section('title', 'Tambah Dokumen - JDIH DPRD Bolmut')
@section('page_title', 'Tambah Dokumen')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="jenis_dokumen_id" class="form-label fs-7 fw-semibold text-muted">Kategori Dokumen</label>
                            <select name="jenis_dokumen_id" id="jenis_dokumen_id" class="form-select @error('jenis_dokumen_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nama }} ({{ $cat->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="nomor" class="form-label fs-7 fw-semibold text-muted">Nomor Dokumen</label>
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" placeholder="Contoh: 1" value="{{ old('nomor') }}" required>
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="tahun" class="form-label fs-7 fw-semibold text-muted">Tahun Dokumen</label>
                            <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Contoh: 2026" value="{{ old('tahun', date('Y')) }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Dokumen</label>
                        <textarea name="judul" id="judul" rows="2" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul lengkap produk hukum..." required>{{ old('judul') }}</textarea>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tanggal_ditetapkan" class="form-label fs-7 fw-semibold text-muted">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-control @error('tanggal_ditetapkan') is-invalid @enderror" value="{{ old('tanggal_ditetapkan') }}">
                            @error('tanggal_ditetapkan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fs-7 fw-semibold text-muted">Status Hukum</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Berlaku" {{ old('status') == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                                <option value="Tidak Berlaku" {{ old('status') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                                <option value="Diubah" {{ old('status') == 'Diubah' ? 'selected' : '' }}>Diubah</option>
                                <option value="Mencabut" {{ old('status') == 'Mencabut' ? 'selected' : '' }}>Mencabut</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label fs-7 fw-semibold text-muted">Upload File PDF</label>
                        <input type="file" name="file_pdf" id="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror" accept="application/pdf">
                        <small class="text-muted fs-8">Maksimum ukuran file: 20MB. Format harus berkas .PDF</small>
                        @error('file_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="abstrak" class="form-label fs-7 fw-semibold text-muted">Abstrak / Ringkasan</label>
                        <textarea name="abstrak" id="abstrak" rows="5" class="form-control @error('abstrak') is-invalid @enderror" placeholder="Ketikkan ringkasan pokok-pokok penting peraturan...">{{ old('abstrak') }}</textarea>
                        @error('abstrak')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Dokumen</button>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
