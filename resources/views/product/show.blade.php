@extends('layouts.app')

@section('title', $product->name . ' - Toko Digital Download')
@section('description', $product->meta_description ?: Str::limit($product->description, 160))
@section('keywords', $product->meta_keywords)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Toko</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-body p-0">
                    <div class="position-relative">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                             class="img-fluid product-main-image" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover;">
                        
                        @if($product->is_featured)
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-warning fs-6">
                                    <i class="fas fa-star me-1"></i>Unggulan
                                </span>
                            </div>
                        @endif
                        
                        @if($product->is_recommended)
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-info fs-6">
                                    <i class="fas fa-thumbs-up me-1"></i>Direkomendasikan
                                </span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Product Gallery (if multiple images) -->
                    @if($product->image)
                    <div class="product-gallery p-3">
                        <div class="row g-2">
                            <div class="col-3">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="img-thumbnail" alt="{{ $product->name }}" style="cursor: pointer; height: 80px; object-fit: cover;">
                            </div>
                            <!-- Add more gallery images here if available -->
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Info -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <span class="badge bg-secondary fs-6">{{ $product->category->name }}</span>
                    </div>
                    
                    <h1 class="h2 fw-bold mb-3">{{ $product->name }}</h1>
                    
                    <div class="mb-3">
                        <span class="product-price fs-2 fw-bold">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-muted mb-0">{{ $product->description }}</p>
                    </div>
                    
                    <!-- Product Stats -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="fw-bold text-primary">{{ $product->download_count }}</div>
                                <small class="text-muted">Download</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-3 bg-light rounded">
                                <div class="fw-bold text-primary">{{ $product->view_count }}</div>
                                <small class="text-muted">Dilihat</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- File Info -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Informasi File</h6>
                        <div class="row">
                            <div class="col-6">
                                <small class="text-muted">Ukuran File:</small><br>
                                <span class="fw-bold">{{ $product->formatted_file_size }}</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted">Tipe File:</small><br>
                                <span class="fw-bold">{{ $product->file_type ?: 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Purchase Options -->
                    <div class="mb-4">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <div class="flex-grow-1">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <input type="number" class="form-control quantity-input" id="quantity" name="quantity" 
                                       value="1" min="1" max="10" style="width: 100px;">
                            </div>
                            <div class="flex-grow-1">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100 add-to-cart" data-product-id="{{ $product->id }}">
                                    <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Buy Now -->
                    <div class="mb-4">
                        <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                        </a>
                    </div>
                    
                    <!-- Product Features -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Fitur Produk</h6>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Download langsung setelah pembayaran</li>
                            <li><i class="fas fa-check text-success me-2"></i>File berkualitas tinggi</li>
                            <li><i class="fas fa-check text-success me-2"></i>Update gratis selamanya</li>
                            <li><i class="fas fa-check text-success me-2"></i>Dukungan teknis 24/7</li>
                        </ul>
                    </div>
                    
                    <!-- Share -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-2">Bagikan</h6>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                               target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($product->name) }}" 
                               target="_blank" class="btn btn-outline-info btn-sm">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . request()->url()) }}" 
                               target="_blank" class="btn btn-outline-success btn-sm">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ request()->url() }}')">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">
                                <i class="fas fa-info-circle me-2"></i>Deskripsi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="features-tab" data-bs-toggle="tab" data-bs-target="#features" type="button" role="tab">
                                <i class="fas fa-list me-2"></i>Fitur
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                                <i class="fas fa-star me-2"></i>Ulasan
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="fw-bold mb-3">Deskripsi Produk</h5>
                                    <div class="text-muted">
                                        {!! nl2br(e($product->description)) !!}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="fw-bold mb-3">Spesifikasi</h6>
                                    <ul class="list-unstyled">
                                        <li class="mb-2">
                                            <small class="text-muted">Kategori:</small><br>
                                            <span class="fw-bold">{{ $product->category->name }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <small class="text-muted">Ukuran File:</small><br>
                                            <span class="fw-bold">{{ $product->formatted_file_size }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <small class="text-muted">Tipe File:</small><br>
                                            <span class="fw-bold">{{ $product->file_type ?: 'N/A' }}</span>
                                        </li>
                                        <li class="mb-2">
                                            <small class="text-muted">Tanggal Upload:</small><br>
                                            <span class="fw-bold">{{ $product->created_at->format('d M Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="features" role="tabpanel">
                            <h5 class="fw-bold mb-3">Fitur Utama</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kualitas tinggi</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Kompatibel dengan berbagai platform</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Dokumentasi lengkap</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Update gratis</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-unstyled">
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Dukungan teknis</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Lisensi komersial</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Source code tersedia</li>
                                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Responsive design</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <h5 class="fw-bold mb-3">Ulasan Produk</h5>
                            <div class="text-center py-4">
                                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada ulasan untuk produk ini</p>
                                <p class="text-muted small">Jadilah yang pertama memberikan ulasan!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Produk Terkait</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100">
                        <img src="{{ $relatedProduct->image ? asset('storage/' . $relatedProduct->image) : asset('images/placeholder.jpg') }}" 
                             class="card-img-top product-image" alt="{{ $relatedProduct->name }}">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                            <p class="card-text text-muted small">{{ Str::limit($relatedProduct->description, 80) }}</p>
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="product-price">{{ $relatedProduct->formatted_price }}</span>
                                    <small class="text-muted">{{ $relatedProduct->formatted_file_size }}</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn btn-outline-primary btn-sm flex-fill">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    <button class="btn btn-primary btn-sm add-to-cart" data-product-id="{{ $relatedProduct->id }}">
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
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const alert = document.createElement('div');
        alert.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        alert.innerHTML = `
            Link berhasil disalin!
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 3000);
    });
}
</script>
@endpush 