@extends('layouts.admin')

@section('title', 'Tambah Personel Tim Pengelola - JDIH DPRD')
@section('page_title', 'Tambah Personel Tim Pengelola JDIH')

@section('content')
    <div class="row">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <form action="{{ route('admin.tim-pengelola.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- 1. Klasifikasi Tingkatan Hierarki Jabatan -->
                    <div class="card bg-light border-0 p-3 rounded-3 mb-4">
                        <label class="form-label fs-7 fw-bold text-primary mb-2">
                            <i class="bi bi-diagram-3-fill me-1"></i> Tingkatan / Klasifikasi Jabatan dalam Tim
                        </label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="kategori_jabatan" class="form-label fs-8 fw-semibold text-muted">Tingkatan Struktur</label>
                                <select name="kategori_jabatan" id="kategori_jabatan" class="form-select @error('kategori_jabatan') is-invalid @enderror" required onchange="handleKategoriChange(this.value)">
                                    <option value="pembina" {{ old('kategori_jabatan') == 'pembina' ? 'selected' : '' }}>1. Pembina (Bisa > 1 Orang)</option>
                                    <option value="penanggung_jawab" {{ old('kategori_jabatan') == 'penanggung_jawab' ? 'selected' : '' }}>2. Penanggung Jawab</option>
                                    <option value="ketua" {{ old('kategori_jabatan') == 'ketua' ? 'selected' : '' }}>3. Ketua Tim</option>
                                    <option value="wakil_ketua" {{ old('kategori_jabatan') == 'wakil_ketua' ? 'selected' : '' }}>4. Wakil Ketua Tim (Bisa > 1 Orang)</option>
                                    <option value="sekretaris" {{ old('kategori_jabatan') == 'sekretaris' ? 'selected' : '' }}>5. Sekretaris Tim</option>
                                    <option value="bidang" {{ old('kategori_jabatan', 'bidang') == 'bidang' ? 'selected' : '' }}>6. Bidang / Divisi Kerja (Ketua &amp; Anggota)</option>
                                </select>
                                @error('kategori_jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="jabatan_tim" class="form-label fs-8 fw-semibold text-muted">Nama Jabatan dalam Tim</label>
                                <input type="text" name="jabatan_tim" id="jabatan_tim" class="form-control @error('jabatan_tim') is-invalid @enderror" placeholder="Contoh: Pembina / Ketua Tim / Koordinator TI" value="{{ old('jabatan_tim', 'Ketua / Koordinator Bidang') }}" required>
                                @error('jabatan_tim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Sub-section for Bidang / Divisi -->
                        <div id="bidangOptionsWrapper" class="row g-2 mt-2 pt-2 border-top">
                            <div class="col-md-7">
                                <label for="divisi" class="form-label fs-8 fw-semibold text-muted">Nama Bidang / Divisi</label>
                                <input type="text" name="divisi" id="divisi" list="divisiList" class="form-control form-control-sm @error('divisi') is-invalid @enderror" placeholder="Pilih atau ketik nama bidang..." value="{{ old('divisi', 'Bidang Pengumpulan & Pengolahan Dokumen Hukum') }}">
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
                                        <option value="{{ $peran }}" {{ old('peran_bidang') == $peran ? 'selected' : '' }}>{{ $peran }}</option>
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
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: Drs. H. Ahmad Fauzi, M.Si" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-5">
                            <label for="nip" class="form-label fs-7 fw-semibold text-muted">NIP (Nomor Induk Pegawai)</label>
                            <input type="text" name="nip" id="nip" class="form-control font-monospace @error('nip') is-invalid @enderror" placeholder="19800101 200501 1 001" value="{{ old('nip') }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="jabatan_struktural" class="form-label fs-7 fw-semibold text-muted">Jabatan Struktural / Kedinasan di DPRD</label>
                            <input type="text" name="jabatan_struktural" id="jabatan_struktural" class="form-control @error('jabatan_struktural') is-invalid @enderror" placeholder="Contoh: Ketua DPRD / Sekretaris DPRD / Kabag Hukum / Staf" value="{{ old('jabatan_struktural') }}">
                            @error('jabatan_struktural')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="urutan" class="form-label fs-7 fw-semibold text-muted">No Urut Tampil</label>
                            <input type="number" name="urutan" id="urutan" class="form-control @error('urutan') is-invalid @enderror" value="{{ old('urutan', 0) }}" min="0">
                            <small class="text-muted fs-9">Angka kecil tampil lebih dulu</small>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="kontak" class="form-label fs-7 fw-semibold text-muted">Kontak / No. HP</label>
                            <input type="text" name="kontak" id="kontak" class="form-control @error('kontak') is-invalid @enderror" placeholder="0812..." value="{{ old('kontak') }}">
                            @error('kontak')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label fs-7 fw-semibold text-muted">Foto Personel (Opsional)</label>
                        <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                        <small class="text-muted fs-9">Format: PNG, JPG, WEBP. Maks: 2MB.</small>
                        @error('foto')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="tugas" class="form-label fs-7 fw-semibold text-muted">Rincian Tugas &amp; Tanggung Jawab dalam Tim</label>
                        <textarea name="tugas" id="tugas" rows="3" class="form-control @error('tugas') is-invalid @enderror" placeholder="Uraian tugas pokok sesuai SK Tim...">{{ old('tugas') }}</textarea>
                    </div>

                    <div class="card bg-light border-0 p-3 rounded-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="aktif" id="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark fs-7" for="aktif">
                                Status Aktif (Tampilkan di Bagan Struktur Organisasi &amp; SK Tim)
                            </label>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Personel</button>
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
        const jabatanInput = document.getElementById('jabatan_tim');
        
        if (val === 'bidang') {
            wrapper.style.display = 'flex';
            const peran = document.getElementById('peran_bidang').value;
            jabatanInput.value = peran;
        } else {
            wrapper.style.display = 'none';
            if (val === 'pembina') jabatanInput.value = 'Pembina';
            else if (val === 'penanggung_jawab') jabatanInput.value = 'Penanggung Jawab';
            else if (val === 'ketua') jabatanInput.value = 'Ketua Tim';
            else if (val === 'wakil_ketua') jabatanInput.value = 'Wakil Ketua Tim';
            else if (val === 'sekretaris') jabatanInput.value = 'Sekretaris Tim';
        }
    }

    function handlePeranChange(val) {
        if (document.getElementById('kategori_jabatan').value === 'bidang') {
            document.getElementById('jabatan_tim').value = val;
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        handleKategoriChange(document.getElementById('kategori_jabatan').value);
    });
</script>
@endsection
