@extends('layouts.portal')

@section('title', 'Tentang Kami - JDIH ' . ($gProfil->nama_singkat_kantor ?? 'DPRD'))

@section('content')
    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);">
        <div class="container">
            <h2 class="fw-bold m-0"><i class="bi bi-info-circle me-2"></i> Profil JDIH</h2>
            <p class="text-white-50 m-0 fs-7">{{ $gProfil->nama_sekretariat ?? ($gProfil->nama_kantor ?? 'Sekretariat DPRD') }}</p>
        </div>
    </section>

    <!-- Content Sections -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                
                <!-- Main Profile Text -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mb-4">
                        <h3 class="fw-bold text-primary mb-3">Tentang JDIH {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}</h3>
                        <p class="text-muted fs-6 lh-lg">
                            @if(isset($gProfil) && $gProfil->sejarah)
                                {!! nl2br(e($gProfil->sejarah)) !!}
                            @else
                                Jaringan Dokumentasi dan Informasi Hukum (JDIH) {{ $gProfil->nama_sekretariat ?? ($gProfil->nama_kantor ?? 'Sekretariat DPRD') }} dibentuk sebagai wadah pendayagunaan bersama atas dokumen hukum dan informasi hukum secara tertib, terpadu, dan berkesinambungan. Hal ini merupakan bagian dari upaya peningkatan transparansi legislasi dan penguatan fungsi pelayanan publik, khususnya yang berhubungan dengan kinerja Dewan Perwakilan Rakyat Daerah.
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

                    <!-- Struktur Pimpinan DPRD -->
                    <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4">
                        <h3 class="fw-bold text-primary mb-1">Struktur Pimpinan {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}</h3>
                        <p class="text-muted fs-7 mb-4">Susunan Pimpinan {{ $gProfil->nama_kantor ?? 'DPRD' }}.</p>

                        @php
                            $pimpinanPengurus = (isset($pimpinanAk) && $pimpinanAk) ? $pimpinanAk->keanggotaans : collect();
                            $pimpinanKetua = $pimpinanPengurus->firstWhere('jabatan', 'ketua');
                            $pimpinanWakil = $pimpinanPengurus->where('jabatan', 'wakil')->values();
                            $pimpinanSekretaris = $pimpinanPengurus->firstWhere('jabatan', 'sekretaris');
                            $pimpinanAnggota = $pimpinanPengurus->where('jabatan', 'anggota')->values();
                        @endphp

                        @if($pimpinanPengurus->count())
                            {{-- Sumber data: Alat Kelengkapan tipe Pimpinan DPRD --}}
                            <div class="org-chart">
                                {{-- Ketua --}}
                                @if($pimpinanKetua)
                                    <div class="d-flex justify-content-center mb-1">
                                        <div class="text-center p-4 rounded-4 shadow-sm border border-warning border-opacity-50 bg-white" style="min-width: 250px;">
                                            <img src="{{ $pimpinanKetua->anggotaDprd->foto ? asset($pimpinanKetua->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pimpinanKetua->anggotaDprd->nama).'&background=0d3b66&color=f4d35e&size=128' }}" alt="{{ $pimpinanKetua->anggotaDprd->nama }}" class="rounded-circle border border-2 border-warning shadow-sm mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                                            <h5 class="fw-bold text-dark m-0">{{ $pimpinanKetua->anggotaDprd->nama }}</h5>
                                            <span class="badge bg-warning text-dark px-3 py-1.5 mt-1 fw-semibold fs-8"><i class="bi bi-star-fill me-1"></i> Ketua DPRD</span>
                                            @if($pimpinanKetua->anggotaDprd->fraksi)<small class="text-muted d-block mt-1 fs-8">{{ $pimpinanKetua->anggotaDprd->fraksi }}</small>@endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Wakil --}}
                                @if($pimpinanWakil->count())
                                    <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                    <div class="row g-3 justify-content-center {{ $pimpinanSekretaris || $pimpinanAnggota->count() ? 'mb-1' : '' }}">
                                        @foreach($pimpinanWakil as $wakil)
                                            <div class="col-sm-6 col-lg-{{ $pimpinanWakil->count() > 1 ? 6 : 4 }}">
                                                <div class="text-center p-3 rounded-4 shadow-sm border border-primary border-opacity-25 bg-white h-100">
                                                    <img src="{{ $wakil->anggotaDprd->foto ? asset($wakil->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($wakil->anggotaDprd->nama).'&background=0d3b66&color=ffffff&size=128' }}" alt="{{ $wakil->anggotaDprd->nama }}" class="rounded-circle border border-2 border-primary border-opacity-25 shadow-sm mb-2" style="width: 72px; height: 72px; object-fit: cover;">
                                                    <h6 class="fw-bold text-dark m-0">{{ $wakil->anggotaDprd->nama }}</h6>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 mt-1 fw-semibold fs-8"><i class="bi bi-star-half me-1"></i> Wakil Ketua DPRD</span>
                                                    @if($wakil->anggotaDprd->fraksi)<small class="text-muted d-block mt-1 fs-8">{{ $wakil->anggotaDprd->fraksi }}</small>@endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Sekretaris --}}
                                @if($pimpinanSekretaris)
                                    <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                    <div class="d-flex justify-content-center {{ $pimpinanAnggota->count() ? 'mb-1' : '' }}">
                                        <div class="text-center p-3 rounded-4 shadow-sm border border-success border-opacity-50 bg-white" style="min-width: 200px;">
                                            <img src="{{ $pimpinanSekretaris->anggotaDprd->foto ? asset($pimpinanSekretaris->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($pimpinanSekretaris->anggotaDprd->nama).'&background=198754&color=ffffff&size=128' }}" alt="{{ $pimpinanSekretaris->anggotaDprd->nama }}" class="rounded-circle border border-2 border-success border-opacity-50 shadow-sm mb-2" style="width: 64px; height: 64px; object-fit: cover;">
                                            <h6 class="fw-bold text-dark m-0">{{ $pimpinanSekretaris->anggotaDprd->nama }}</h6>
                                            <span class="badge bg-success bg-opacity-10 text-success px-3 py-1.5 mt-1 fw-semibold fs-8">Sekretaris</span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Anggota --}}
                                @if($pimpinanAnggota->count())
                                    <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                    <hr class="border-top border-secondary border-opacity-10 mx-auto my-2" style="max-width: 60%;">
                                    <div class="row g-3 justify-content-center">
                                        @foreach($pimpinanAnggota as $anggotaRow)
                                            <div class="col-6 col-md-4 col-lg-3">
                                                <div class="text-center p-3 rounded-4 shadow-sm border bg-white h-100">
                                                    <img src="{{ $anggotaRow->anggotaDprd->foto ? asset($anggotaRow->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggotaRow->anggotaDprd->nama).'&background=e9ecef&color=0f172a&size=128' }}" alt="{{ $anggotaRow->anggotaDprd->nama }}" class="rounded-circle border shadow-sm mb-2" style="width: 56px; height: 56px; object-fit: cover;">
                                                    <h6 class="fw-bold text-dark m-0 fs-7.5">{{ $anggotaRow->anggotaDprd->nama }}</h6>
                                                    <small class="text-muted d-block mt-1 fs-9">{{ $anggotaRow->anggotaDprd->fraksi }}</small>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @elseif(isset($anggotaDprd) && $anggotaDprd->where('jabatan', 'ketua')->count() + $anggotaDprd->where('jabatan', 'wakil_ketua')->count())
                            {{-- Fallback: dari data Anggota DPRD (jabatan Ketua & Wakil Ketua) --}}
                            @php
                                $ketua = $anggotaDprd->firstWhere('jabatan', 'ketua');
                                $wakilKetua = $anggotaDprd->where('jabatan', 'wakil_ketua')->values();
                            @endphp

                            <div class="org-chart">
                                {{-- Ketua DPRD --}}
                                @if($ketua)
                                    <div class="d-flex justify-content-center mb-1">
                                        <div class="text-center p-4 rounded-4 shadow-sm border border-warning border-opacity-50 bg-white" style="min-width: 250px;">
                                            <img src="{{ $ketua->foto ? asset($ketua->foto) : 'https://ui-avatars.com/api/?name='.urlencode($ketua->nama).'&background=0d3b66&color=f4d35e&size=128' }}" alt="{{ $ketua->nama }}" class="rounded-circle border border-2 border-warning shadow-sm mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                                            <h5 class="fw-bold text-dark m-0">{{ $ketua->nama }}</h5>
                                            <span class="badge bg-warning text-dark px-3 py-1.5 mt-1 fw-semibold fs-8"><i class="bi bi-star-fill me-1"></i> Ketua DPRD</span>
                                            @if($ketua->fraksi)<small class="text-muted d-block mt-1 fs-8">{{ $ketua->fraksi }}</small>@endif
                                        </div>
                                    </div>
                                @endif

                                {{-- Wakil Ketua DPRD --}}
                                @if($wakilKetua->count())
                                    <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                    <div class="row g-3 justify-content-center">
                                        @foreach($wakilKetua as $wakil)
                                            <div class="col-sm-6 col-lg-{{ $wakilKetua->count() > 1 ? 6 : 4 }}">
                                                <div class="text-center p-3 rounded-4 shadow-sm border border-primary border-opacity-25 bg-white h-100">
                                                    <img src="{{ $wakil->foto ? asset($wakil->foto) : 'https://ui-avatars.com/api/?name='.urlencode($wakil->nama).'&background=0d3b66&color=ffffff&size=128' }}" alt="{{ $wakil->nama }}" class="rounded-circle border border-2 border-primary border-opacity-25 shadow-sm mb-2" style="width: 72px; height: 72px; object-fit: cover;">
                                                    <h6 class="fw-bold text-dark m-0">{{ $wakil->nama }}</h6>
                                                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 mt-1 fw-semibold fs-8"><i class="bi bi-star-half me-1"></i> Wakil Ketua DPRD</span>
                                                    @if($wakil->fraksi)<small class="text-muted d-block mt-1 fs-8">{{ $wakil->fraksi }}</small>@endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @else
                            <p class="text-muted fs-7 m-0 text-center py-4 bg-light rounded">
                                Susunan Pimpinan DPRD belum tersedia.
                            </p>
                        @endif
                    </div>

                    <!-- Struktur Alat Kelengkapan DPRD -->
                    @if(isset($alatKelengkapan) && $alatKelengkapan->count())
                        <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mb-0">
                            <h3 class="fw-bold text-primary mb-1">Struktur Alat Kelengkapan {{ $gProfil->nama_singkat_kantor ?? 'DPRD' }}</h3>
                            <p class="text-muted fs-7 mb-4">Susunan pengurus Komisi dan Badan-Badan di lingkungan {{ $gProfil->nama_kantor ?? 'DPRD' }}.</p>
                        </div>

                        @foreach($alatKelengkapan as $ak)
                            @php
                                $ketuaAk = $ak->keanggotaans->firstWhere('jabatan', 'ketua');
                                $wakilAk = $ak->keanggotaans->where('jabatan', 'wakil')->values();
                                $sekretarisAk = $ak->keanggotaans->firstWhere('jabatan', 'sekretaris');
                                $anggotaAk = $ak->keanggotaans->where('jabatan', 'anggota')->values();
                            @endphp
                            <div class="card border-0 shadow-sm p-4 p-md-5 rounded-4 mt-4">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <i class="bi {{ $ak->iconTipe() }} fs-5 text-primary"></i>
                                    <h4 class="fw-bold text-dark m-0">{{ $ak->nama }}</h4>
                                    <span class="badge bg-primary bg-opacity-10 text-primary px-2.5 py-1 fw-semibold fs-8">{{ $ak->labelTipe() }}</span>
                                </div>
                                @if($ak->keterangan)
                                    <p class="text-muted fs-7 mb-4">{!! nl2br(e($ak->keterangan)) !!}</p>
                                @else
                                    <div class="mb-4"></div>
                                @endif

                                @if($ketuaAk || $wakilAk->count() || $sekretarisAk || $anggotaAk->count())
                                    {{-- Ketua --}}
                                    @if($ketuaAk)
                                        <div class="d-flex justify-content-center mb-2">
                                            <div class="text-center p-3 rounded-4 shadow-sm border border-warning border-opacity-50 bg-white" style="min-width: 220px;">
                                                <img src="{{ $ketuaAk->anggotaDprd->foto ? asset($ketuaAk->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($ketuaAk->anggotaDprd->nama).'&background=0d3b66&color=f4d35e&size=128' }}" alt="{{ $ketuaAk->anggotaDprd->nama }}" class="rounded-circle border border-2 border-warning shadow-sm mb-2" style="width: 72px; height: 72px; object-fit: cover;">
                                                <h6 class="fw-bold text-dark m-0">{{ $ketuaAk->anggotaDprd->nama }}</h6>
                                                <span class="badge bg-warning text-dark px-3 py-1 mt-1 fw-semibold fs-8"><i class="bi bi-star-fill me-1"></i> Ketua</span>
                                                @if($ketuaAk->anggotaDprd->fraksi)<small class="text-muted d-block mt-1 fs-8">{{ $ketuaAk->anggotaDprd->fraksi }}</small>@endif
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Wakil --}}
                                    @if($wakilAk->count())
                                        <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                        <div class="row g-3 justify-content-center">
                                            @foreach($wakilAk as $wakil)
                                                <div class="col-sm-6 col-lg-{{ $wakilAk->count() > 1 ? 6 : 4 }}">
                                                    <div class="text-center p-3 rounded-4 shadow-sm border border-primary border-opacity-25 bg-white h-100">
                                                        <img src="{{ $wakil->anggotaDprd->foto ? asset($wakil->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($wakil->anggotaDprd->nama).'&background=0d3b66&color=ffffff&size=128' }}" alt="{{ $wakil->anggotaDprd->nama }}" class="rounded-circle border border-2 border-primary border-opacity-25 shadow-sm mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                                                        <h6 class="fw-bold text-dark m-0 fs-7.5">{{ $wakil->anggotaDprd->nama }}</h6>
                                                        <span class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 mt-1 fw-semibold fs-8">Wakil</span>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    {{-- Sekretaris --}}
                                    @if($sekretarisAk)
                                        <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                        <div class="d-flex justify-content-center">
                                            <div class="text-center p-3 rounded-4 shadow-sm border border-success border-opacity-50 bg-white" style="min-width: 200px;">
                                                <img src="{{ $sekretarisAk->anggotaDprd->foto ? asset($sekretarisAk->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($sekretarisAk->anggotaDprd->nama).'&background=198754&color=ffffff&size=128' }}" alt="{{ $sekretarisAk->anggotaDprd->nama }}" class="rounded-circle border border-2 border-success border-opacity-50 shadow-sm mb-2" style="width: 56px; height: 56px; object-fit: cover;">
                                                <h6 class="fw-bold text-dark m-0 fs-7.5">{{ $sekretarisAk->anggotaDprd->nama }}</h6>
                                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1 mt-1 fw-semibold fs-8">Sekretaris</span>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Anggota --}}
                                    @if($anggotaAk->count())
                                        <div class="text-center my-2"><i class="bi bi-arrow-down fs-4 text-muted d-block"></i></div>
                                        <hr class="border-top border-secondary border-opacity-10 mx-auto my-2" style="max-width: 60%;">
                                        <div class="row g-3 justify-content-center">
                                            @foreach($anggotaAk as $anggotaRow)
                                                <div class="col-6 col-md-4 col-lg-3">
                                                    <div class="text-center p-3 rounded-4 shadow-sm border bg-white h-100">
                                                        <img src="{{ $anggotaRow->anggotaDprd->foto ? asset($anggotaRow->anggotaDprd->foto) : 'https://ui-avatars.com/api/?name='.urlencode($anggotaRow->anggotaDprd->nama).'&background=e9ecef&color=0f172a&size=128' }}" alt="{{ $anggotaRow->anggotaDprd->nama }}" class="rounded-circle border shadow-sm mb-2" style="width: 52px; height: 52px; object-fit: cover;">
                                                        <h6 class="fw-bold text-dark m-0 fs-8">{{ $anggotaRow->anggotaDprd->nama }}</h6>
                                                        <small class="text-muted d-block mt-1 fs-9">{{ $anggotaRow->anggotaDprd->fraksi }}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                @else
                                    <p class="text-muted fs-7 m-0 text-center py-3 bg-light rounded">Susunan pengurus belum tersedia.</p>
                                @endif
                            </div>
                        @endforeach
                    @endif
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
                            Portal JDIH {{ $gProfil->nama_sekretariat ?? ($gProfil->nama_kantor ?? 'Sekretariat DPRD') }} ini telah terintegrasi dengan portal JDIH Nasional (JDIHN) Badan Pembinaan Hukum Nasional (BPHN) Kementerian Hukum dan HAM Republik Indonesia.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
