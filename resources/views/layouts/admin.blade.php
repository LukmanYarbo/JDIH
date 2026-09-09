<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard JDIH ' . (isset($gProfil) && $gProfil->nama_singkat_kantor ? $gProfil->nama_singkat_kantor : 'DPRD'))</title>
    
    <!-- Favicon / Tab Icon -->
    @if(isset($gProfil) && $gProfil->logo && file_exists(public_path($gProfil->logo)))
        <link rel="icon" href="{{ asset($gProfil->logo) }}">
        <link rel="shortcut icon" href="{{ asset($gProfil->logo) }}">
        <link rel="apple-touch-icon" href="{{ asset($gProfil->logo) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    @endif
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Chart.js CDN for Modern Interactive Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    
    <script>
        const savedTheme = localStorage.getItem('admin-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        if (localStorage.getItem('admin-sidebar-toggled') === 'true' && window.innerWidth >= 992) {
            document.documentElement.classList.add('sidebar-toggled');
        }
    </script>

    <style>
        :root {
            /* Light Mode Variables */
            --bg-body: #f1f5f9;
            --bg-card: #ffffff;
            --text-main: #0f172a;
            --text-secondary: #64748b;
            --border-color: rgba(15, 23, 42, 0.08);
            
            --sidebar-width: 260px;
            --primary-color: #0d3b66;
            --primary-light: #185a9d;
            --secondary-color: #f4d35e;
            --accent-color: #ee964b;
            --text-light: #f8f9fa;
            --card-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
            --transition-smooth: all 0.28s cubic-bezier(0.4, 0, 0.2, 1);
        }

        [data-theme="dark"] {
            /* Dark Mode Variables */
            --bg-body: #0b1120;
            --bg-card: #151f32;
            --text-main: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.08);
            --card-shadow: 0 10px 25px rgba(0, 0, 0, 0.35);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark Mode Overrides for hardcoded Bootstrap classes */
        [data-theme="dark"] .bg-white {
            background-color: var(--bg-card) !important;
        }
        [data-theme="dark"] .text-dark {
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .text-muted {
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .card {
            background-color: var(--bg-card) !important;
            border-color: var(--border-color) !important;
            box-shadow: var(--card-shadow) !important;
        }
        [data-theme="dark"] .table {
            color: var(--text-main) !important;
            border-color: var(--border-color) !important;
        }
        [data-theme="dark"] .table-hover tbody tr:hover {
            color: var(--text-main) !important;
            background-color: rgba(255, 255, 255, 0.04) !important;
        }
        [data-theme="dark"] .table th, [data-theme="dark"] .table td {
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .bg-light {
            background-color: rgba(255, 255, 255, 0.05) !important;
        }
        [data-theme="dark"] header {
            background-color: var(--bg-card) !important;
            border-bottom-color: var(--border-color) !important;
        }
        [data-theme="dark"] .btn-light {
            background-color: #1e293b !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .form-control, [data-theme="dark"] .form-select {
            background-color: #0b1120 !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .form-control:focus, [data-theme="dark"] .form-select:focus {
            background-color: #0b1120 !important;
            border-color: var(--primary-light) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .form-control::placeholder {
            color: var(--text-secondary) !important;
        }
        [data-theme="dark"] .input-group-text {
            background-color: #0b1120 !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .modal-content {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
        }
        [data-theme="dark"] .alert-success {
            background-color: rgba(25, 135, 84, 0.15) !important;
            color: #2ec4b6 !important;
        }
        [data-theme="dark"] .alert-danger {
            background-color: rgba(220, 53, 69, 0.15) !important;
            color: #e71d36 !important;
        }

        /* Sidebar Base Styling */
        aside {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #071e36 0%, #0d3b66 60%, #0a2f52 100%);
            color: var(--text-light);
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 105;
            display: flex;
            flex-direction: column;
            border-right: 3px solid var(--secondary-color);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.3s ease;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            overflow-x: hidden;
        }
        
        .sidebar-header {
            padding: 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            min-height: 72px;
        }
        
        .sidebar-brand {
            font-weight: 700;
            color: var(--text-light) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            overflow: hidden;
            transition: var(--transition-smooth);
        }
        
        .sidebar-menu {
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex-grow: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
        }
        
        .sidebar-item {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.72);
            font-weight: 500;
            font-size: 0.92rem;
            padding: 10px 14px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition-smooth);
            white-space: nowrap;
        }

        .sidebar-item i {
            font-size: 1.15rem;
            min-width: 24px;
            text-align: center;
            transition: transform 0.2s ease;
        }
        
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(3px);
        }
        
        .sidebar-item.active {
            border-left: 4px solid var(--secondary-color);
            background: linear-gradient(90deg, rgba(244, 211, 94, 0.2) 0%, rgba(255, 255, 255, 0.08) 100%);
            color: #ffffff;
            font-weight: 600;
        }

        .sidebar-item.active i {
            color: var(--secondary-color);
        }
        
        .sidebar-footer {
            padding: 16px 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.12);
            min-height: 68px;
            transition: var(--transition-smooth);
        }

        /* Main Page Wrapper */
        .wrapper {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: calc(100% - var(--sidebar-width));
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1), width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Top Navigation Header */
        header {
            background: #ffffff;
            padding: 14px 28px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
            backdrop-filter: blur(8px);
            transition: var(--transition-smooth);
        }

        /* Content panel */
        .content-container {
            padding: 28px;
            flex-grow: 1;
        }

        /* Badge and status */
        .badge-status {
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 30px;
        }

        /* Mobile Backdrop Overlay */
        .sidebar-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* ====================================================
           DESKTOP SIDEBAR TOGGLE (Slide-Out / Full Width View)
           ==================================================== */
        @media (min-width: 992px) {
            aside {
                left: 0;
                transform: translateX(0);
            }

            html.sidebar-toggled body aside,
            body.sidebar-toggled aside {
                transform: translateX(-100%) !important;
            }

            html.sidebar-toggled body .wrapper,
            body.sidebar-toggled .wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
        }

        /* ====================================================
           MOBILE SIDEBAR DRAWER (< 992px)
           ==================================================== */
        @media (max-width: 991.98px) {
            aside {
                left: 0;
                transform: translateX(-100%);
                box-shadow: none;
            }
            aside.show {
                transform: translateX(0) !important;
                box-shadow: 10px 0 35px rgba(0, 0, 0, 0.45);
            }
            .wrapper {
                margin-left: 0 !important;
                width: 100% !important;
            }
            .content-container {
                padding: 18px;
            }
            header {
                padding: 12px 18px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Mobile Overlay Backdrop -->
    <div id="sidebarBackdrop" class="sidebar-backdrop" onclick="window.closeAdminSidebar()"></div>

    @include('layouts.partials.admin-sidebar')

    <!-- Main Wrapper Area -->
    <div class="wrapper">
        @include('layouts.partials.admin-header')

        <div class="content-container">
            <!-- Toast notification messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 for Modern UI Confirmations -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ==========================================
        // ROBUST GLOBAL SIDEBAR TOGGLE SYSTEM
        // ==========================================
        window.toggleAdminSidebar = function() {
            const isDesktop = window.innerWidth >= 992;
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleIcon = document.getElementById('sidebarToggleIcon');

            if (isDesktop) {
                // Clear any html preload attribute
                document.documentElement.classList.remove('sidebar-toggled');
                const isToggled = document.body.classList.toggle('sidebar-toggled');
                localStorage.setItem('admin-sidebar-toggled', isToggled ? 'true' : 'false');
                if (toggleIcon) {
                    if (isToggled) {
                        toggleIcon.classList.remove('bi-text-indent-left');
                        toggleIcon.classList.add('bi-text-indent-right');
                    } else {
                        toggleIcon.classList.remove('bi-text-indent-right');
                        toggleIcon.classList.add('bi-text-indent-left');
                    }
                }
            } else {
                const isShown = sidebar ? sidebar.classList.toggle('show') : false;
                if (backdrop) {
                    if (isShown) {
                        backdrop.classList.add('show');
                        document.body.style.overflow = 'hidden';
                    } else {
                        backdrop.classList.remove('show');
                        document.body.style.overflow = '';
                    }
                }
            }
        };

        window.closeAdminSidebar = function() {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.remove('show');
            if (backdrop) backdrop.classList.remove('show');
            document.body.style.overflow = '';
        };

        // Sync initial state on load
        (function() {
            if (localStorage.getItem('admin-sidebar-toggled') === 'true' && window.innerWidth >= 992) {
                document.body.classList.add('sidebar-toggled');
                const toggleIcon = document.getElementById('sidebarToggleIcon');
                if (toggleIcon) {
                    toggleIcon.classList.remove('bi-text-indent-left');
                    toggleIcon.classList.add('bi-text-indent-right');
                }
            }

            // Universal event delegation for the mobile close button
            // (Note: #sidebarToggle relies on its inline onclick handler to avoid double-toggling)
            document.addEventListener('click', function(e) {
                const closeBtn = e.target.closest('#sidebarCloseMobile');
                if (closeBtn) {
                    e.preventDefault();
                    window.closeAdminSidebar();
                }
            });
        })();

        // Theme Toggle Switch
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeToggleIcon = document.getElementById('themeToggleIcon');
        
        function updateToggleIcon(theme) {
            if (theme === 'dark') {
                themeToggleIcon.classList.remove('bi-moon-fill');
                themeToggleIcon.classList.add('bi-sun-fill');
            } else {
                themeToggleIcon.classList.remove('bi-sun-fill');
                themeToggleIcon.classList.add('bi-moon-fill');
            }
        }

        const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
        updateToggleIcon(currentTheme);

        themeToggleBtn?.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('admin-theme', newTheme);
            updateToggleIcon(newTheme);
        });

        // Universal Modern UI Delete Confirmation
        window.confirmAction = function(target, title = 'Apakah Anda Yakin?', text = 'Tindakan ini tidak dapat dibatalkan.', btnText = 'Ya, Lanjutkan') {
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i> ' + btnText,
                cancelButtonText: 'Batal',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'rounded-pill px-4 py-2 fw-semibold',
                    cancelButton: 'rounded-pill px-4 py-2'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof target === 'string') {
                        document.getElementById(target)?.submit();
                    } else if (typeof target === 'function') {
                        target();
                    }
                }
            });
        };

        // Auto-bind on forms with class 'delete-form' or attribute 'data-confirm'
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.delete-form, form[data-confirm]').forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const title = form.getAttribute('data-title') || 'Konfirmasi Penghapusan';
                    const text = form.getAttribute('data-confirm') || 'Data yang dihapus tidak dapat dipulihkan kembali.';
                    const btnText = form.getAttribute('data-btn-text') || 'Ya, Hapus';

                    window.confirmAction(() => {
                        form.submit();
                    }, title, text, btnText);
                });
            });
        });

        // ==========================================
        // 30-MINUTE INACTIVITY AUTO-LOGOUT SYSTEM
        // ==========================================
        (function() {
            const TIMEOUT_MINUTES = 30;
            const TIMEOUT_MS = TIMEOUT_MINUTES * 60 * 1000;      // 30 menit (1.800.000 ms)
            const WARNING_MS = 2 * 60 * 1000;                     // Peringatan 2 menit sebelum logout (120.000 ms)
            const WARNING_THRESHOLD_MS = TIMEOUT_MS - WARNING_MS; // Mulai peringatan pada menit ke-28 (1.680.000 ms)
            const PING_INTERVAL_MS = 5 * 60 * 1000;               // Ping server tiap 5 menit saat ada aktivitas aktif

            let lastActivity = Date.now();
            try {
                const storedActivity = localStorage.getItem('jdih_admin_last_activity');
                if (storedActivity && !isNaN(storedActivity)) {
                    lastActivity = Math.max(lastActivity, parseInt(storedActivity, 10));
                }
                localStorage.setItem('jdih_admin_last_activity', lastActivity.toString());
            } catch(e) {}

            let isWarningOpen = false;
            let countdownInterval = null;
            let lastPingTime = Date.now();
            let activityThrottleTimer = null;

            const pingUrl = "{{ route('admin.ping') }}";
            const autoLogoutUrl = "{{ route('auto-logout') }}";
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            function sendPing() {
                lastPingTime = Date.now();
                fetch(pingUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                }).catch(function(err) {
                    console.debug('Ping error:', err);
                });
            }

            function triggerLogout() {
                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }
                Swal.close();

                Swal.fire({
                    title: 'Sesi Berakhir',
                    text: 'Anda telah keluar otomatis karena tidak ada aktivitas selama 30 menit. Mengalihkan ke halaman login...',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0'
                    }
                });

                setTimeout(function() {
                    window.location.href = autoLogoutUrl;
                }, 1000);
            }

            function showWarningModal(remainingSeconds) {
                if (isWarningOpen) return;
                isWarningOpen = true;

                Swal.fire({
                    title: 'Peringatan Inaktivitas',
                    html: `
                        <div class="py-2">
                            <p class="mb-2">Anda tidak melakukan aktivitas selama 28 menit.</p>
                            <p class="mb-3">Sesi Anda akan otomatis keluar dalam: <br>
                                <span id="session-countdown-display" class="fw-bold text-danger fs-3">${remainingSeconds}</span> detik
                            </p>
                            <small class="text-muted">Klik tombol <strong>Tetap Masuk</strong> untuk melanjutkan pekerjaan Anda.</small>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="bi bi-shield-check me-1"></i> Tetap Masuk',
                    cancelButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Logout Sekarang',
                    confirmButtonColor: '#0d3b66',
                    cancelButtonColor: '#dc3545',
                    reverseButtons: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    focusConfirm: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: 'rounded-pill px-4 py-2 fw-semibold',
                        cancelButton: 'rounded-pill px-4 py-2'
                    }
                }).then(function(result) {
                    isWarningOpen = false;
                    if (countdownInterval) {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                    }

                    if (result.isConfirmed) {
                        recordUserActivity(true);
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        triggerLogout();
                    }
                });

                // Interval per detik untuk teks hitung mundur
                if (countdownInterval) clearInterval(countdownInterval);
                countdownInterval = setInterval(function() {
                    const currentIdle = Date.now() - lastActivity;
                    const secsLeft = Math.max(0, Math.ceil((TIMEOUT_MS - currentIdle) / 1000));
                    
                    const el = document.getElementById('session-countdown-display');
                    if (el) {
                        el.textContent = secsLeft;
                    }

                    if (secsLeft <= 0) {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                        triggerLogout();
                    }
                }, 1000);
            }

            function checkInactivity() {
                const idleTime = Date.now() - lastActivity;

                if (idleTime >= TIMEOUT_MS) {
                    triggerLogout();
                } else if (idleTime >= WARNING_THRESHOLD_MS) {
                    const secsLeft = Math.max(0, Math.ceil((TIMEOUT_MS - idleTime) / 1000));
                    showWarningModal(secsLeft);
                }
            }

            function recordUserActivity(forcePing) {
                const now = Date.now();
                lastActivity = now;

                try {
                    localStorage.setItem('jdih_admin_last_activity', now.toString());
                } catch(e) {}

                if (isWarningOpen) {
                    if (countdownInterval) {
                        clearInterval(countdownInterval);
                        countdownInterval = null;
                    }
                    Swal.close();
                    isWarningOpen = false;
                }

                if (forcePing || (now - lastPingTime > PING_INTERVAL_MS)) {
                    sendPing();
                }
            }

            // Sync lintas tab browser
            window.addEventListener('storage', function(e) {
                if (e.key === 'jdih_admin_last_activity' && e.newValue) {
                    const extActivity = parseInt(e.newValue, 10);
                    if (!isNaN(extActivity) && extActivity > lastActivity) {
                        lastActivity = extActivity;
                        if (isWarningOpen) {
                            if (countdownInterval) {
                                clearInterval(countdownInterval);
                                countdownInterval = null;
                            }
                            Swal.close();
                            isWarningOpen = false;
                        }
                    }
                }
            });

            // Pantau event aktivitas pengguna (mouse, ketikan keyboard, scroll, layar sentuh)
            const activityEvents = ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart'];
            activityEvents.forEach(function(evt) {
                window.addEventListener(evt, function() {
                    // Jika popup peringatan sedang aktif, jangan reset otomatis karena mouse bergerak tipis.
                    // Pengguna harus secara sadar menekan "Tetap Masuk".
                    if (isWarningOpen) return;

                    if (!activityThrottleTimer) {
                        activityThrottleTimer = setTimeout(function() {
                            activityThrottleTimer = null;
                            recordUserActivity(false);
                        }, 1000);
                    }
                }, { passive: true });
            });

            // Timer pengecekan inaktivitas berkala (setiap 2 detik)
            setInterval(checkInactivity, 2000);

            // Cek langsung saat tab browser kembali aktif setelah diminimalkan / laptop bangun dari sleep
            document.addEventListener('visibilitychange', function() {
                if (!document.hidden) {
                    checkInactivity();
                }
            });
            window.addEventListener('focus', function() {
                checkInactivity();
            });
        })();
    </script>
    @yield('scripts')
</body>
</html>
