@extends('layouts.admin')

@section('title', 'Edit Dokumen - JDIH DPRD')
@section('page_title', 'Edit Dokumen Hukum')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jenis_dokumen_id" class="form-label fs-7 fw-semibold text-muted">Kategori Dokumen</label>
                            <select name="jenis_dokumen_id" id="jenis_dokumen_id" class="form-select @error('jenis_dokumen_id') is-invalid @enderror" required>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('jenis_dokumen_id', $document->jenis_dokumen_id) == $cat->id ? 'selected' : '' }}>
                                        [{{ $cat->tipe_dokumen }}] {{ $cat->nama }} ({{ $cat->kode }})
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_dokumen_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="nomor" class="form-label fs-7 fw-semibold text-muted">Nomor Dokumen</label>
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" value="{{ old('nomor', $document->nomor) }}" required>
                            @error('nomor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="tahun" class="form-label fs-7 fw-semibold text-muted">Tahun Dokumen</label>
                            <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $document->tahun) }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Lengkap Dokumen</label>
                        <textarea name="judul" id="judul" rows="2" class="form-control @error('judul') is-invalid @enderror" required>{{ old('judul', $document->judul) }}</textarea>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label for="tanggal_ditetapkan" class="form-label fs-7 fw-semibold text-muted">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-control" value="{{ old('tanggal_ditetapkan', $document->tanggal_ditetapkan ? $document->tanggal_ditetapkan->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_pengundangan" class="form-label fs-7 fw-semibold text-muted">Tanggal Pengundangan</label>
                            <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control" value="{{ old('tanggal_pengundangan', $document->tanggal_pengundangan ? $document->tanggal_pengundangan->format('Y-m-d') : '') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="penandatangan" class="form-label fs-7 fw-semibold text-muted">Penandatangan</label>
                            <input type="text" name="penandatangan" id="penandatangan" class="form-control" value="{{ old('penandatangan', $document->penandatangan) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="pemrakarsa" class="form-label fs-7 fw-semibold text-muted">Pemrakarsa / Pengusul</label>
                            <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control" value="{{ old('pemrakarsa', $document->pemrakarsa) }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="tempat_terbit" class="form-label fs-7 fw-semibold text-muted">Tempat Terbit</label>
                            <input type="text" name="tempat_terbit" id="tempat_terbit" class="form-control" value="{{ old('tempat_terbit', $document->tempat_terbit) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="sumber" class="form-label fs-7 fw-semibold text-muted">Sumber / Lembaran Daerah</label>
                            <input type="text" name="sumber" id="sumber" class="form-control" value="{{ old('sumber', $document->sumber) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="bidang_hukum" class="form-label fs-7 fw-semibold text-muted">Bidang Hukum</label>
                            <input type="text" name="bidang_hukum" id="bidang_hukum" class="form-control" value="{{ old('bidang_hukum', $document->bidang_hukum) }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="subjek" class="form-label fs-7 fw-semibold text-muted">Subjek / Kata Kunci</label>
                            <input type="text" name="subjek" id="subjek" class="form-control" value="{{ old('subjek', $document->subjek) }}">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label fs-7 fw-semibold text-muted">Status Hukum</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="Berlaku" {{ old('status', $document->status) == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                                <option value="Mengubah" {{ old('status', $document->status) == 'Mengubah' ? 'selected' : '' }}>Mengubah</option>
                                <option value="Diubah" {{ old('status', $document->status) == 'Diubah' ? 'selected' : '' }}>Diubah</option>
                                <option value="Dicabut" {{ old('status', $document->status) == 'Dicabut' ? 'selected' : '' }}>Dicabut</option>
                                <option value="Mencabut" {{ old('status', $document->status) == 'Mencabut' ? 'selected' : '' }}>Mencabut</option>
                                <option value="Tidak Berlaku" {{ old('status', $document->status) == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="bahasa" class="form-label fs-7 fw-semibold text-muted">Bahasa</label>
                            <input type="text" name="bahasa" id="bahasa" class="form-control" value="{{ old('bahasa', $document->bahasa) }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_status" class="form-label fs-7 fw-semibold text-muted">Keterangan / Hubungan Status</label>
                        <input type="text" name="keterangan_status" id="keterangan_status" class="form-control" value="{{ old('keterangan_status', $document->keterangan_status) }}">
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label fs-7 fw-semibold text-muted">Upload File Naskah PDF Baru</label>
                        @if($document->file_pdf)
                            <div class="mb-2 fs-8 text-success">
                                <i class="bi bi-check-circle-fill"></i> Berkas terpasang: {{ $document->file_pdf }} ({{ $document->file_size }})
                            </div>
                        @endif
                        <input type="file" name="file_pdf" id="file_pdf" class="form-control" accept="application/pdf">
                        <small class="text-muted fs-8">Biarkan kosong jika tidak ingin mengubah berkas.</small>
                    </div>

                    <div class="mb-4">
                        <label for="abstrak" class="form-label fs-7 fw-semibold text-muted">Abstrak / Ringkasan Pokok Pikiran</label>
                        <textarea name="abstrak" id="abstrak" rows="4" class="form-control">{{ old('abstrak', $document->abstrak) }}</textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
