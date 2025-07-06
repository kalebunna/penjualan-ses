<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV. Baina Basukarta - Air Minum Dalam Kemasan Premium</title>
    <meta name="description" content="CV. Baina Basukarta - Perusahaan air minum dalam kemasan premium dengan merek Baina. Berdiri sejak 2019, melayani kebutuhan air minum berkualitas di seluruh Indonesia.">
    
    <!-- Mazer Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Custom CSS -->
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .company-logo {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            margin-bottom: 1rem;
        }
        
        .hero-subtitle {
            font-size: 1.5rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 2rem;
        }
        
        .cta-button {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            border: none;
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            color: white;
        }
        
        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        }
        
        .feature-icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .about-section {
            background: #f8f9fa;
            padding: 5rem 0;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .stats-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }
        
        .water-drop {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        
        .water-drop:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .water-drop:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
        }
        
        .water-drop:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: white !important;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 3rem 0 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(0,0,0,0.1); backdrop-filter: blur(10px);">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('logo.jpeg') }}" alt="CV. Baina Basukarta" style="height: 40px; width: auto;" class="me-2">
                CV. Baina Basukarta
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right me-1"></i>
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="water-drop"></div>
        <div class="water-drop"></div>
        <div class="water-drop"></div>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="company-logo">
                        <img src="{{ asset('logo.jpeg') }}" alt="CV. Baina Basukarta" style="height: 80px; width: auto;" class="me-3">
                        CV. Baina Basukarta
                    </h1>
                    <p class="hero-subtitle">
                        Air Minum Dalam Kemasan Premium dengan Merek "BAINA"
                    </p>
                    <p class="text-white mb-4" style="font-size: 1.1rem; opacity: 0.9;">
                        Menyediakan air minum berkualitas tinggi sejak 2019, melayani kebutuhan masyarakat Indonesia dengan teknologi modern dan standar kesehatan terbaik.
                    </p>
                    <a href="#about" class="cta-button">
                        <i class="bi bi-info-circle me-2"></i>
                        Pelajari Lebih Lanjut
                    </a>
                </div>
                <div class="col-lg-6 text-center">
                    <div class="position-relative">
                        <i class="bi bi-droplet-fill" style="font-size: 20rem; color: rgba(255,255,255,0.2);"></i>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-droplet-fill" style="font-size: 8rem; color: rgba(255,255,255,0.8);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 fw-bold mb-3">
                        <i class="bi bi-building me-3"></i>
                        Tentang Perusahaan
                    </h2>
                    <p class="lead text-muted">Mengenal lebih dekat CV. Baina Basukarta</p>
                </div>
            </div>
            
            <div class="row mb-5">
                <div class="col-lg-8 mx-auto">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-calendar-event text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="mb-0">Berdiri Sejak</h5>
                                            <p class="text-muted mb-0">29 Agustus 2019</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-geo-alt text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="mb-0">Lokasi</h5>
                                            <p class="text-muted mb-0">Jl. Pakandangan Tengah, Kec. Bluto</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-tag text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="mb-0">Merek</h5>
                                            <p class="text-muted mb-0">BAINA</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="bi bi-gear text-primary me-3" style="font-size: 2rem;"></i>
                                        <div>
                                            <h5 class="mb-0">Bidang</h5>
                                            <p class="text-muted mb-0">Industri Manufacture AMDK</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-lg">
                        <div class="card-body p-5">
                            <h3 class="mb-4">
                                <i class="bi bi-lightbulb me-2"></i>
                                Visi & Misi
                            </h3>
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-primary">
                                        <i class="bi bi-eye me-2"></i>
                                        Visi
                                    </h5>
                                    <p class="text-muted">
                                        Menjadi perusahaan air minum dalam kemasan terpercaya yang menyediakan produk berkualitas tinggi untuk memenuhi kebutuhan masyarakat Indonesia.
                                    </p>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <h5 class="text-primary">
                                        <i class="bi bi-target me-2"></i>
                                        Misi
                                    </h5>
                                    <p class="text-muted">
                                        Memproduksi air minum dalam kemasan dengan standar kesehatan tertinggi, menggunakan teknologi modern, dan memberikan pelayanan terbaik kepada pelanggan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-4 fw-bold mb-3">
                        <i class="bi bi-star me-3"></i>
                        Keunggulan Kami
                    </h2>
                    <p class="lead text-muted">Mengapa memilih produk BAINA?</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-shield-check feature-icon"></i>
                        <h4>Kualitas Terjamin</h4>
                        <p class="text-muted">
                            Air minum dengan standar kesehatan tertinggi, diproses menggunakan teknologi modern dan sistem filtrasi berkualitas.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-truck feature-icon"></i>
                        <h4>Distribusi Luas</h4>
                        <p class="text-muted">
                            Jaringan distribusi yang luas ke berbagai provinsi dan kota di seluruh Indonesia untuk memenuhi kebutuhan pelanggan.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h4>Peramalan Cerdas</h4>
                        <p class="text-muted">
                            Sistem peramalan penjualan yang canggih untuk memastikan ketersediaan produk sesuai dengan permintaan pasar.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-heart feature-icon"></i>
                        <h4>Kepuasan Pelanggan</h4>
                        <p class="text-muted">
                            Fokus pada kepuasan pelanggan dengan produk berkualitas dan pelayanan yang responsif.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-award feature-icon"></i>
                        <h4>Pengalaman Bertahun-tahun</h4>
                        <p class="text-muted">
                            Berpengalaman dalam industri AMDK sejak 2019 dengan pemahaman mendalam tentang kebutuhan pasar.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="feature-card">
                        <i class="bi bi-gear-wide-connected feature-icon"></i>
                        <h4>Teknologi Modern</h4>
                        <p class="text-muted">
                            Menggunakan teknologi modern dalam proses produksi dan manajemen untuk efisiensi optimal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-number">4+</div>
                        <div class="stats-label">Tahun Pengalaman</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-number">100%</div>
                        <div class="stats-label">Kualitas Terjamin</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-number">24/7</div>
                        <div class="stats-label">Pelayanan</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-number">∞</div>
                        <div class="stats-label">Kepuasan Pelanggan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <img src="{{ asset('logo.jpeg') }}" alt="CV. Baina Basukarta" style="height: 30px; width: auto;" class="me-2">
                        CV. Baina Basukarta
                    </h5>
                    <p class="text-muted">
                        Perusahaan air minum dalam kemasan premium dengan merek BAINA, berkomitmen menyediakan produk berkualitas tinggi untuk masyarakat Indonesia.
                    </p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">Kontak</h5>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span class="text-muted">Jl. Pakandangan Tengah, Kec. Bluto</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-calendar-event me-2"></i>
                        <span class="text-muted">Berdiri sejak 29 Agustus 2019</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-tag me-2"></i>
                        <span class="text-muted">Merek: BAINA</span>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">Layanan</h5>
                    <ul class="list-unstyled text-muted">
                        <li><i class="bi bi-check-circle me-2"></i>Air Minum Dalam Kemasan</li>
                        <li><i class="bi bi-check-circle me-2"></i>Distribusi Luas</li>
                        <li><i class="bi bi-check-circle me-2"></i>Kualitas Terjamin</li>
                        <li><i class="bi bi-check-circle me-2"></i>Pelayanan 24/7</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-12 text-center">
                    <p class="text-muted mb-0">
                        © 2024 CV. Baina Basukarta. Semua hak dilindungi.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mazer Theme JS -->
    <script src="{{ asset('assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('assets/extensions/bootstrap-icons/bootstrap-icons.js') }}"></script>
    
    <!-- Smooth Scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
