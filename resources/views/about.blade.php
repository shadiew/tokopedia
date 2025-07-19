@extends('layouts.app')

@section('title', 'Tentang Kami - Toko Digital Download')
@section('description', 'Pelajari lebih lanjut tentang DigitalStore, platform toko digital download terpercaya dengan produk berkualitas tinggi.')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-lg-8 mx-auto text-center">
            <h1 class="display-4 fw-bold mb-4">
                <i class="fas fa-download text-primary me-3"></i>
                Tentang DigitalStore
            </h1>
            <p class="lead text-muted">
                Platform toko digital download terpercaya yang menyediakan produk digital berkualitas tinggi 
                dengan harga terjangkau dan layanan pelanggan yang memuaskan.
            </p>
        </div>
    </div>

    <!-- Mission & Vision -->
    <div class="row mb-5">
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-bullseye fa-3x text-primary"></i>
                    </div>
                    <h4 class="card-title mb-3">Misi Kami</h4>
                    <p class="card-text text-muted">
                        Menyediakan akses mudah dan aman ke produk digital berkualitas tinggi, 
                        mendukung kreator lokal dan internasional, serta memberikan pengalaman 
                        berbelanja yang nyaman dan terpercaya.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-eye fa-3x text-success"></i>
                    </div>
                    <h4 class="card-title mb-3">Visi Kami</h4>
                    <p class="card-text text-muted">
                        Menjadi platform digital download terdepan di Indonesia yang menghubungkan 
                        kreator dengan pengguna, mendorong inovasi digital, dan berkontribusi 
                        pada pertumbuhan ekonomi digital.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Nilai-Nilai Kami</h2>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-shield-alt fa-2x text-primary"></i>
                </div>
                <h5>Keamanan</h5>
                <p class="text-muted small">
                    Memastikan keamanan transaksi dan data pengguna dengan teknologi terbaru.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-star fa-2x text-warning"></i>
                </div>
                <h5>Kualitas</h5>
                <p class="text-muted small">
                    Hanya menyediakan produk digital berkualitas tinggi yang telah diverifikasi.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-headset fa-2x text-info"></i>
                </div>
                <h5>Layanan</h5>
                <p class="text-muted small">
                    Memberikan layanan pelanggan yang responsif dan memuaskan 24/7.
                </p>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="text-center">
                <div class="mb-3">
                    <i class="fas fa-handshake fa-2x text-success"></i>
                </div>
                <h5>Kepercayaan</h5>
                <p class="text-muted small">
                    Membangun hubungan jangka panjang berdasarkan kepercayaan dan transparansi.
                </p>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Mengapa Memilih DigitalStore?</h2>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-download text-primary"></i>
                        </div>
                        <h5 class="mb-0">Download Instan</h5>
                    </div>
                    <p class="text-muted">
                        Setelah pembayaran berhasil, Anda dapat langsung mengunduh produk 
                        tanpa perlu menunggu konfirmasi manual.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-shield-alt text-success"></i>
                        </div>
                        <h5 class="mb-0">Pembayaran Aman</h5>
                    </div>
                    <p class="text-muted">
                        Sistem pembayaran yang aman dengan berbagai metode pembayaran 
                        yang dapat Anda pilih sesuai kebutuhan.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                            <i class="fas fa-headset text-info"></i>
                        </div>
                        <h5 class="mb-0">Dukungan 24/7</h5>
                    </div>
                    <p class="text-muted">
                        Tim dukungan kami siap membantu Anda kapan saja dengan 
                        layanan yang cepat dan profesional.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">Tim Kami</h2>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/150x150/0d6efd/ffffff?text=CEO" 
                             alt="CEO" class="rounded-circle" width="100">
                    </div>
                    <h5 class="card-title">Ahmad Rahman</h5>
                    <p class="text-muted">CEO & Founder</p>
                    <p class="card-text small text-muted">
                        Memiliki pengalaman lebih dari 10 tahun di industri digital dan e-commerce.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/150x150/198754/ffffff?text=CTO" 
                             alt="CTO" class="rounded-circle" width="100">
                    </div>
                    <h5 class="card-title">Sarah Wijaya</h5>
                    <p class="text-muted">CTO</p>
                    <p class="card-text small text-muted">
                        Ahli teknologi dengan fokus pada pengembangan platform yang aman dan scalable.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body p-4">
                    <div class="mb-3">
                        <img src="https://via.placeholder.com/150x150/dc3545/ffffff?text=CMO" 
                             alt="CMO" class="rounded-circle" width="100">
                    </div>
                    <h5 class="card-title">Budi Santoso</h5>
                    <p class="text-muted">CMO</p>
                    <p class="card-text small text-muted">
                        Spesialis marketing digital dengan strategi pertumbuhan yang inovatif.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card bg-primary text-white border-0 shadow">
                <div class="card-body text-center p-5">
                    <h3 class="mb-3">Ada Pertanyaan?</h3>
                    <p class="mb-4">
                        Tim kami siap membantu Anda dengan pertanyaan atau kebutuhan khusus. 
                        Jangan ragu untuk menghubungi kami.
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-envelope me-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 