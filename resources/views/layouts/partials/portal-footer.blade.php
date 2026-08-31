<!-- Footer Area -->
<footer class="pt-5 pb-3">
    <div class="container">
        <div class="row g-4 pb-4">
            
            <!-- Col 1: Popular Documents -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Produk Hukum Terpopuler</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-8">
                    @php
                        $footerPopular = \App\Models\DokumenHukum::orderBy('hits', 'desc')->take(5)->get();
                    @endphp
                    @forelse($footerPopular as $doc)
                        <li>
                            <a href="{{ route('portal.document.show', $doc->id) }}" class="d-block text-truncate" title="{{ $doc->judul }}">
                                <i class="bi bi-chevron-right me-1 text-warning"></i> {{ $doc->judul }}
                            </a>
                            <small class="text-white-50 fs-9 ps-3">
                                <i class="bi bi-eye"></i> {{ number_format($doc->hits) }} views | <i class="bi bi-download"></i> {{ number_format($doc->downloads) }} unduhan
                            </small>
                        </li>
                    @empty
                        <li class="text-white-50">Belum ada dokumen populer.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Col 2: Alur Ranperda Prioritas -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Alur Ranperda Terkini</h5>
                <ul class="list-unstyled d-flex flex-column gap-2 fs-8">
                    @php
                        $footerRanperda = \App\Models\Ranperda::orderBy('tahun', 'desc')->orderBy('id', 'desc')->take(5)->get();
                    @endphp
                    @forelse($footerRanperda as $r)
                        <li>
                            <a href="{{ route('portal.ranperda', ['tahun' => $r->tahun]) }}" class="d-block text-truncate" title="{{ $r->judul }}">
                                <i class="bi bi-file-earmark-code me-1 text-warning"></i> {{ $r->judul }}
                            </a>
                            <small class="text-warning fs-9 ps-3">
                                <i class="bi bi-arrow-right-circle"></i> {{ $r->tahapan_name }} ({{ $r->tahun }})
                            </small>
                        </li>
                    @empty
                        <li class="text-white-50">Belum ada usulan Ranperda.</li>
                    @endforelse
                </ul>
            </div>

            <!-- Col 3: Sejarah JDIHN & Integrasi -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">Jaringan JDIHN</h5>
                <p class="fs-8 text-white-50 lh-base mb-3">
                    Ide membentuk <strong>Jaringan Dokumentasi dan Informasi Hukum Nasional (JDIHN)</strong> secara historis melekat erat dengan pembangunan hukum nasional dalam upaya mewujudkan supremasi hukum dan keterbukaan informasi.
                </p>
                <div class="d-flex align-items-center gap-2">
                    <div class="bg-white p-2 rounded-2 text-center" style="width: 80px;">
                        <i class="bi bi-shield-shaded fs-3 text-primary"></i>
                        <div class="text-dark fw-bold" style="font-size: 0.65rem;">JDIHN BPHN</div>
                    </div>
                    <div class="fs-8 text-white-50">
                        Terintegrasi dengan basis data nasional Kemenkumham RI.
                    </div>
                </div>
            </div>

            <!-- Col 4: Kontak & Social Media -->
            <div class="col-lg-3 col-md-6">
                <h5 class="footer-heading">{{ $gProfil->nama_sekretariat ?? 'Sekretariat DPRD' }}</h5>
                <p class="fs-8 text-white-50 mb-2">
                    <i class="bi bi-geo-alt-fill text-warning me-2"></i> {{ $gProfil->alamat ?? 'Gedung DPRD, Jl. Trans Sulawesi' }}
                </p>
                <p class="fs-8 text-white-50 mb-2">
                    <i class="bi bi-telephone-fill text-warning me-2"></i> {{ $gProfil->telepon ?? '-' }}
                </p>
                <p class="fs-8 text-white-50 mb-3">
                    <i class="bi bi-envelope-fill text-warning me-2"></i> {{ $gProfil->email ?? 'jdih@dprd.go.id' }}
                </p>

                <div class="d-flex gap-2 mt-2">
                    @if(isset($gProfil) && $gProfil->facebook)
                        <a href="{{ $gProfil->facebook }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif

                    @if(isset($gProfil) && $gProfil->instagram)
                        <a href="{{ $gProfil->instagram }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif

                    @if(isset($gProfil) && $gProfil->youtube)
                        <a href="{{ $gProfil->youtube }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;" title="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    @endif

                    @if(isset($gProfil) && $gProfil->twitter)
                        <a href="{{ $gProfil->twitter }}" target="_blank" class="btn btn-sm btn-outline-light rounded-circle" style="width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center;" title="Twitter / X">
                            <i class="fab fa-x-twitter"></i>
                        </a>
                    @endif
                </div>
            </div>

        </div>

        <hr class="border-secondary my-3 opacity-25">

        <div class="row align-items-center fs-8 text-white-50">
            <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                &copy; {{ date('Y') }} <strong>{{ $gProfil->nama_sekretariat ?? ($gProfil->nama_kantor ?? 'Sekretariat DPRD') }}</strong>. All Rights Reserved.
            </div>
            <div class="col-md-6 text-center text-md-end">
                <span class="badge bg-secondary bg-opacity-25 text-white-50 px-3 py-1 font-monospace">
                    <i class="bi bi-people-fill text-warning me-1"></i> Pengunjung: 1,213,959 | Online: 24
                </span>
            </div>
        </div>
    </div>
</footer>
