<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ config('app.name', 'Laravel') }} - Halaman Login</title>
        <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/extensions/bootstrap-icons/bootstrap-icons.css') }}">
    </head>
    <body>
        <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
        <div id="auth">
            <div class="row h-100">
                <div class="col-lg-5 col-12">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <a href="/" class="d-flex align-items-center text-decoration-none">
                                <i class="bi bi-droplet-fill me-2" style="font-size: 2rem; color: #667eea;"></i>
                                <span style="font-family: 'Poppins', sans-serif; font-weight: 700; font-size: 2rem; color: #667eea; letter-spacing: 0.5px;">BAINA</span>
                            </a>
                        </div>
                        {{ $slot }}
                    </div>
                </div>
                <div class="col-lg-7 d-none d-lg-block">
                    <div id="auth-right">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
