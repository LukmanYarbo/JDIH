@extends('layouts.admin')

@section('title', 'Edit Agenda Kegiatan - JDIH DPRD')
@section('page_title', 'Edit Jadwal & Agenda Kegiatan DPRD')

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.agendas.update', $agenda->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label fs-7 fw-semibold text-muted">Judul / Nama Kegiatan Rapat</label>
                        <textarea name="judul" id="judul" rows="2" class="form-control @error('judul') is-invalid @enderror" required>{{ old('judul', $agenda->judul) }}</textarea>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="waktu_mulai" class="form-label fs-7 fw-semibold text-muted">Waktu &amp; Tanggal Mulai</label>
                            <input type="datetime-local" name="waktu_mulai" id="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" value="{{ old('waktu_mulai', $agenda->waktu_mulai ? $agenda->waktu_mulai->format('Y-m-d\TH:i') : '') }}" required>
                            @error('waktu_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="waktu_selesai" class="form-label fs-7 fw-semibold text-muted">Waktu &amp; Tanggal Selesai (Opsional)</label>
                            <input type="datetime-local" name="waktu_selesai" id="waktu_selesai" class="form-control @error('waktu_selesai') is-invalid @enderror" value="{{ old('waktu_selesai', $agenda->waktu_selesai ? $agenda->waktu_selesai->format('Y-m-d\TH:i') : '') }}">
                            @error('waktu_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="pelaksana" class="form-label fs-7 fw-semibold text-muted">Penyelenggara / Pelaksana</label>
                            <select name="pelaksana" id="pelaksana" class="form-select @error('pelaksana') is-invalid @enderror">
                                <option value="Pimpinan DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Pimpinan DPRD' ? 'selected' : '' }}>Pimpinan DPRD</option>
                                <option value="Badan Musyawarah (Banmus)" {{ old('pelaksana', $agenda->pelaksana) == 'Badan Musyawarah (Banmus)' ? 'selected' : '' }}>Badan Musyawarah (Banmus)</option>
                                <option value="Bapemperda" {{ old('pelaksana', $agenda->pelaksana) == 'Bapemperda' ? 'selected' : '' }}>Bapemperda</option>
                                <option value="Badan Anggaran (Banggar)" {{ old('pelaksana', $agenda->pelaksana) == 'Badan Anggaran (Banggar)' ? 'selected' : '' }}>Badan Anggaran (Banggar)</option>
                                <option value="Badan Kehormatan (BK)" {{ old('pelaksana', $agenda->pelaksana) == 'Badan Kehormatan (BK)' ? 'selected' : '' }}>Badan Kehormatan (BK)</option>
                                <option value="Komisi I DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Komisi I DPRD' ? 'selected' : '' }}>Komisi I DPRD</option>
                                <option value="Komisi II DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Komisi II DPRD' ? 'selected' : '' }}>Komisi II DPRD</option>
                                <option value="Komisi III DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Komisi III DPRD' ? 'selected' : '' }}>Komisi III DPRD</option>
                                <option value="Pansus DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Pansus DPRD' ? 'selected' : '' }}>Pansus DPRD</option>
                                <option value="Sekretariat DPRD" {{ old('pelaksana', $agenda->pelaksana) == 'Sekretariat DPRD' ? 'selected' : '' }}>Sekretariat DPRD</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="mitra_kerja" class="form-label fs-7 fw-semibold text-muted">Mitra Kerja / OPD Terkait</label>
                            <input type="text" name="mitra_kerja" id="mitra_kerja" class="form-control @error('mitra_kerja') is-invalid @enderror" placeholder="Contoh: TAPD / BPKPD / Inspektorat..." value="{{ old('mitra_kerja', $agenda->mitra_kerja) }}">
                            @error('mitra_kerja')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="status" class="form-label fs-7 fw-semibold text-muted">Status Kegiatan</label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="Akan Datang" {{ old('status', $agenda->status) == 'Akan Datang' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="Sedang Berlangsung" {{ old('status', $agenda->status) == 'Sedang Berlangsung' ? 'selected' : '' }}>Sedang Berlangsung</option>
                                <option value="Selesai" {{ old('status', $agenda->status) == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditunda" {{ old('status', $agenda->status) == 'Ditunda' ? 'selected' : '' }}>Ditunda</option>
                                <option value="Dibatalkan" {{ old('status', $agenda->status) == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label fs-7 fw-semibold text-muted">Lokasi / Ruang Sidang</label>
                        <input type="text" name="lokasi" id="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi', $agenda->lokasi) }}">
                    </div>

                    <div class="mb-4">
                        <label for="deskripsi" class="form-label fs-7 fw-semibold text-muted">Deskripsi / Agenda Pembahasan</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $agenda->deskripsi) }}</textarea>
                    </div>

                    <!-- Ticker Option Card -->
                    <div class="card bg-light border-0 p-3 rounded-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active_ticker" id="is_active_ticker" value="1" {{ old('is_active_ticker', $agenda->is_active_ticker) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-primary fs-7" for="is_active_ticker">
                                <i class="bi bi-broadcast me-1 text-warning"></i> Tampilkan di Running Agenda Ticker Bar
                            </label>
                            <small class="text-muted d-block fs-8 mt-1">
                                Jika diaktifkan, agenda ini akan otomatis berjalan di baris running text bagian atas halaman portal JDIH.
                            </small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.agendas.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
