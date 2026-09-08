<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'JDIH ' . (isset($gProfil) && $gProfil->nama_singkat_kantor ? $gProfil->nama_singkat_kantor : 'DPRD') . ' - Jaringan Dokumentasi dan Informasi Hukum')</title>
    
    <!-- Favicon / Tab Icon -->
    @if(isset($gProfil) && $gProfil->logo && file_exists(public_path($gProfil->logo)))
        <link rel="icon" href="{{ asset($gProfil->logo) }}">
        <link rel="shortcut icon" href="{{ asset($gProfil->logo) }}">
        <link rel="apple-touch-icon" href="{{ asset($gProfil->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Meta SEO -->
    <meta name="description" content="JDIH {{ isset($gProfil) && $gProfil->nama_kantor ? $gProfil->nama_kantor : 'DPRD' }} - Jaringan Dokumentasi dan Informasi Hukum. Pusat publikasi Peraturan Daerah, Keputusan DPRD, Risalah, dan Produk Hukum resmi.">
    <meta name="keywords" content="JDIH, DPRD, JDIH DPRD, Jaringan Dokumentasi dan Informasi Hukum, Peraturan Daerah, PERDA, Keputusan DPRD, Risalah Rapat, Naskah Akademik, Ranperda, JDIHN">
    <meta name="author" content="JDIH {{ isset($gProfil) && $gProfil->nama_singkat_kantor ? $gProfil->nama_singkat_kantor : 'DPRD' }}">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom Theme Styles -->
    <style>
        :root {
            --primary-navy: #0f172a;
            --primary-blue: #1e3a8a;
            --primary-accent: #0284c7;
            --jdih-gold: #eab308;
            --jdih-orange: #f97316;
            --dark-surface: #1e293b;
            --light-bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Poppins', 'Outfit', sans-serif;
            background-color: var(--light-bg);
            color: var(--text-main);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Top Bar Branding */
        .top-brand-bar {
            background: linear-gradient(90deg, #091a2e 0%, #172c47 50%, #091a2e 100%);
            border-bottom: 2px solid var(--jdih-gold);
            padding: 8px 0;
        }

        /* Navbar & Dropdown Styles */
        .navbar-main {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            padding: 0;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            font-size: 0.92rem;
            color: #334155 !important;
            padding: 18px 14px !important;
            transition: var(--transition-smooth);
            position: relative;
        }

        .navbar-nav .nav-link:hover, 
        .navbar-nav .nav-link.active {
            color: var(--primary-blue) !important;
            background-color: rgba(30, 58, 138, 0.04);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--jdih-gold);
            transition: var(--transition-smooth);
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 80%;
        }

        /* Multi-Level Dropdowns */
        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.12);
            padding: 8px 0;
            animation: fadeInMenu 0.2s ease-in-out;
        }

        @keyframes fadeInMenu {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            font-size: 0.88rem;
            font-weight: 500;
            padding: 9px 20px;
            color: #475569;
            transition: var(--transition-smooth);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item i {
            font-size: 0.95rem;
            color: var(--primary-accent);
            width: 18px;
        }

        .dropdown-item:hover {
            background-color: #f1f5f9;
            color: var(--primary-blue);
            transform: translateX(4px);
        }

        /* Nested Dropdown on Hover for Desktop */
        @media (min-width: 992px) {
            .dropdown-submenu {
                position: relative;
            }
            .dropdown-submenu > .dropdown-menu {
                top: 0;
                left: 100%;
                margin-top: -6px;
                display: none;
            }
            .dropdown-submenu:hover > .dropdown-menu {
                display: block;
            }
            .dropdown-menu-end .dropdown-submenu > .dropdown-menu {
                left: auto;
                right: 100%;
            }
        }

        /* Running Agenda Ticker */
        .agenda-ticker-wrapper {
            width: 100%;
            display: flex;
            align-items: center;
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        .agenda-ticker-label {
            background: linear-gradient(135deg, #0f172a, #1e293b);
            color: #fbbf24;
            padding: 10px 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
            font-size: 0.82rem;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
            white-space: nowrap;
            box-shadow: 4px 0 15px rgba(0,0,0,0.15);
            z-index: 2;
        }

        .agenda-ticker-bar {
            flex: 1;
            overflow: hidden;
        }

        .agenda-ticker-track {
            display: flex;
            align-items: center;
            white-space: nowrap;
            padding: 10px 0;
            animation: agendaScroll 55s linear infinite;
        }

        .agenda-ticker-track:hover {
            animation-play-state: paused;
        }

        .agenda-ticker-item {
            font-size: 0.88rem;
            font-weight: 500;
            color: #334155;
            margin-right: 60px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .agenda-ticker-item .badge-date {
            background: rgba(30, 58, 138, 0.1);
            color: var(--primary-blue);
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.78rem;
        }

        @keyframes agendaScroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        /* Hero Search Area */
        .hero-search-section {
            background: linear-gradient(135deg, #0a192f 0%, #1e3a8a 50%, #0f172a 100%);
            padding: 60px 0 50px;
            position: relative;
            background-size: cover;
            background-position: center;
        }

        .hero-title-main {
            color: #ffffff;
            font-weight: 800;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
            margin-bottom: 4px;
        }

        .hero-subtitle-main {
            color: #fbbf24;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 8px rgba(0,0,0,0.6);
            margin-bottom: 25px;
        }

        .search-card-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            padding: 24px;
        }

        /* Document Item Cards */
        .doc-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            transition: var(--transition-smooth);
            margin-bottom: 16px;
        }

        .doc-item-card:hover {
            border-color: #cbd5e1;
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-2px);
        }

        .doc-icon-box {
            width: 52px;
            height: 52px;
            background: rgba(30, 58, 138, 0.08);
            color: var(--primary-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* Status Badges */
        .badge-status {
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.78rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .status-berlaku {
            background-color: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .status-mengubah {
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
        }
        .status-diubah {
            background-color: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .status-dicabut, .status-tidak-berlaku {
            background-color: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* Buttons & Actions */
        .btn-action-preview {
            background-color: #f59e0b;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8rem;
            border-radius: 30px;
            padding: 6px 14px;
            border: none;
            transition: var(--transition-smooth);
        }
        .btn-action-preview:hover {
            background-color: #d97706;
            color: #ffffff;
        }

        .btn-action-abstract {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            font-size: 0.8rem;
            border-radius: 30px;
            padding: 6px 14px;
            border: 1px solid #cbd5e1;
            transition: var(--transition-smooth);
        }
        .btn-action-abstract:hover {
            background-color: #e2e8f0;
            color: #0f172a;
        }

        .btn-action-download {
            background-color: #0d9488;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.8rem;
            border-radius: 30px;
            padding: 6px 14px;
            border: none;
            transition: var(--transition-smooth);
        }
        .btn-action-download:hover {
            background-color: #0f766e;
            color: #ffffff;
        }

        /* Statistics Counter Card */
        .stat-card-clean {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 24px;
            text-align: center;
            transition: var(--transition-smooth);
            box-shadow: var(--card-shadow);
        }
        .stat-card-clean:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
            border-color: var(--jdih-gold);
        }

        /* Floating Action Buttons */
        .floating-wa-btn {
            position: fixed;
            bottom: 30px;
            right: 25px;
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
            z-index: 999;
            transition: var(--transition-smooth);
            text-decoration: none;
        }
        .floating-wa-btn:hover {
            transform: scale(1.1);
            color: #ffffff;
        }

        /* Footer */
        footer {
            background: #0f172a;
            color: #cbd5e1;
            margin-top: auto;
            border-top: 4px solid var(--jdih-gold);
        }
        footer a {
            color: #94a3b8;
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        footer a:hover {
            color: var(--jdih-gold);
            padding-left: 3px;
        }
        .footer-heading {
            color: #ffffff;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 18px;
            position: relative;
            padding-bottom: 8px;
        }
        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 2px;
            background: var(--jdih-gold);
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Main Navigation Bar -->
    @include('layouts.partials.portal-navbar')

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layouts.partials.portal-footer')

    <!-- WhatsApp Floating Quick Support -->
    <a href="https://api.whatsapp.com/send?phone={{ isset($gProfil) && $gProfil->whatsapp ? preg_replace('/[^0-9]/', '', $gProfil->whatsapp) : '62614537728' }}&text=Halo%20Admin%20JDIH%2C%20saya%20ingin%20bertanya%20mengenai%20produk%20hukum..." target="_blank" class="floating-wa-btn" title="Chat WhatsApp JDIH">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Universal Preview Modal -->
    <div class="modal fade" id="modalPreviewDoc" tabindex="-1" aria-labelledby="modalPreviewDocLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fs-6 fw-bold" id="modalPreviewDocLabel">
                        <i class="bi bi-file-earmark-pdf me-2 text-warning"></i> Preview Dokumen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="previewModalContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="text-muted mt-2">Memuat dokumen...</p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Universal Abstract Modal -->
    <div class="modal fade" id="modalAbstractDoc" tabindex="-1" aria-labelledby="modalAbstractDocLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fs-6 fw-bold" id="modalAbstractDocLabel">
                        <i class="bi bi-journal-text me-2 text-warning"></i> Abstrak Dokumen Hukum
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4" id="abstractModalContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- IKM Chart Result Modal -->
    <div class="modal fade" id="modalIkmChart" tabindex="-1" aria-labelledby="modalIkmChartLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fs-6 fw-bold" id="modalIkmChartLabel">
                        <i class="bi bi-pie-chart-fill me-2 text-warning"></i> Hasil Indeks Kepuasan Masyarakat (IKM)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="chart-container position-relative" style="height:260px;">
                        <canvas id="ikmChartCanvas"></canvas>
                    </div>
                    <div id="ikmChartSummary" class="text-center mt-3 text-muted fs-7"></div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Global Scripts -->
    <script>
        // Modal Preview Document Loader
        function openPreviewModal(docId) {
            const modal = new bootstrap.Modal(document.getElementById('modalPreviewDoc'));
            const content = document.getElementById('previewModalContent');
            content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="text-muted mt-2">Memuat dokumen...</p></div>';
            modal.show();

            fetch(`/dokumen/${docId}/preview`)
                .then(res => res.text())
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(err => {
                    content.innerHTML = '<div class="alert alert-danger m-4">Gagal memuat pratinjau dokumen.</div>';
                });
        }

        // Modal Abstract Document Loader
        function openAbstractModal(docId) {
            const modal = new bootstrap.Modal(document.getElementById('modalAbstractDoc'));
            const content = document.getElementById('abstractModalContent');
            content.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="text-muted mt-2">Memuat abstrak...</p></div>';
            modal.show();

            fetch(`/dokumen/${docId}/abstrak`)
                .then(res => res.text())
                .then(html => {
                    content.innerHTML = html;
                })
                .catch(err => {
                    content.innerHTML = '<div class="alert alert-danger m-4">Gagal memuat abstrak dokumen.</div>';
                });
        }

        // IKM Result Chart
        let ikmChartInstance = null;
        function showIkmResults() {
            const modal = new bootstrap.Modal(document.getElementById('modalIkmChart'));
            modal.show();

            fetch('/ikm/result')
                .then(res => res.json())
                .then(data => {
                    const ctx = document.getElementById('ikmChartCanvas').getContext('2d');
                    if (ikmChartInstance) {
                        ikmChartInstance.destroy();
                    }
                    ikmChartInstance = new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                                borderWidth: 2,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { position: 'bottom' }
                            }
                        }
                    });
                    document.getElementById('ikmChartSummary').innerHTML = `Total Responden: <strong>${data.total}</strong> suara masyarakat`;
                });
        }

        // Handle IKM Vote Submit via AJAX
        document.addEventListener('DOMContentLoaded', function () {
            const formIkm = document.getElementById('formIkmVote');
            if (formIkm) {
                formIkm.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    fetch('/ikm/vote', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message);
                        showIkmResults();
                    })
                    .catch(err => {
                        alert('Gagal mengirim penilaian IKM.');
                    });
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>
