<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'JDIH DPRD Bolaang Mongondow Utara')</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Jaringan Dokumentasi dan Informasi Hukum (JDIH) Sekretariat DPRD Kabupaten Bolaang Mongondow Utara. Portal resmi produk hukum DPRD.">
    <meta name="keywords" content="JDIH, DPRD, Bolaang Mongondow Utara, Produk Hukum, Perda, Keputusan DPRD">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Theme Styles -->
    <style>
        :root {
            --primary-color: #0d3b66;
            --primary-light: #185a9d;
            --secondary-color: #f4d35e;
            --accent-color: #ee964b;
            --text-dark: #000814;
            --text-light: #f8f9fa;
            --bg-light: #f7f9fb;
            --card-shadow: 0 10px 30px rgba(13, 59, 102, 0.05);
            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar Customization */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(13, 59, 102, 0.08);
            padding: 15px 0;
            transition: var(--transition-smooth);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            letter-spacing: -0.5px;
        }
        
        .navbar-brand img {
            max-height: 45px;
            margin-right: 12px;
        }
        
        .nav-link {
            font-weight: 500;
            color: var(--primary-color) !important;
            padding: 8px 16px !important;
            border-radius: 8px;
            transition: var(--transition-smooth);
        }
        
        .nav-link:hover, .nav-link.active {
            background-color: rgba(13, 59, 102, 0.05);
            color: var(--primary-light) !important;
        }

        /* Glassmorphic Elements */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            border-radius: 16px;
        }

        /* Hover animations */
        .hover-lift {
            transition: var(--transition-smooth);
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(13, 59, 102, 0.1);
        }

        /* Footer styling */
        footer {
            background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);
            color: var(--text-light);
            margin-top: auto;
            border-top: 5px solid var(--secondary-color);
        }
        
        footer a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        
        footer a:hover {
            color: var(--secondary-color);
            padding-left: 5px;
        }

        /* Badge Styling */
        .badge-status {
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 30px;
        }
        .status-berlaku {
            background-color: rgba(25, 135, 84, 0.15);
            color: #198754;
        }
        .status-tidak-berlaku {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        .status-diubah {
            background-color: rgba(13, 110, 253, 0.15);
            color: #0d6efd;
        }
        .status-mencabut {
            background-color: rgba(253, 126, 20, 0.15);
            color: #fd7e14;
        }
    </style>
    @yield('styles')
</head>
<body>

    @include('layouts.partials.portal-navbar')

    <!-- Main Content Area -->
    <main>
        @yield('content')
    </main>

    @include('layouts.partials.portal-footer')

    <!-- Bootstrap 5 Bundle JS (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
