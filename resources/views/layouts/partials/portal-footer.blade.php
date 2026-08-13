<!-- Footer Area -->
<footer class="pt-5 pb-3">
    <div class="container">
        <div class="row g-4 justify-content-between">
            <div class="col-lg-5">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-bank2 text-warning fs-3 me-2"></i>
                    <span class="fs-4 fw-bold text-white">JDIH DPRD Bolmut</span>
                </div>
                <p class="text-white-50">
                    Jaringan Dokumentasi dan Informasi Hukum Sekretariat Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara. Menyediakan data produk hukum legislative secara transparan, kredibel, dan mudah diakses.
                </p>
                <div class="d-flex gap-3 fs-5 mt-4">
                    <a href="#" class="text-white-50"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-white fw-bold mb-3">Tautan Cepat</h5>
                <ul class="list-unstyled d-flex flex-column gap-2">
                    <li><a href="{{ route('portal.home') }}"><i class="bi bi-chevron-right me-1 fs-8"></i> Beranda</a></li>
                    <li><a href="{{ route('portal.search') }}"><i class="bi bi-chevron-right me-1 fs-8"></i> Cari Produk Hukum</a></li>
                    <li><a href="{{ route('portal.news.list') }}"><i class="bi bi-chevron-right me-1 fs-8"></i> Berita Hukum</a></li>
                    <li><a href="{{ route('portal.profile') }}"><i class="bi bi-chevron-right me-1 fs-8"></i> Tentang JDIH</a></li>
                    <li><a href="{{ route('portal.gallery') }}"><i class="bi bi-chevron-right me-1 fs-8"></i> Galeri Dokumentasi</a></li>
                </ul>
            </div>
            <div class="col-lg-4 col-md-6">
                <h5 class="text-white fw-bold mb-3">Hubungi Kami</h5>
                <p class="text-white-50 mb-2">
                    <i class="bi bi-geo-alt-fill text-warning me-2"></i> Jl. Trans Sulawesi, Boroko, Kab. Bolaang Mongondow Utara, Sulawesi Utara.
                </p>
                <p class="text-white-50 mb-2">
                    <i class="bi bi-telephone-fill text-warning me-2"></i> (0434) 123456
                </p>
                <p class="text-white-50">
                    <i class="bi bi-envelope-fill text-warning me-2"></i> sekretariat@dprd-bolmutkab.go.id
                </p>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <small class="text-white-50">&copy; {{ date('Y') }} Sekretariat DPRD Kabupaten Bolaang Mongondow Utara. All Rights Reserved.</small>
            </div>
            <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                <small class="text-white-50">Powered by <a href="#" class="text-white">Laravel 12</a> &amp; <a href="#" class="text-white">Bootstrap 5</a></small>
            </div>
        </div>
    </div>
</footer>
