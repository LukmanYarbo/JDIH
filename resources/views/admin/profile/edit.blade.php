@extends('layouts.admin')

@section('title', 'Profil & Pengaturan Lembaga - JDIH DPRD')
@section('page_title', 'Profil Lembaga & Pengaturan JDIH')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm p-4 bg-white">
                <h5 class="fw-bold text-dark mb-4"><i class="bi bi-bank me-1"></i> Edit Profil, Dasar Hukum, SOP &amp; Informasi JDIH</h5>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show fs-7" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Left column: Text Content -->
                        <div class="col-lg-8">
                            
                            <!-- Section 1: Identitas Kantor & Sambutan Welcome -->
                            <div class="card bg-light border-0 p-3 mb-4 rounded-3">
                                <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                                    <i class="bi bi-buildings-fill me-1"></i> Identitas Nama Kantor &amp; Teks Sambutan (Welcome)
                                </h6>

                                <div class="mb-3">
                                    <label for="nama_kantor" class="form-label fs-7 fw-semibold text-dark">
                                        Nama Kantor / Lembaga Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_kantor" id="nama_kantor" class="form-control form-control-lg fs-6 fw-semibold @error('nama_kantor') is-invalid @enderror" 
                                           value="{{ old('nama_kantor', $profile->nama_kantor) }}" 
                                           placeholder="Contoh: Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara">
                                    <small class="text-muted fs-8">Nama resmi kantor/lembaga yang ditampilkan di header, dokumen, dan halaman tentang kami.</small>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="nama_singkat_kantor" class="form-label fs-7 fw-semibold text-muted">Nama Singkat / Brand Header</label>
                                        <input type="text" name="nama_singkat_kantor" id="nama_singkat_kantor" class="form-control" 
                                               value="{{ old('nama_singkat_kantor', $profile->nama_singkat_kantor) }}" 
                                               placeholder="Contoh: DPRD Kabupaten Bolaang Mongondow Utara">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nama_wilayah" class="form-label fs-7 fw-semibold text-muted">Nama Wilayah / Daerah (Huruf Kapital)</label>
                                        <input type="text" name="nama_wilayah" id="nama_wilayah" class="form-control" 
                                               value="{{ old('nama_wilayah', $profile->nama_wilayah) }}" 
                                               placeholder="Contoh: KABUPATEN BOLAANG MONGONDOW UTARA">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nama_sekretariat" class="form-label fs-7 fw-semibold text-muted">Nama Sekretariat / Pengelola</label>
                                    <input type="text" name="nama_sekretariat" id="nama_sekretariat" class="form-control" 
                                           value="{{ old('nama_sekretariat', $profile->nama_sekretariat) }}" 
                                           placeholder="Contoh: Sekretariat DPRD Kabupaten Bolaang Mongondow Utara">
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="welcome_title" class="form-label fs-7 fw-semibold text-muted">Judul Sambutan Welcome (Hero Title)</label>
                                        <input type="text" name="welcome_title" id="welcome_title" class="form-control" 
                                               value="{{ old('welcome_title', $profile->welcome_title) }}" 
                                               placeholder="JARINGAN DOKUMENTASI DAN INFORMASI HUKUM">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="welcome_subtitle" class="form-label fs-7 fw-semibold text-muted">Subjudul Sambutan Welcome (Hero Subtitle)</label>
                                        <input type="text" name="welcome_subtitle" id="welcome_subtitle" class="form-control" 
                                               value="{{ old('welcome_subtitle', $profile->welcome_subtitle) }}" 
                                               placeholder="DEWAN PERWAKILAN RAKYAT DAERAH KABUPATEN BOLAANG MONGONDOW UTARA">
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-bullseye me-1"></i> Visi &amp; Misi</h6>
                            <div class="mb-3">
                                <label for="visi" class="form-label fs-7 fw-semibold text-muted">Visi JDIH DPRD</label>
                                <textarea name="visi" id="visi" rows="2" class="form-control @error('visi') is-invalid @enderror" required>{{ old('visi', $profile->visi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="misi" class="form-label fs-7 fw-semibold text-muted">Misi JDIH DPRD</label>
                                <textarea name="misi" id="misi" rows="4" class="form-control @error('misi') is-invalid @enderror" required>{{ old('misi', $profile->misi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="maklumat_pelayanan" class="form-label fs-7 fw-semibold text-muted">Maklumat Pelayanan Informasi</label>
                                <textarea name="maklumat_pelayanan" id="maklumat_pelayanan" rows="2" class="form-control">{{ old('maklumat_pelayanan', $profile->maklumat_pelayanan) }}</textarea>
                            </div>

                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-4"><i class="bi bi-file-text me-1"></i> Dasar Hukum, SK Tim &amp; SOP</h6>
                            <div class="mb-3">
                                <label for="dasar_hukum" class="form-label fs-7 fw-semibold text-muted">Dasar Hukum Pembentukan JDIH</label>
                                <textarea name="dasar_hukum" id="dasar_hukum" rows="4" class="form-control">{{ old('dasar_hukum', $profile->dasar_hukum) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="sk_tim" class="form-label fs-7 fw-semibold text-muted">SK Tim Pengelola JDIH</label>
                                <textarea name="sk_tim" id="sk_tim" rows="3" class="form-control">{{ old('sk_tim', $profile->sk_tim) }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="sop" class="form-label fs-7 fw-semibold text-muted">Standar Operasional Prosedur (SOP)</label>
                                <textarea name="sop" id="sop" rows="4" class="form-control">{{ old('sop', $profile->sop) }}</textarea>
                            </div>

                            <h6 class="fw-bold text-primary border-bottom pb-2 mb-3"><i class="bi bi-geo-alt me-1"></i> Kontak &amp; Media Sosial</h6>
                            <div class="mb-3">
                                <label for="alamat" class="form-label fs-7 fw-semibold text-muted">Alamat Kantor</label>
                                <input type="text" name="alamat" id="alamat" class="form-control" value="{{ old('alamat', $profile->alamat) }}">
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="telepon" class="form-label fs-7 fw-semibold text-muted">Nomor Telepon</label>
                                    <input type="text" name="telepon" id="telepon" class="form-control" value="{{ old('telepon', $profile->telepon) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label fs-7 fw-semibold text-muted">Email Resmi</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $profile->email) }}">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="whatsapp" class="form-label fs-7 fw-semibold text-muted">WhatsApp Hotline (+62...)</label>
                                    <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', $profile->whatsapp) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="jam_operasional" class="form-label fs-7 fw-semibold text-muted">Jam Pelayanan</label>
                                    <input type="text" name="jam_operasional" id="jam_operasional" class="form-control" value="{{ old('jam_operasional', $profile->jam_operasional) }}">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label for="facebook" class="form-label fs-7 fw-semibold text-muted">Facebook URL</label>
                                    <input type="text" name="facebook" id="facebook" class="form-control" value="{{ old('facebook', $profile->facebook) }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="instagram" class="form-label fs-7 fw-semibold text-muted">Instagram URL</label>
                                    <input type="text" name="instagram" id="instagram" class="form-control" value="{{ old('instagram', $profile->instagram) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Right column: File Uploads -->
                        <div class="col-lg-4 border-start ps-lg-4">
                            <!-- Logo Upload -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fs-7 fw-semibold text-muted mb-0">Logo DPRD / Portal</label>
                                    @if($profile->logo)
                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 fs-9 rounded-pill" onclick="confirmAction('formRemoveLogo', 'Kosongkan Logo?', 'Logo khusus akan dihapus dan kembali menggunakan logo bawaan.', 'Ya, Hapus Logo');">
                                            <i class="bi bi-trash"></i> Hapus Logo
                                        </button>
                                    @endif
                                </div>
                                <div class="mb-2 text-center">
                                    @if($profile->logo)
                                        <img src="{{ asset($profile->logo) }}" alt="Logo DPRD" class="rounded border p-2 bg-light d-block mx-auto mb-2" style="max-height: 100px; object-fit: contain;">
                                    @else
                                        <div class="bg-light rounded border p-3 text-center text-muted fs-8 mb-2">
                                            <i class="bi bi-image fs-2 d-block mb-1"></i> Belum ada logo diunggah
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                                <small class="text-muted fs-9">Format: PNG/JPG/WEBP (Maks: 2MB)</small>
                            </div>

                            <!-- Banner Header Atas Nav Bar -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fs-7 fw-semibold text-muted mb-0">
                                        <i class="bi bi-card-image text-primary me-1"></i> Gambar Banner Header (Atas Nav Bar)
                                    </label>
                                    @if($profile->banner_header)
                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 fs-9 rounded-pill" onclick="confirmAction('formRemoveBanner', 'Kembalikan Banner ke Default?', 'Gambar banner kustom akan dihapus dan portal akan kembali menggunakan banner standar JDIHN.', 'Ya, Kembalikan');">
                                            <i class="bi bi-arrow-counterclockwise"></i> Kembalikan ke Default
                                        </button>
                                    @endif
                                </div>
                                <div class="mb-2 text-center">
                                    @if($profile->banner_header)
                                        <img src="{{ asset($profile->banner_header) }}" alt="Banner Header" class="rounded border d-block mx-auto mb-2 img-fluid" style="max-height: 140px; width: 100%; object-fit: contain; object-position: center;">
                                    @else
                                        <div class="bg-light rounded border p-3 text-center text-muted fs-8 mb-2">
                                            <i class="bi bi-aspect-ratio fs-2 d-block mb-1 text-primary"></i> Belum ada banner header khusus diunggah (menggunakan banner default)
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="banner_header" class="form-control form-control-sm @error('banner_header') is-invalid @enderror" accept="image/*">
                                <small class="text-muted fs-9">Rekomendasi: 1920x200 s.d 1920x350 px (Maks: 6MB). Kosongkan untuk menggunakan banner bawaan.</small>
                                @error('banner_header')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Struktur Organisasi Upload -->
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label class="form-label fs-7 fw-semibold text-muted mb-0">Gambar Bagan Struktur Organisasi</label>
                                    @if($profile->struktur_organisasi)
                                        <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 fs-9 rounded-pill" onclick="confirmAction('formRemoveStruktur', 'Hapus Gambar Bagan?', 'Gambar bagan struktur organisasi akan dihapus dari server.', 'Ya, Hapus Bagan');">
                                            <i class="bi bi-trash"></i> Hapus Bagan
                                        </button>
                                    @endif
                                </div>
                                <div class="mb-2 text-center">
                                    @if($profile->struktur_organisasi)
                                        <img src="{{ asset($profile->struktur_organisasi) }}" alt="Struktur Organisasi" class="rounded border d-block mx-auto mb-2 img-fluid" style="max-height: 120px; object-fit: contain; object-position: center;">
                                    @else
                                        <div class="bg-light rounded border p-3 text-center text-muted fs-8 mb-2">
                                            <i class="bi bi-diagram-3 fs-2 d-block mb-1"></i> Belum ada gambar struktur
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="struktur_organisasi" class="form-control form-control-sm" accept="image/*">
                            </div>

                            <div class="mb-4">
                                <label for="sejarah" class="form-label fs-7 fw-semibold text-muted">Sejarah Singkat JDIHN</label>
                                <textarea name="sejarah" id="sejarah" rows="6" class="form-control fs-8">{{ old('sejarah', $profile->sejarah) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="border-top pt-4 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                    </div>
                </form>

                <!-- Hidden Removal Forms -->
                <form id="formRemoveBanner" action="{{ route('admin.profile.remove-image', 'banner_header') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <form id="formRemoveStruktur" action="{{ route('admin.profile.remove-image', 'struktur_organisasi') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <form id="formRemoveLogo" action="{{ route('admin.profile.remove-image', 'logo') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </div>
        </div>
    </div>
@endsection
