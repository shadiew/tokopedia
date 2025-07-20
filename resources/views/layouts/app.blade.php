<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- SEO Meta Tags -->
    <title>@yield('title', 'Toko Digital Download - Produk Digital Berkualitas')</title>
    <meta name="description" content="@yield('description', 'Temukan produk digital berkualitas tinggi dengan harga terjangkau. Download langsung setelah pembayaran.')">
    <meta name="keywords" content="@yield('keywords', 'digital download, produk digital, template, ebook, software, aplikasi')">
    <meta name="author" content="Toko Digital Download">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Toko Digital Download')">
    <meta property="og:description" content="@yield('description', 'Temukan produk digital berkualitas tinggi dengan harga terjangkau.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ request()->url() }}">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Toko Digital Download')">
    <meta name="twitter:description" content="@yield('description', 'Temukan produk digital berkualitas tinggi dengan harga terjangkau.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-download me-2"></i>
                DigitalStore
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home me-1"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('store') ? 'active' : '' }}" href="{{ route('store') }}">
                            <i class="fas fa-store me-1"></i> Toko
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-th-large me-1"></i> Kategori
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(\App\Models\Category::active()->take(6)->get() as $category)
                                <li><a class="dropdown-item" href="{{ route('category', $category->slug) }}">{{ $category->name }}</a></li>
                            @endforeach
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('store') }}">Semua Kategori</a></li>
                        </ul>
                    </li>

                </ul>
                
                <!-- Search Form -->
                <form class="d-flex me-3" action="{{ route('search') }}" method="GET" id="search-form">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" id="search-input" placeholder="Cari produk..." value="{{ request('q') }}">
                        <button class="btn btn-outline-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Right Navigation -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('cart.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge" style="display: none;">0</span>
                        </a>
                    </li>
                    
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="fas fa-user-edit me-2"></i> Profil
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.orders') }}">
                                    <i class="fas fa-shopping-bag me-2"></i> Pesanan
                                </a></li>
                                <li><a class="dropdown-item" href="{{ route('user.purchases') }}">
                                    <i class="fas fa-download me-2"></i> Pembelian
                                </a></li>
                                @if(Auth::user()->role === 'admin')
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-crown me-2"></i> Admin Dashboard
                                </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-1"></i> Daftar
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert Container -->
    <div id="alert-container" class="position-fixed top-0 end-0 p-3" style="z-index: 1050;"></div>

    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-3">
                        <i class="fas fa-download me-2"></i> DigitalStore
                    </h5>
                    <p class="text-white">
                        Platform toko digital download terpercaya dengan produk berkualitas tinggi dan layanan pelanggan yang memuaskan.
                    </p>
                    <div class="social-links">
                        <a href="#" data-bs-toggle="tooltip" title="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" data-bs-toggle="tooltip" title="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" data-bs-toggle="tooltip" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" data-bs-toggle="tooltip" title="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Produk</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('store') }}" class="text-white text-decoration-none">Semua Produk</a></li>
                        <li><a href="{{ route('store') }}?sort=popular" class="text-white text-decoration-none">Terpopuler</a></li>
                        <li><a href="{{ route('store') }}?sort=latest" class="text-white text-decoration-none">Terbaru</a></li>
                        <li><a href="{{ route('store') }}?sort=price_low" class="text-white text-decoration-none">Harga Terendah</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('contact') }}" class="text-white text-decoration-none">Kontak Kami</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-white text-decoration-none">Privasi</a></li>
                        <li><a href="{{ route('terms') }}" class="text-white text-decoration-none">Syarat & Ketentuan</a></li>
                        <li><a href="{{ route('about') }}" class="text-white text-decoration-none">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Akun</h6>
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('user.dashboard') }}" class="text-white text-decoration-none">Dashboard</a></li>
                            <li><a href="{{ route('user.profile') }}" class="text-white text-decoration-none">Profil</a></li>
                            <li><a href="{{ route('user.orders') }}" class="text-white text-decoration-none">Pesanan</a></li>
                            <li><a href="{{ route('user.purchases') }}" class="text-white text-decoration-none">Pembelian</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-white text-decoration-none">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-white text-decoration-none">Daftar</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">Pembayaran</h6>
                    <ul class="list-unstyled">
                        <li><span class="text-white">Bank Transfer</span></li>
                        <li><span class="text-white">Credit Card</span></li>
                        <li><span class="text-white">PayPal</span></li>
                        <li><span class="text-white">E-Wallet</span></li>
                    </ul>
                </div>
            </div>
            
            <hr class="border-secondary">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white mb-0">
                        &copy; {{ date('Y') }} DigitalStore. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-white mb-0">
                        Made with <i class="fas fa-heart text-danger"></i> in Indonesia
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 