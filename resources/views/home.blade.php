@extends('layouts.app')

@section('title', 'Beranda - Toko Digital Download')
@section('description', 'Temukan produk digital berkualitas tinggi dengan harga terjangkau. Download langsung setelah pembayaran.')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Temukan Produk Digital Berkualitas
                </h1>
                <p class="lead mb-4">
                    Platform toko digital download terpercaya dengan ribuan produk berkualitas tinggi. 
                    Download langsung setelah pembayaran, aman dan terpercaya.
                </p>
                <div class="d-flex gap-3">
                    <a href="{{ route('store') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-store me-2"></i> Jelajahi Toko
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-user-plus me-2"></i> Daftar Gratis
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/hero-illustration.svg') }}" alt="Digital Store" class="img-fluid" style="max-height: 400px;">
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Mengapa Memilih Kami?</h2>
                <p class="text-muted">Keunggulan platform digital download kami</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-download fa-2x"></i>
                        </div>
                        <h5 class="card-title">Download Instan</h5>
                        <p class="card-text text-muted">
                            Download langsung setelah pembayaran berhasil. Tidak perlu menunggu lama.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="card-title">Aman & Terpercaya</h5>
                        <p class="card-text text-muted">
                            Pembayaran aman dengan berbagai metode. Data Anda terlindungi dengan baik.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-headset fa-2x"></i>
                        </div>
                        <h5 class="card-title">Layanan 24/7</h5>
                        <p class="card-text text-muted">
                            Tim support kami siap membantu Anda kapan saja. Layanan pelanggan terbaik.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
@if($featuredProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Produk Unggulan</h2>
                <p class="text-muted">Produk terbaik yang kami rekomendasikan</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                         class="card-img-top product-image" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="product-price">{{ $product->formatted_price }}</span>
                                <small class="text-muted">{{ $product->formatted_file_size }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                                <button class="btn btn-primary btn-sm add-to-cart" data-product-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('store') }}" class="btn btn-outline-primary">
                Lihat Semua Produk <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Categories Section -->
@if($categories->count() > 0)
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Kategori Populer</h2>
                <p class="text-muted">Jelajahi produk berdasarkan kategori</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('category', $category->slug) }}" class="text-decoration-none">
                    <div class="card category-card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     class="rounded-circle mb-3" alt="{{ $category->name }}" 
                                     style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                                     style="width: 80px; height: 80px;">
                                    <i class="fas fa-folder fa-2x"></i>
                                </div>
                            @endif
                            <h5 class="card-title text-dark">{{ $category->name }}</h5>
                            <p class="card-text text-muted">{{ $category->products_count }} produk</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Products Section -->
@if($latestProducts->count() > 0)
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold">Produk Terbaru</h2>
                <p class="text-muted">Produk terbaru yang baru ditambahkan</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($latestProducts as $product)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                         class="card-img-top product-image" alt="{{ $product->name }}">
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="product-price">{{ $product->formatted_price }}</span>
                                <small class="text-muted">{{ $product->formatted_file_size }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                    <i class="fas fa-eye me-1"></i> Detail
                                </a>
                                <button class="btn btn-primary btn-sm add-to-cart" data-product-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Siap Memulai?</h2>
        <p class="lead mb-4">
            Bergabunglah dengan ribuan pengguna yang telah mempercayai platform kami
        </p>
        <div class="d-flex gap-3 justify-content-center">
            <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                <i class="fas fa-user-plus me-2"></i> Daftar Sekarang
            </a>
            <a href="{{ route('store') }}" class="btn btn-outline-light btn-lg">
                <i class="fas fa-store me-2"></i> Jelajahi Produk
            </a>
        </div>
    </div>
</section>
@endsection 