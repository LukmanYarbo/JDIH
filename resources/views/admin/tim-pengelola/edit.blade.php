@extends('layouts.admin')

@section('title', 'Edit Personel Tim Pengelola - JDIH DPRD')
@section('page_title', 'Edit Personel Tim Pengelola JDIH')

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.tim-pengelola.update', $tim_pengelola->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- 1. Klasifikasi Tingkatan Hierarki Jabatan -->
                    <div class="card bg-light border-0 p-3 rounded-3 mb-4">
                        <label class="form-label fs-7 fw-bold text-primary mb-2">
                            <i class="bi bi-diagram-3-fill me-1"></i> Tingkatan / Klasifikasi Jabatan dalam Tim
                        </label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="kategori_jabatan" class="form-label fs-8 fw-semibold text-muted">Tingkatan Struktur</label>
                                <select name="kategori_jabatan" id="kategori_jabatan" class="form-select @error('kategori_jabatan') is-invalid @enderror" required onchange="handleKategoriChange(this.value)">
                                    <option value="pembina" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'pembina' ? 'selected' : '' }}>1. Pembina (Bisa > 1 Orang)</option>
                                    <option value="penanggung_jawab" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'penanggung_jawab' ? 'selected' : '' }}>2. Penanggung Jawab</option>
                                    <option value="ketua" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'ketua' ? 'selected' : '' }}>3. Ketua Tim</option>
                                    <option value="wakil_ketua" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'wakil_ketua' ? 'selected' : '' }}>4. Wakil Ketua Tim (Bisa > 1 Orang)</option>
                                    <option value="sekretaris" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'sekretaris' ? 'selected' : '' }}>5. Sekretaris Tim</option>
                                    <option value="bidang" {{ old('kategori_jabatan', $tim_pengelola->kategori_jabatan) == 'bidang' ? 'selected' : '' }}>6. Bidang / Divisi Kerja (Ketua &amp; Anggota)</option>
                                </select>
                                @error('kategori_jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jabatan_tim" class="form-label fs-8 fw-semibold text-muted">Nama Jabatan dalam Tim</label>
                                <input type="text" name="jabatan_tim" id="jabatan_tim" class="form-control @error('jabatan_tim') is-invalid @enderror" value="{{ old('jabatan_tim', $tim_pengelola->jabatan_tim) }}" required>
                                @error('jabatan_tim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sub-section for Bidang / Divisi -->
                        <div id="bidangOptionsWrapper" class="row g-2 mt-2 pt-2 border-top">
                            <div class="col-md-7">
                                <label for="divisi" class="form-label fs-8 fw-semibold text-muted">Nama Bidang / Divisi</label>
                                <input type="text" name="divisi" id="divisi" list="divisiList" class="form-control form-control-sm @error('divisi') is-invalid @enderror" placeholder="Pilih atau ketik nama bidang..." value="{{ old('divisi', $tim_pengelola->divisi) }}">
                                <datalist id="divisiList">
                                    @foreach($divisiOptions as $opt)
                                        <option value="{{ $opt }}">{{ $opt }}</option>
                                    @endforeach
                                </datalist>
                                @error('divisi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <label for="peran_bidang" class="form-label fs-8 fw-semibold text-muted">Peran dalam Bidang</label>
                                <select name="peran_bidang" id="peran_bidang" class="form-select form-select-sm @error('peran_bidang') is-invalid @enderror" onchange="handlePeranChange(this.value)">
                                    @foreach($peranBidangOptions as $peran)
                                        <option value="{{ $peran }}" {{ old('peran_bidang', $tim_pengelola->peran_bidang) == $peran ? 'selected' : '' }}>{{ $peran }}</option>
                                    @endforeach
                                </select>
                                @error('peran_bidang')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 2. Data Personel -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-7">
                            <label for="nama" class="form-label fs-7 fw-semibold text-muted">Nama Lengkap &amp; Gelar</label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $tim_pengelola->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="nip" class="form-label fs-7 fw-semibold text-muted">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" name="nip" id="nip" class="form-control font-monospace @error('nip') is-invalid @enderror" value="{{ old('nip', $tim_pengelola->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jabatan_struktural" class="form-label fs-7 fw-semibold text-muted">Jabatan Struktural / Kedinasan di DPRD</label>
                            <input type="text" name="jabatan_struktural" id="jabatan_struktural" class="form-control @error('jabatan_struktural') is-invalid @enderror" value="{{ old('jabatan_struktural', $tim_pengelola->jabatan_struktural) }}">
                            @error('jabatan_struktural')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="urutan" class="form-label fs-7 fw-semibold text-muted">No Urut Tampil</label>
                            <input type="number" name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', $tim_pengelola->urutan) }}" min="0">
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="kontak" class="form-label fs-7 fw-semibold text-muted">Kontak / No. HP</label>
                            <input type="text" name="kontak" id="kontak" class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak', $tim_pengelola->kontak) }}">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fs-7 fw-semibold text-muted">Foto Personel</label>
                        @if($tim_pengelola->foto)
                            <div class="mb-2">
                                <img src="{{ asset($tim_pengelola->foto) }}" alt="{{ $tim_pengelola->nama }}" class="rounded border" style="width: 70px; height: 70px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-9">Kosongkan jika tidak ingin mengubah foto. Format: PNG, JPG, WEBP (Maks: 2MB).</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tugas" class="form-label fs-7 fw-semibold text-muted">Rincian Tugas &amp; Tanggung Jawab dalam Tim</label>
                        <textarea name="tugas" id="tugas" rows="3" class="form-control @error('tugas') is-invalid @enderror">{{ old('tugas', $tim_pengelola->tugas) }}</textarea>
                    </div>

                    <div class="card bg-light border-0 p-3 rounded-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', $tim_pengelola->aktif) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark fs-7" for="aktif">
                                Status Aktif (Tampilkan di Bagan Struktur Organisasi &amp; SK Tim)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.tim-pengelola.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function handleKategoriChange(val) {
        const wrapper = document.getElementById('bidangOptionsWrapper');
        if (val === 'bidang') {
            wrapper.style.display = 'flex';
        } else {
            wrapper.style.display = 'none';
        }
    }

    function handlePeranChange(val) {
        if (document.getElementById('kategori_jabatan').value === 'bidang') {
            document.getElementById('jabatan_tim').value = val;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        handleKategoriChange(document.getElementById('kategori_jabatan').value);
    });
</script>
@endsection
