@extends('layouts.portal')

@section('title', 'Tentang Kami - JDIH DPRD Bolmut')

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <h2 class="fw-bold m-0"><i class="bi bi-info-circle me-2"></i> Profil JDIH</h2>
            <p class="text-white-50 m-0 fs-7">Sekretariat DPRD Kabupaten Bolaang Mongondow Utara</p>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                
                <!-- Main Profile Text -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mb-4">
                        <h3 class="fw-bold text-primary mb-3">Tentang JDIH DPRD</h3>
                        <p class="text-muted fs-6 lh-lg">
                            @if(isset($gProfil) && $gProfil->sejarah)
                                {!! nl2br(e($gProfil->sejarah)) !!}
                            @else
                                Jaringan Dokumentasi dan Informasi Hukum (JDIH) Sekretariat DPRD Kabupaten Bolaang Mongondow Utara dibentuk sebagai wadah pendayagunaan bersama atas dokumen hukum dan informasi hukum secara tertib, terpadu, dan berkesinambungan. Hal ini merupakan bagian dari upaya peningkatan transparansi legislasi dan penguatan fungsi pelayanan publik, khususnya yang berhubungan dengan kinerja Dewan Perwakilan Rakyat Daerah.
                            @endif
                        </p>
                    </div>

                    <!-- Vision & Mission -->
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mb-4">
                        <h3 class="fw-bold text-primary mb-4">Visi &amp; Misi</h3>
                        
                        <h5 class="fw-bold mb-2">Visi</h5>
                        <p class="text-muted fs-6 lh-relaxed mb-4">
                            "{{ isset($gProfil) && $gProfil->visi ? $gProfil->visi : 'Mewujudkan Pelayanan Dokumentasi dan Informasi Hukum Legislatif Kabupaten Bolaang Mongondow Utara yang Profesional, Transparan, dan Berbasis Teknologi Informasi.' }}"
                        </p>

                        <h5 class="fw-bold mb-2">Misi</h5>
                        <ol class="text-muted fs-6 lh-relaxed d-flex flex-column gap-2 mb-0">
                            @if(isset($gProfil) && $gProfil->misi)
                                @foreach(explode("\n", str_replace("\r", "", $gProfil->misi)) as $misiItem)
                                    @if(trim($misiItem))
                                        <li>{{ preg_replace('/^\d+[\.\-\s]*/', '', trim($misiItem)) }}</li>
                                    @endif
                                @endforeach
                            @else
                                <li>Mendokumentasikan seluruh produk hukum DPRD secara tertib dan terkomputerisasi.</li>
                                <li>Menyediakan pelayanan informasi hukum yang cepat, mudah, dan akurat bagi publik dan pengambil kebijakan.</li>
                                <li>Meningkatkan kualitas sumber daya manusia pengelola dokumentasi hukum di Sekretariat DPRD.</li>
                                <li>Mengembangkan sinergi dan integrasi data produk hukum dengan JDIH Nasional.</li>
                            @endif
                        </ol>
                    </div>

                    <!-- Structure Organization -->
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                        <h3 class="fw-bold text-primary mb-4">Struktur Organisasi</h3>
                        
                        @if(isset($gProfil) && $gProfil->struktur_organisasi)
                            <div class="text-center">
                                <img src="{{ asset($gProfil->struktur_organisasi) }}" alt="Bagan Struktur Organisasi DPRD" class="img-fluid rounded border shadow-sm p-2">
                            </div>
                        @else
                            <p class="text-muted fs-6 mb-4">
                                Pengelolaan JDIH DPRD Kabupaten Bolaang Mongondow Utara berada di bawah pembinaan Sekretaris DPRD dan dikoordinasikan secara teknis oleh Bagian Hukum dan Perundang-undangan.
                            </p>
                            <!-- Graphic/Tree fallback -->
                            <div class="bg-light p-4 rounded text-center border">
                                <div class="fw-bold text-primary fs-5 mb-2">Sekretaris DPRD</div>
                                <div class="text-muted fs-7 mb-3">Penanggung Jawab JDIH</div>
                                <i class="bi bi-arrow-down fs-4 text-muted d-block mb-3"></i>
                                
                                <div class="row g-3 justify-content-center">
                                    <div class="col-md-6">
                                        <div class="bg-white p-3 rounded shadow-sm border border-primary border-opacity-20">
                                            <div class="fw-bold text-dark fs-6">Kabag Hukum &amp; Persidangan</div>
                                            <div class="text-muted fs-8">Koordinator Pelaksana</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <i class="bi bi-arrow-down fs-4 text-muted d-block my-3"></i>
                                
                                <div class="row g-3 justify-content-center">
                                    <div class="col-md-5">
                                        <div class="bg-white p-3 rounded shadow-sm border">
                                            <div class="fw-bold text-dark fs-7">Kasubag Perundang-undangan</div>
                                            <div class="text-muted fs-9">Pengelola Dokumentasi</div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="bg-white p-3 rounded shadow-sm border">
                                            <div class="fw-bold text-dark fs-7">Pranata Humas / TI</div>
                                            <div class="text-muted fs-9">Pengelola Sistem Informasi</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar Info / Contacts -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm p-4 rounded-4 sticky-top" style="top: 90px; z-index: 10;">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-clock me-1"></i> Jam Layanan Publik</h5>
                        <ul class="list-unstyled d-flex flex-column gap-2 text-muted fs-7 pb-3 border-bottom">
                            <li class="d-flex justify-content-between"><span>Senin - Kamis</span> <span class="fw-semibold text-dark">08:00 - 16:30 WITA</span></li>
                            <li class="d-flex justify-content-between"><span>Jumat</span> <span class="fw-semibold text-dark">08:00 - 11:30 WITA</span></li>
                            <li class="d-flex justify-content-between"><span>Sabtu &amp; Minggu</span> <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2">Tutup</span></li>
                        </ul>

                        <h5 class="fw-bold my-4 text-primary"><i class="bi bi-shield-check me-1"></i> Kontak Resmi</h5>
                        <ul class="list-unstyled d-flex flex-column gap-2 text-muted fs-7 pb-3 border-bottom">
                            <li class="d-flex align-items-start gap-2">
                                <i class="bi bi-geo-alt-fill text-primary"></i>
                                <span>{{ isset($gProfil) && $gProfil->alamat ? $gProfil->alamat : 'Jl. Trans Sulawesi, Boroko, Kab. Bolaang Mongondow Utara' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="bi bi-telephone-fill text-primary"></i>
                                <span>{{ isset($gProfil) && $gProfil->telepon ? $gProfil->telepon : '(0434) 123456' }}</span>
                            </li>
                            <li class="d-flex align-items-center gap-2">
                                <i class="bi bi-envelope-fill text-primary"></i>
                                <span class="text-break">{{ isset($gProfil) && $gProfil->email ? $gProfil->email : 'sekretariat@dprd-bolmutkab.go.id' }}</span>
                            </li>
                        </ul>

                        <h5 class="fw-bold my-4 text-primary"><i class="bi bi-shield-check me-1"></i> Legalitas Portal</h5>
                        <p class="text-muted fs-7 mb-0">
                            Portal JDIH Sekretariat DPRD Kabupaten Bolaang Mongondow Utara ini telah terintegrasi dengan portal JDIH Nasional (JDIHN) Badan Pembinaan Hukum Nasional (BPHN) Kementerian Hukum dan HAM Republik Indonesia.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
