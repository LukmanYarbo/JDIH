<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Admin - JDIH {{ isset($gProfil) && $gProfil->nama_singkat_kantor ? $gProfil->nama_singkat_kantor : 'DPRD' }}</title>
    
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
    
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #07223c 0%, #0d3b66 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .login-header {
            background: rgba(13, 59, 102, 0.03);
            border-bottom: 1px solid rgba(13, 59, 102, 0.05);
            padding: 35px 30px;
            text-align: center;
        }

        .login-body {
            padding: 35px 30px;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 16px;
            border-color: rgba(13, 59, 102, 0.15);
        }

        .form-control:focus {
            border-color: #0d3b66;
            box-shadow: 0 0 0 0.25rem rgba(13, 59, 102, 0.1);
        }

        .btn-primary {
            background-color: #0d3b66;
            border-color: #0d3b66;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #07223c;
            border-color: #07223c;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <a href="{{ route('portal.home') }}" class="text-decoration-none">
                <i class="bi bi-bank2 text-primary display-5 d-block mb-3"></i>
            </a>
            <h4 class="fw-bold text-dark m-0">Login Dashboard</h4>
            <small class="text-muted">JDIH {{ $gProfil->nama_singkat_kantor ?? ($gProfil->nama_kantor ?? 'DPRD') }}</small>
        </div>
        <div class="login-body">
            
            <!-- Error messages -->
            @if ($errors->any())
                <div class="alert alert-danger border-0 py-2.5 fs-7 mb-4">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label fs-7 fw-semibold text-muted">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 border-color-soft" style="border-radius: 10px 0 0 10px;"><i class="bi bi-envelope text-muted"></i></span>
                        <input type="email" name="email" id="email" class="form-control border-start-0" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label fs-7 fw-semibold text-muted mb-1">Password</label>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" style="border-radius: 10px 0 0 10px;"><i class="bi bi-lock text-muted"></i></span>
                        <input type="password" name="password" id="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius: 0 10px 10px 0;">
                    </div>
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label fs-7 text-muted" for="remember">
                            Ingat Saya
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Masuk ke Dashboard
                </button>

                <div class="text-center">
                    <a href="{{ route('portal.home') }}" class="text-muted fs-7 text-decoration-none">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
            </form>

        </div>
    </div>

</body>
</html>
