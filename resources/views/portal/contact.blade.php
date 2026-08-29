@extends('layouts.portal')

@section('title', 'Hubungi Kami & Layanan Informasi - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">Hubungi Kami</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">Hubungi Kami &amp; Layanan Informasi Hukum</h3>
        </div>
    </section>

    <!-- Contact Details & Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Contact Info Cards (Col 5) -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white mb-4">
                        <h5 class="fw-bold text-primary mb-3">Informasi Kontak JDIH</h5>
                        <p class="text-muted fs-8 mb-4">
                            Untuk permohonan informasi hukum, salinan dokumen, kerjasama penelitian, atau pertanyaan teknis, silakan hubungi tim pengelola kami:
                        </p>

                        <div class="d-flex flex-column gap-3 fs-8">
                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-primary bg-opacity-10 text-primary p-2 rounded-circle">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Alamat Kantor:</div>
                                    <div class="text-muted">{{ $profil->alamat ?? 'Gedung DPRD, Bagian Persidangan & Perundang-Undangan Sekretariat DPRD Kota Medan, Jl. Kapten Maulana Lubis No. 1' }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle">
                                    <i class="bi bi-telephone-fill fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Telepon / Fax:</div>
                                    <div class="text-muted">{{ $profil->telepon ?? '061-4537728' }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle">
                                    <i class="bi bi-envelope-fill fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Email Resmi:</div>
                                    <div class="text-muted">{{ $profil->email ?? 'jdih@dprd.medan.go.id' }}</div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="bg-info bg-opacity-10 text-info p-2 rounded-circle">
                                    <i class="bi bi-clock-fill fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">Jam Operasional Pelayanan:</div>
                                    <div class="text-muted">{{ $profil->jam_operasional ?? 'Senin - Kamis: 08.00 - 16.00 WIB | Jumat: 08.00 - 16.30 WIB' }}</div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Contact / Inquiry Form (Col 7) -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        <h5 class="fw-bold text-primary mb-2">Kirim Pesan &amp; Permohonan Informasi</h5>
                        <p class="text-muted fs-8 mb-4">Sampaikan permohonan informasi publik atau saran pengembangan portal JDIH</p>

                        <form onsubmit="event.preventDefault(); alert('Terima kasih, pesan Anda telah terkirim ke Sekretariat JDIH DPRD.'); this.reset();">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fs-8 fw-semibold text-muted">Nama Lengkap</label>
                                    <input type="text" class="form-control fs-7" placeholder="Nama Anda" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fs-8 fw-semibold text-muted">Nomor WhatsApp / HP</label>
                                    <input type="tel" class="form-control fs-7" placeholder="08xxxxxxxxxx" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fs-8 fw-semibold text-muted">Email</label>
                                    <input type="email" class="form-control fs-7" placeholder="nama@email.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fs-8 fw-semibold text-muted">Subjek Pesan</label>
                                    <input type="text" class="form-control fs-7" placeholder="e.g. Permohonan Salinan Perda..." required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fs-8 fw-semibold text-muted">Pesan / Rincian Permohonan</label>
                                    <textarea class="form-control fs-7" rows="4" placeholder="Tuliskan pesan atau kebutuhan informasi Anda secara jelas..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2 fs-7 fw-semibold">
                                        <i class="bi bi-send-fill me-1"></i> Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
