@extends('layouts.admin')

@section('title', 'Tambah Dokumen - JDIH DPRD')
@section('page_title', 'Tambah Dokumen Hukum')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jenis_dokumen_id" class="form-label fs-7 fw-semibold text-muted">Kategori Dokumen</label>
                            <select name="jenis_dokumen_id" id="jenis_dokumen_id" class="form-select @error('jenis_dokumen_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('jenis_dokumen_id') == $cat->id ? 'selected' : '' }}>
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
                            <input type="text" name="nomor" id="nomor" class="form-control @error('nomor') is-invalid @enderror" placeholder="Contoh: 1/2026" value="{{ old('nomor') }}" required>
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
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Lengkap Dokumen</label>
                        <textarea name="judul" id="judul" rows="2" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul lengkap produk hukum..." required>{{ old('judul') }}</textarea>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label for="tanggal_ditetapkan" class="form-label fs-7 fw-semibold text-muted">Tanggal Ditetapkan</label>
                            <input type="date" name="tanggal_ditetapkan" id="tanggal_ditetapkan" class="form-control @error('tanggal_ditetapkan') is-invalid @enderror" value="{{ old('tanggal_ditetapkan') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="tanggal_pengundangan" class="form-label fs-7 fw-semibold text-muted">Tanggal Pengundangan</label>
                            <input type="date" name="tanggal_pengundangan" id="tanggal_pengundangan" class="form-control @error('tanggal_pengundangan') is-invalid @enderror" value="{{ old('tanggal_pengundangan') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="penandatangan" class="form-label fs-7 fw-semibold text-muted">Penandatangan</label>
                            <input type="text" name="penandatangan" id="penandatangan" class="form-control" placeholder="Ketua DPRD / Walikota" value="{{ old('penandatangan') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="pemrakarsa" class="form-label fs-7 fw-semibold text-muted">Pemrakarsa / Pengusul</label>
                            <input type="text" name="pemrakarsa" id="pemrakarsa" class="form-control" placeholder="DPRD / Pemda" value="{{ old('pemrakarsa') }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="tempat_terbit" class="form-label fs-7 fw-semibold text-muted">Tempat Terbit</label>
                            <input type="text" name="tempat_terbit" id="tempat_terbit" class="form-control" value="{{ old('tempat_terbit', 'Medan') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="sumber" class="form-label fs-7 fw-semibold text-muted">Sumber / Lembaran Daerah</label>
                            <input type="text" name="sumber" id="sumber" class="form-control" placeholder="Lembaran Daerah Tahun 2026 No. 1" value="{{ old('sumber') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="bidang_hukum" class="form-label fs-7 fw-semibold text-muted">Bidang Hukum</label>
                            <input type="text" name="bidang_hukum" id="bidang_hukum" class="form-control" placeholder="Hukum Tata Negara / Administrasi" value="{{ old('bidang_hukum') }}">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="subjek" class="form-label fs-7 fw-semibold text-muted">Subjek / Kata Kunci (Pisahkan dengan koma)</label>
                            <input type="text" name="subjek" id="subjek" class="form-control" placeholder="Kawasan Tanpa Rokok, Kesehatan Masyarakat" value="{{ old('subjek') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label fs-7 fw-semibold text-muted">Status Hukum</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Berlaku" {{ old('status') == 'Berlaku' ? 'selected' : '' }}>Berlaku</option>
                                <option value="Mengubah" {{ old('status') == 'Mengubah' ? 'selected' : '' }}>Mengubah</option>
                                <option value="Diubah" {{ old('status') == 'Diubah' ? 'selected' : '' }}>Diubah</option>
                                <option value="Dicabut" {{ old('status') == 'Dicabut' ? 'selected' : '' }}>Dicabut</option>
                                <option value="Mencabut" {{ old('status') == 'Mencabut' ? 'selected' : '' }}>Mencabut</option>
                                <option value="Tidak Berlaku" {{ old('status') == 'Tidak Berlaku' ? 'selected' : '' }}>Tidak Berlaku</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="bahasa" class="form-label fs-7 fw-semibold text-muted">Bahasa</label>
                            <input type="text" name="bahasa" id="bahasa" class="form-control" value="{{ old('bahasa', 'Indonesia') }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan_status" class="form-label fs-7 fw-semibold text-muted">Keterangan / Hubungan Status (Opsional)</label>
                        <input type="text" name="keterangan_status" id="keterangan_status" class="form-control" placeholder="Contoh: Mengubah Perda Nomor 3 Tahun 2014" value="{{ old('keterangan_status') }}">
                    </div>

                    <div class="mb-3">
                        <label for="file_pdf" class="form-label fs-7 fw-semibold text-muted">Upload File Naskah PDF</label>
                        <input type="file" name="file_pdf" id="file_pdf" class="form-control @error('file_pdf') is-invalid @enderror" accept="application/pdf">
                        <small class="text-muted fs-8">Maksimum ukuran file: 30MB. Format harus berkas .PDF</small>
                        @error('file_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="abstrak" class="form-label fs-7 fw-semibold text-muted">Abstrak / Ringkasan Pokok Pikiran</label>
                        <textarea name="abstrak" id="abstrak" rows="4" class="form-control @error('abstrak') is-invalid @enderror" placeholder="Ketikkan ringkasan pokok-pokok penting peraturan...">{{ old('abstrak') }}</textarea>
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
