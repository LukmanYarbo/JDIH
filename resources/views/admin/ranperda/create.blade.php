@extends('layouts.admin')

@section('title', 'Tambah Usulan Ranperda - JDIH DPRD')
@section('page_title', 'Tambah Usulan Ranperda (Propemperda)')

@section('content')
    <div class="row">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.ranperda.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <label for="tahun" class="form-label fs-7 fw-semibold text-muted">Tahun Propemperda</label>
                            <input type="number" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', date('Y')) }}" required>
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nomor_propemperda" class="form-label fs-7 fw-semibold text-muted">Nomor Registrasi / Urut</label>
                            <input type="text" name="nomor_propemperda" id="nomor_propemperda" class="form-control" placeholder="Contoh: PROPEMPERDA-2026/01" value="{{ old('nomor_propemperda') }}">
                        </div>
                        <div class="col-md-5">
                            <label for="pemrakarsa" class="form-label fs-7 fw-semibold text-muted">Pemrakarsa / Inisiator</label>
                            <select name="pemrakarsa" id="pemrakarsa" class="form-select @error('pemrakarsa') is-invalid @enderror" required>
                                <option value="Inisiatif DPRD" {{ old('pemrakarsa') == 'Inisiatif DPRD' ? 'selected' : '' }}>Inisiatif DPRD</option>
                                <option value="Pemerintah Daerah" {{ old('pemrakarsa') == 'Pemerintah Daerah' ? 'selected' : '' }}>Pemerintah Daerah</option>
                                <option value="Komisi I DPRD" {{ old('pemrakarsa') == 'Komisi I DPRD' ? 'selected' : '' }}>Komisi I DPRD</option>
                                <option value="Komisi II DPRD" {{ old('pemrakarsa') == 'Komisi II DPRD' ? 'selected' : '' }}>Komisi II DPRD</option>
                                <option value="Komisi III DPRD" {{ old('pemrakarsa') == 'Komisi III DPRD' ? 'selected' : '' }}>Komisi III DPRD</option>
                                <option value="Bapemperda" {{ old('pemrakarsa') == 'Bapemperda' ? 'selected' : '' }}>Bapemperda</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul Rancangan Peraturan Daerah (Ranperda)</label>
                        <textarea name="judul" id="judul" rows="2" class="form-control @error('judul') is-invalid @enderror" placeholder="Ketikkan judul lengkap rancangan peraturan daerah..." required>{{ old('judul') }}</textarea>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tahap_terakhir" class="form-label fs-7 fw-semibold text-muted">Tahapan Alur Saat Ini</label>
                            <select name="tahap_terakhir" id="tahap_terakhir" class="form-select @error('tahap_terakhir') is-invalid @enderror" required>
                                @foreach($tahapanLabels as $stepNum => $stepLabel)
                                    <option value="{{ $stepNum }}" {{ old('tahap_terakhir', 1) == $stepNum ? 'selected' : '' }}>
                                        Tahap {{ $stepNum }} - {{ $stepLabel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label fs-7 fw-semibold text-muted">Status Ranperda</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Dalam Pembahasan" {{ old('status') == 'Dalam Pembahasan' ? 'selected' : '' }}>Dalam Pembahasan</option>
                                <option value="Disetujui" {{ old('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditetapkan" {{ old('status') == 'Ditetapkan' ? 'selected' : '' }}>Ditetapkan</option>
                                <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Pembahasan & Penetapan -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="tanggal_mulai_pembahasan" class="form-label fs-7 fw-semibold text-muted">
                                <i class="bi bi-calendar-event me-1 text-primary"></i> Tanggal Mulai Pembahasan
                            </label>
                            <input type="date" name="tanggal_mulai_pembahasan" id="tanggal_mulai_pembahasan" class="form-control @error('tanggal_mulai_pembahasan') is-invalid @enderror" value="{{ old('tanggal_mulai_pembahasan') }}">
                            @error('tanggal_mulai_pembahasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_akhir_pembahasan" class="form-label fs-7 fw-semibold text-muted">
                                <i class="bi bi-calendar-check me-1 text-primary"></i> Tanggal Akhir Pembahasan
                            </label>
                            <input type="date" name="tanggal_akhir_pembahasan" id="tanggal_akhir_pembahasan" class="form-control @error('tanggal_akhir_pembahasan') is-invalid @enderror" value="{{ old('tanggal_akhir_pembahasan') }}">
                            @error('tanggal_akhir_pembahasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="tanggal_penetapan" class="form-label fs-7 fw-semibold text-muted">
                                <i class="bi bi-award me-1 text-success"></i> Tanggal Penetapan
                            </label>
                            <input type="date" name="tanggal_penetapan" id="tanggal_penetapan" class="form-control @error('tanggal_penetapan') is-invalid @enderror" value="{{ old('tanggal_penetapan') }}">
                            @error('tanggal_penetapan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label fs-7 fw-semibold text-muted">Keterangan / Catatan Pembahasan</label>
                        <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Catatan perkembangan rapat komisi, harmonisasi, atau hasil fasilitasi...">{{ old('keterangan') }}</textarea>
                    </div>

                    <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-paperclip me-1"></i> Berkas Lampiran Ranperda (Opsional)</h6>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="file_naskah_akademik" class="form-label fs-8 fw-semibold text-muted">File Naskah Akademik</label>
                            <input type="file" name="file_naskah_akademik" id="file_naskah_akademik" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                            <small class="text-muted fs-9">Format: PDF/DOC (Max 20MB)</small>
                        </div>
                        <div class="col-md-4">
                            <label for="file_rancangan" class="form-label fs-8 fw-semibold text-muted">File Draf Ranperda</label>
                            <input type="file" name="file_rancangan" id="file_rancangan" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                            <small class="text-muted fs-9">Format: PDF/DOC (Max 20MB)</small>
                        </div>
                        <div class="col-md-4">
                            <label for="file_evaluasi" class="form-label fs-8 fw-semibold text-muted">File Hasil Evaluasi / Fasilitasi</label>
                            <input type="file" name="file_evaluasi" id="file_evaluasi" class="form-control form-control-sm" accept=".pdf,.doc,.docx">
                            <small class="text-muted fs-9">Format: PDF/DOC (Max 20MB)</small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Ranperda</button>
                        <a href="{{ route('admin.ranperda.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
