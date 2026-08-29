@extends('layouts.portal')

@php
    $pageTitles = [
        'dasar-hukum' => 'Dasar Hukum Pembentukan JDIH',
        'sk-tim' => 'Surat Keputusan (SK) Tim Pengelola JDIH',
        'struktur-organisasi' => 'Struktur Organisasi & Keanggotaan',
        'sop' => 'Standar Operasional Prosedur (SOP)',
        'visi-misi' => 'Visi, Misi & Maklumat Pelayanan',
    ];
    $currentTitle = $pageTitles[$slug] ?? 'Tentang Kami';
@endphp

@section('title', $currentTitle . ' - JDIH DPRD')

@section('content')

    <!-- Header Banner -->
    <section class="py-4 bg-primary text-white" style="background: linear-gradient(135deg, #091a2e 0%, #1e3a8a 100%);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fs-8 mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('portal.home') }}" class="text-white-50 text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item text-white-50">Tentang Kami</li>
                    <li class="breadcrumb-item active text-warning" aria-current="page">{{ $currentTitle }}</li>
                </ol>
            </nav>
            <h3 class="fw-bold mb-0 text-white">{{ $currentTitle }}</h3>
        </div>
    </section>

    <!-- Content & Sidebar Navigation -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                
                <!-- Left Nav Tabs (Col 3) -->
                <div class="col-lg-3">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white">
                        <h6 class="fw-bold text-primary mb-3 px-2">Menu Informasi</h6>
                        <div class="list-group list-group-flush fs-8">
                            <a href="{{ route('portal.about', 'dasar-hukum') }}" class="list-group-item list-group-item-action border-0 rounded-2 py-2.5 mb-1 {{ $slug == 'dasar-hukum' ? 'bg-primary text-white fw-bold' : 'text-dark' }}">
                                <i class="fa-solid fa-gavel me-2 {{ $slug == 'dasar-hukum' ? 'text-warning' : 'text-primary' }}"></i> Dasar Hukum
                            </a>
                            <a href="{{ route('portal.about', 'sk-tim') }}" class="list-group-item list-group-item-action border-0 rounded-2 py-2.5 mb-1 {{ $slug == 'sk-tim' ? 'bg-primary text-white fw-bold' : 'text-dark' }}">
                                <i class="fa-solid fa-users-gear me-2 {{ $slug == 'sk-tim' ? 'text-warning' : 'text-primary' }}"></i> SK Tim Pengelola
                            </a>
                            <a href="{{ route('portal.about', 'struktur-organisasi') }}" class="list-group-item list-group-item-action border-0 rounded-2 py-2.5 mb-1 {{ $slug == 'struktur-organisasi' ? 'bg-primary text-white fw-bold' : 'text-dark' }}">
                                <i class="fa-solid fa-sitemap me-2 {{ $slug == 'struktur-organisasi' ? 'text-warning' : 'text-primary' }}"></i> Struktur Organisasi
                            </a>
                            <a href="{{ route('portal.about', 'sop') }}" class="list-group-item list-group-item-action border-0 rounded-2 py-2.5 mb-1 {{ $slug == 'sop' ? 'bg-primary text-white fw-bold' : 'text-dark' }}">
                                <i class="fa-solid fa-arrows-rotate me-2 {{ $slug == 'sop' ? 'text-warning' : 'text-primary' }}"></i> Standar Operasional (SOP)
                            </a>
                            <a href="{{ route('portal.about', 'visi-misi') }}" class="list-group-item list-group-item-action border-0 rounded-2 py-2.5 mb-1 {{ $slug == 'visi-misi' ? 'bg-primary text-white fw-bold' : 'text-dark' }}">
                                <i class="fa-solid fa-bullseye me-2 {{ $slug == 'visi-misi' ? 'text-warning' : 'text-primary' }}"></i> Visi, Misi &amp; Maklumat
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Content Body (Col 9) -->
                <div class="col-lg-9">
                    <div class="card border-0 shadow-sm rounded-3 p-4 bg-white">
                        
                        @if($slug == 'dasar-hukum')
                            <h4 class="fw-bold text-primary mb-3">Dasar Hukum Penyelenggaraan JDIH</h4>
                            <p class="text-muted fs-7">Dasar hukum pengelolaan dan pengembangan Jaringan Dokumentasi dan Informasi Hukum (JDIH) di lingkungan Sekretariat DPRD:</p>
                            <div class="bg-light p-4 rounded-3 border mb-4">
                                <ul class="mb-0 fs-7 lh-lg ps-3 text-dark">
                                    <li><strong>Peraturan Presiden Republik Indonesia Nomor 33 Tahun 2012</strong> tentang Jaringan Dokumentasi dan Informasi Hukum Nasional (JDIHN).</li>
                                    <li><strong>Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019</strong> tentang Standar Pengelolaan Dokumen dan Informasi Hukum.</li>
                                    <li><strong>Peraturan Menteri Dalam Negeri Nomor 2 Tahun 2014</strong> tentang Pengelolaan Jaringan Dokumentasi dan Informasi Hukum Kementerian Dalam Negeri dan Pemerintah Daerah.</li>
                                    <li><strong>Undang-Undang Nomor 14 Tahun 2008</strong> tentang Keterbukaan Informasi Publik.</li>
                                    <li><strong>Undang-Undang Nomor 23 Tahun 2014</strong> tentang Pemerintahan Daerah beserta perubahannya.</li>
                                    <li><strong>Peraturan Tata Tertib DPRD</strong> tentang Pembentukan Peraturan Daerah dan Pengelolaan Risalah Persidangan.</li>
                                </ul>
                            </div>

                        @elseif($slug == 'sk-tim')
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div>
                                    <h4 class="fw-bold text-primary mb-1">Surat Keputusan (SK) Tim Pengelola JDIH</h4>
                                    <p class="text-muted fs-7 mb-0">Susunan Personalia &amp; Uraian Tugas Pengelola JDIHN Sekretariat DPRD:</p>
                                </div>
                                <a href="{{ route('portal.about', 'struktur-organisasi') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-diagram-3-fill me-1"></i> Lihat Bagan Struktur
                                </a>
                            </div>

                            @if(isset($timPengelola) && $timPengelola->count() > 0)
                                <!-- 1. Pembina (Bisa > 1) -->
                                @if($pembinaList->count() > 0)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom">
                                            <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold fs-8 rounded-pill">
                                                <i class="bi bi-shield-check me-1"></i> Pembina Tim Pengelola
                                            </span>
                                            <small class="text-muted fs-8">Pengarah Kebijakan Makro JDIH</small>
                                        </div>
                                        <div class="row g-3">
                                            @foreach($pembinaList as $tim)
                                                <div class="col-md-6 col-lg-4">
                                                    @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'bg-warning text-dark'])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- 2. Penanggung Jawab & Pimpinan Tim (Ketua, Wakil, Sekretaris) -->
                                @if($penanggungJawabList->count() > 0 || $ketuaList->count() > 0 || $wakilKetuaList->count() > 0 || $sekretarisList->count() > 0)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom">
                                            <span class="badge bg-dark text-white px-3 py-1.5 fw-bold fs-8 rounded-pill">
                                                <i class="bi bi-star-fill text-warning me-1"></i> Penanggung Jawab &amp; Pimpinan Operasional Tim
                                            </span>
                                        </div>
                                        <div class="row g-3">
                                            @foreach($penanggungJawabList as $tim)
                                                <div class="col-md-6 col-lg-4">
                                                    @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'bg-dark text-white'])
                                                </div>
                                            @endforeach
                                            @foreach($ketuaList as $tim)
                                                <div class="col-md-6 col-lg-4">
                                                    @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'bg-primary text-white'])
                                                </div>
                                            @endforeach
                                            @foreach($wakilKetuaList as $tim)
                                                <div class="col-md-6 col-lg-4">
                                                    @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'bg-info text-dark'])
                                                </div>
                                            @endforeach
                                            @foreach($sekretarisList as $tim)
                                                <div class="col-md-6 col-lg-4">
                                                    @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'text-white', 'badgeStyle' => 'background-color: #0d9488;'])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- 3. Bidang-Bidang / Divisi Kerja -->
                                @if($bidangGrouped->count() > 0)
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 mb-3 pb-1 border-bottom">
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 fw-bold fs-8 rounded-pill">
                                                <i class="bi bi-grid-fill me-1"></i> Bidang-Bidang / Divisi Kerja Tim JDIH
                                            </span>
                                        </div>
                                        @foreach($bidangGrouped as $namaDivisi => $anggotaDivisi)
                                            <div class="card border rounded-3 p-3 bg-light bg-opacity-50 mb-3 shadow-sm">
                                                <h6 class="fw-bold text-primary mb-3">
                                                    <i class="bi bi-folder2-open me-1"></i> {{ $namaDivisi }}
                                                </h6>
                                                <div class="row g-3">
                                                    @foreach($anggotaDivisi as $tim)
                                                        <div class="col-md-6 col-lg-4">
                                                            @include('portal.partials.tim-card', ['tim' => $tim, 'badgeClass' => 'bg-secondary bg-opacity-10 text-secondary'])
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                            @else
                                <div class="alert alert-info border-0 shadow-sm rounded-3">
                                    <i class="bi bi-info-circle-fill me-2"></i> Susunan SK Tim Pengelola JDIH sedang dalam penyesuaian data.
                                </div>
                            @endif

                        @elseif($slug == 'struktur-organisasi')
                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                <div>
                                    <h4 class="fw-bold text-primary mb-1">Bagan Struktur Organisasi Tim Pengelola JDIH</h4>
                                    <p class="text-muted fs-7 mb-0">Hierarki kepengurusan Jaringan Dokumentasi &amp; Informasi Hukum:</p>
                                </div>
                                <a href="{{ route('portal.about', 'sk-tim') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    <i class="bi bi-card-checklist me-1"></i> Rincian SK Tim
                                </a>
                            </div>

                            <!-- Interactive Organogram Chart -->
                            @if(isset($timPengelola) && $timPengelola->count() > 0)
                                <div class="organogram-container p-3 p-md-4 rounded-4 bg-light border shadow-sm mb-5 position-relative overflow-hidden">
                                    
                                    <!-- LEVEL 1: PEMBINA (Bisa > 1 orang) -->
                                    <div class="text-center mb-1">
                                        <span class="badge bg-warning text-dark px-3 py-1 rounded-pill fs-8 fw-bold text-uppercase letter-spacing-1 shadow-sm mb-2 d-inline-block">
                                            <i class="bi bi-shield-check"></i> Pembina Tim Pengelola
                                        </span>
                                        <div class="d-flex justify-content-center flex-wrap gap-3">
                                            @forelse($pembinaList as $pembina)
                                                <div class="organo-card bg-white border border-warning border-2 p-2.5 rounded-3 shadow-sm" style="min-width: 220px; max-width: 280px;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if($pembina->foto)
                                                            <img src="{{ asset($pembina->foto) }}" alt="{{ $pembina->nama }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-warning bg-opacity-20 text-dark rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                                                                <i class="bi bi-person-fill fs-5"></i>
                                                            </div>
                                                        @endif
                                                        <div class="text-start">
                                                            <div class="fw-bold text-dark fs-8 lh-1.2">{{ $pembina->nama }}</div>
                                                            <div class="text-warning-emphasis fs-9 fw-semibold mt-1">{{ $pembina->jabatan_struktural ?: $pembina->jabatan_tim }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="organo-card bg-white border border-warning p-2.5 rounded-3 shadow-sm text-center" style="min-width: 220px;">
                                                    <div class="fw-bold text-dark fs-8">Pimpinan DPRD</div>
                                                    <small class="text-muted fs-9">Pembina Tim Pengelola</small>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Connector -->
                                    <div class="organo-line-v"></div>

                                    <!-- LEVEL 2: PENANGGUNG JAWAB -->
                                    <div class="text-center mb-1">
                                        <span class="badge bg-dark text-white px-3 py-1 rounded-pill fs-8 fw-bold text-uppercase letter-spacing-1 shadow-sm mb-2 d-inline-block">
                                            <i class="bi bi-star-fill text-warning"></i> Penanggung Jawab
                                        </span>
                                        <div class="d-flex justify-content-center flex-wrap gap-3">
                                            @forelse($penanggungJawabList as $pj)
                                                <div class="organo-card bg-white border border-dark border-2 p-2.5 rounded-3 shadow-sm" style="min-width: 220px; max-width: 280px;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if($pj->foto)
                                                            <img src="{{ asset($pj->foto) }}" alt="{{ $pj->nama }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                                                                <i class="bi bi-person-fill fs-5"></i>
                                                            </div>
                                                        @endif
                                                        <div class="text-start">
                                                            <div class="fw-bold text-dark fs-8 lh-1.2">{{ $pj->nama }}</div>
                                                            <div class="text-primary fs-9 fw-semibold mt-1">{{ $pj->jabatan_struktural ?: 'Sekretaris DPRD' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="organo-card bg-white border border-dark p-2.5 rounded-3 shadow-sm text-center" style="min-width: 220px;">
                                                    <div class="fw-bold text-dark fs-8">Sekretaris DPRD</div>
                                                    <small class="text-muted fs-9">Penanggung Jawab JDIH</small>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Connector -->
                                    <div class="organo-line-v"></div>

                                    <!-- LEVEL 3: KETUA TIM -->
                                    <div class="text-center mb-1">
                                        <span class="badge bg-primary text-white px-3 py-1 rounded-pill fs-8 fw-bold text-uppercase letter-spacing-1 shadow-sm mb-2 d-inline-block">
                                            <i class="bi bi-award-fill"></i> Ketua Tim Pengelola
                                        </span>
                                        <div class="d-flex justify-content-center flex-wrap gap-3">
                                            @forelse($ketuaList as $ketua)
                                                <div class="organo-card bg-white border border-primary border-2 p-2.5 rounded-3 shadow-sm" style="min-width: 220px; max-width: 280px;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        @if($ketua->foto)
                                                            <img src="{{ asset($ketua->foto) }}" alt="{{ $ketua->nama }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                                                        @else
                                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 44px; height: 44px;">
                                                                <i class="bi bi-person-fill fs-5"></i>
                                                            </div>
                                                        @endif
                                                        <div class="text-start">
                                                            <div class="fw-bold text-dark fs-8 lh-1.2">{{ $ketua->nama }}</div>
                                                            <div class="text-primary fs-9 fw-semibold mt-1">{{ $ketua->jabatan_struktural ?: $ketua->jabatan_tim }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="organo-card bg-white border border-primary p-2.5 rounded-3 shadow-sm text-center" style="min-width: 220px;">
                                                    <div class="fw-bold text-dark fs-8">Kabag Perundang-Undangan</div>
                                                    <small class="text-muted fs-9">Ketua Tim Pengelola JDIH</small>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Connector -->
                                    <div class="organo-line-v"></div>

                                    <!-- LEVEL 4: WAKIL KETUA (Bisa > 1 orang) & LEVEL 5: SEKRETARIS TIM -->
                                    <div class="d-flex justify-content-center flex-wrap gap-4 mb-1">
                                        @if($wakilKetuaList->count() > 0)
                                            <div class="text-center">
                                                <span class="badge bg-info text-dark px-3 py-1 rounded-pill fs-8 fw-bold text-uppercase letter-spacing-1 shadow-sm mb-2 d-inline-block">
                                                    Wakil Ketua Tim
                                                </span>
                                                <div class="d-flex flex-column gap-2">
                                                    @foreach($wakilKetuaList as $wk)
                                                        <div class="organo-card bg-white border border-info p-2 rounded-3 shadow-sm" style="min-width: 210px;">
                                                            <div class="fw-bold text-dark fs-8">{{ $wk->nama }}</div>
                                                            <small class="text-muted fs-9">{{ $wk->jabatan_struktural ?: $wk->jabatan_tim }}</small>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <div class="text-center">
                                            <span class="badge text-white px-3 py-1 rounded-pill fs-8 fw-bold text-uppercase letter-spacing-1 shadow-sm mb-2 d-inline-block" style="background-color: #0d9488;">
                                                Sekretaris Tim
                                            </span>
                                            <div class="d-flex flex-column gap-2">
                                                @forelse($sekretarisList as $sekre)
                                                    <div class="organo-card bg-white border p-2 rounded-3 shadow-sm" style="border-color: #0d9488 !important; min-width: 210px;">
                                                        <div class="fw-bold text-dark fs-8">{{ $sekre->nama }}</div>
                                                        <small class="text-muted fs-9">{{ $sekre->jabatan_struktural ?: $sekre->jabatan_tim }}</small>
                                                    </div>
                                                @empty
                                                    <div class="organo-card bg-white border p-2 rounded-3 shadow-sm text-center" style="border-color: #0d9488 !important; min-width: 210px;">
                                                        <div class="fw-bold text-dark fs-8">Kasubag / Staf JDIH</div>
                                                        <small class="text-muted fs-9">Sekretaris Tim</small>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Connector to Branches -->
                                    <div class="organo-line-v mt-2"></div>
                                    <div class="organo-branch-bar d-none d-lg-block mx-auto"></div>

                                    <!-- LEVEL 6: BIDANG-BIDANG / DIVISI KERJA -->
                                    <div class="mt-3">
                                        <div class="row g-3 justify-content-center">
                                            @foreach($bidangGrouped as $namaDivisi => $anggotaDivisi)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden bg-white">
                                                        <div class="bg-primary text-white p-2.5 text-center">
                                                            <div class="fw-bold fs-8 text-uppercase letter-spacing-1">
                                                                <i class="bi bi-folder2-open me-1 text-warning"></i> {{ $namaDivisi }}
                                                            </div>
                                                        </div>
                                                        <div class="p-3">
                                                            <!-- Ketua Bidang -->
                                                            @php
                                                                $ketuaBidang = $anggotaDivisi->filter(function($i) {
                                                                    return str_contains(strtolower($i->peran_bidang ?? ''), 'ketua') || str_contains(strtolower($i->peran_bidang ?? ''), 'koordinator');
                                                                })->first();
                                                                $anggotaBidang = $anggotaDivisi->reject(function($i) use ($ketuaBidang) {
                                                                    return $ketuaBidang && $i->id === $ketuaBidang->id;
                                                                });
                                                            @endphp

                                                            @if($ketuaBidang)
                                                                <div class="p-2 rounded-3 bg-light border border-primary border-opacity-25 mb-2.5">
                                                                    <span class="badge bg-primary text-white fs-9 px-2 py-0.5 rounded-pill mb-1">
                                                                        <i class="bi bi-person-fill"></i> {{ $ketuaBidang->peran_bidang ?: 'Ketua Bidang' }}
                                                                    </span>
                                                                    <div class="fw-bold text-dark fs-8">{{ $ketuaBidang->nama }}</div>
                                                                    @if($ketuaBidang->jabatan_struktural)
                                                                        <small class="text-muted fs-9 d-block">{{ $ketuaBidang->jabatan_struktural }}</small>
                                                                    @endif
                                                                </div>
                                                            @endif

                                                            <!-- Anggota Bidang -->
                                                            @if($anggotaBidang->count() > 0)
                                                                <div class="fs-9 fw-bold text-muted text-uppercase mb-1.5">
                                                                    <i class="bi bi-people me-1"></i> Anggota Bidang ({{ $anggotaBidang->count() }}):
                                                                </div>
                                                                <ul class="list-unstyled mb-0 d-flex flex-column gap-1.5">
                                                                    @foreach($anggotaBidang as $ang)
                                                                        <li class="p-1.5 rounded-2 bg-light d-flex align-items-center justify-content-between gap-2 border-start border-2 border-primary">
                                                                            <div>
                                                                                <div class="fw-semibold text-dark fs-8.5">{{ $ang->nama }}</div>
                                                                                @if($ang->jabatan_struktural)
                                                                                    <small class="text-muted fs-9">{{ $ang->jabatan_struktural }}</small>
                                                                                @endif
                                                                            </div>
                                                                            @if($ang->nip)
                                                                                <span class="badge bg-white text-muted border fs-9 font-monospace">{{ $ang->nip }}</span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            @endif

                            <!-- Gambar Bagan Struktur Tambahan (Jika Diunggah) -->
                            @if(isset($profil) && $profil->struktur_organisasi && file_exists(public_path($profil->struktur_organisasi)))
                                <div class="card border rounded-3 p-3 bg-white shadow-sm mb-4 text-center">
                                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-image text-primary me-1"></i> Lampiran Dokumen Bagan Struktur Organisasi</h6>
                                    <a href="{{ asset($profil->struktur_organisasi) }}" target="_blank" title="Klik untuk memperbesar gambar">
                                        <img src="{{ asset($profil->struktur_organisasi) }}" alt="Bagan Struktur Organisasi" class="img-fluid rounded border mx-auto d-block" style="max-height: 450px; object-fit: contain;">
                                    </a>
                                    <small class="text-muted mt-2 d-block fs-8"><i class="bi bi-zoom-in"></i> Klik gambar untuk membuka ukuran penuh</small>
                                </div>
                            @endif

                            <p class="text-muted fs-7 mt-4">Struktur kelembagaan Sekretariat DPRD dan Alat Kelengkapan Dewan (AKD):</p>
                            
                            @if(isset($pimpinanAk) && $pimpinanAk->keanggotaans->count() > 0)
                                <h5 class="fw-bold text-dark mt-4 mb-3"><i class="bi bi-award-fill text-warning me-2"></i> Pimpinan DPRD</h5>
                                <div class="row g-3 mb-4">
                                    @foreach($pimpinanAk->keanggotaans as $pimpinan)
                                        <div class="col-md-4">
                                            <div class="card border p-3 rounded-3 text-center bg-light">
                                                <div class="fw-bold text-primary fs-7">{{ $pimpinan->jabatan }}</div>
                                                <div class="text-dark fw-bold mt-1">{{ $pimpinan->anggotaDprd->nama ?? '-' }}</div>
                                                <small class="text-muted">{{ $pimpinan->anggotaDprd->fraksi ?? '' }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if(isset($alatKelengkapan) && $alatKelengkapan->count() > 0)
                                <h5 class="fw-bold text-dark mt-4 mb-3"><i class="bi bi-diagram-3-fill text-primary me-2"></i> Alat Kelengkapan Dewan (AKD)</h5>
                                <div class="row g-3">
                                    @foreach($alatKelengkapan as $ak)
                                        <div class="col-md-6">
                                            <div class="border rounded-3 p-3 bg-white h-100 shadow-sm">
                                                <h6 class="fw-bold text-primary mb-2">{{ $ak->nama }}</h6>
                                                <p class="text-muted fs-8 mb-2">{{ $ak->deskripsi }}</p>
                                                <small class="text-muted">Total Anggota: <strong>{{ $ak->keanggotaans->count() }}</strong></small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                        @elseif($slug == 'sop')
                            <h4 class="fw-bold text-primary mb-3">Standar Operasional Prosedur (SOP)</h4>
                            <p class="text-muted fs-7">Pedoman tata kelola dan alur kerja baku pengelolaan dokumentasi hukum:</p>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border p-3 rounded-3 bg-light h-100">
                                        <div class="fw-bold text-primary fs-7 mb-1"><i class="bi bi-1-circle-fill text-warning me-1"></i> SOP Pengumpulan Dokumen</div>
                                        <p class="text-muted fs-8 mb-0">Mekanisme penerimaan salinan naskah Perda, Keputusan DPRD, Risalah dan Naskah Akademik setelah persidangan paripurna.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded-3 bg-light h-100">
                                        <div class="fw-bold text-primary fs-7 mb-1"><i class="bi bi-2-circle-fill text-warning me-1"></i> SOP Pengolahan &amp; Verifikasi</div>
                                        <p class="text-muted fs-8 mb-0">Pemeriksaan kelengkapan metadata, penomoran, pembuatan sari karangan/abstrak, dan penentuan status peraturan.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded-3 bg-light h-100">
                                        <div class="fw-bold text-primary fs-7 mb-1"><i class="bi bi-3-circle-fill text-warning me-1"></i> SOP Digitalisasi &amp; Publikasi</div>
                                        <p class="text-muted fs-8 mb-0">Scanning resolusi tinggi, konversi PDF ber-watermark resmi, upload basis data portal dan sinkronisasi JDIHN.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border p-3 rounded-3 bg-light h-100">
                                        <div class="fw-bold text-primary fs-7 mb-1"><i class="bi bi-4-circle-fill text-warning me-1"></i> SOP Layanan Permintaan Publik</div>
                                        <p class="text-muted fs-8 mb-0">Pelayanan permohonan salinan fisik atau softcopy dokumen hukum kepada masyarakat, peneliti, dan lembaga.</p>
                                    </div>
                                </div>
                            </div>

                        @else
                            <!-- Visi, Misi & Maklumat -->
                            <h4 class="fw-bold text-primary mb-3">Visi &amp; Misi JDIH DPRD</h4>
                            
                            <div class="card bg-light border-0 p-4 rounded-3 mb-4">
                                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-eye-fill text-warning me-1"></i> VISI:</h6>
                                <blockquote class="blockquote fs-7 text-dark mb-0 fst-italic">
                                    "{{ $profil->visi ?? 'Terwujudnya Jaringan Dokumentasi dan Informasi Hukum DPRD yang Terintegrasi, Modern, Transparan, Akurat, dan Terpercaya dalam Mendukung Tata Kelola Pemerintahan yang Baik.' }}"
                                </blockquote>
                            </div>

                            <div class="card bg-light border-0 p-4 rounded-3 mb-4">
                                <h6 class="fw-bold text-primary mb-2"><i class="bi bi-flag-fill text-warning me-1"></i> MISI:</h6>
                                <div class="fs-7 text-dark lh-lg">
                                    {!! nl2br(e($profil->misi ?? '1. Menjamin ketersediaan dokumentasi dan informasi hukum yang lengkap dan mutakhir.')) !!}
                                </div>
                            </div>

                            <div class="card border-primary border-2 p-4 rounded-3 bg-white">
                                <h5 class="fw-bold text-primary mb-2"><i class="bi bi-award-fill text-warning me-1"></i> Maklumat Pelayanan</h5>
                                <p class="text-dark fs-7 mb-0 lh-base">
                                    {{ $profil->maklumat_pelayanan ?: 'Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi hukum publik sesuai standar pelayanan yang telah ditetapkan secara transparan, profesional, dan akuntabel.' }}
                                </p>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

    <style>
        .organo-line-v {
            width: 2px;
            height: 20px;
            background: #94a3b8;
            margin: 4px auto;
        }
        .organo-branch-bar {
            width: 70%;
            height: 2px;
            background: #94a3b8;
            margin-bottom: 8px;
            position: relative;
        }
        .organo-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .organo-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }
    </style>

@endsection
