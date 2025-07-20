@extends('layouts.app')

@section('title', $category->name . ' - Tokopedia')

@section('head')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav class="mb-4 mt-5" aria-label="Breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('store') }}">Store</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
        </ol>
    </nav>
    <!-- Category Header -->
    <div class="mb-4">
        <h1 class="h3 fw-bold text-dark mb-1">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-muted mb-1">{{ $category->description }}</p>
        @endif
        <p class="text-sm text-secondary">{{ $products->total() }} produk ditemukan</p>
    </div>
    @if($products->count() > 0)
    <div class="row g-4">
        @foreach($products as $product)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
            <div class="card shadow-sm border-0 flex-fill d-flex flex-column">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="card-img-top" style="height:180px;object-fit:cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height:180px;">
                        <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title mb-1 text-truncate" title="{{ $product->name }}">
                        <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none text-dark">{{ $product->name }}</a>
                    </h5>
                    <p class="card-text text-muted small mb-2 text-truncate" title="{{ $product->description }}">{{ $product->description }}</p>
                    <div class="mb-2">
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark me-1">Featured</span>
                        @endif
                        @if($product->is_recommended)
                            <span class="badge bg-primary me-1">Recommended</span>
                        @endif
                        @if($product->is_bestseller)
                            <span class="badge bg-danger">Bestseller</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            @if($product->discount_price)
                                <span class="fw-bold text-danger">Rp {{ number_format($product->discount_price) }}</span>
                                <span class="text-muted text-decoration-line-through ms-1">Rp {{ number_format($product->price) }}</span>
                            @else
                                <span class="fw-bold text-dark">Rp {{ number_format($product->price) }}</span>
                            @endif
                        </div>
                        @if($product->download_count > 0)
                            <span class="text-secondary small">{{ $product->download_count }}x unduh</span>
                        @endif
                    </div>
                    <div class="mt-auto d-flex gap-2">
                        <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary btn-sm flex-fill">Detail</a>
                        <button onclick="addToCart({{ $product->id }})" class="btn btn-success btn-sm d-flex align-items-center">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-4 mb-5">{{ $products->links() }}</div>
    @else
    <div class="text-center py-5">
        <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
        </svg>
        <h3 class="mb-2 h6 text-dark">Tidak ada produk</h3>
        <p class="text-muted">Belum ada produk dalam kategori ini.</p>
        <a href="{{ route('store') }}" class="btn btn-primary mt-3">Lihat Semua Produk</a>
    </div>
    @endif
</div>
<script>
function addToCart(productId) {
    fetch(`/cart/add/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartCount();
            showNotification('Produk berhasil ditambahkan ke keranjang!', 'success');
        } else {
            showNotification(data.message || 'Gagal menambahkan produk ke keranjang.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat menambahkan produk ke keranjang.', 'error');
    });
}
function updateCartCount() {
    fetch('/cart/count')
        .then(response => response.json())
        .then(data => {
            const cartCountElement = document.getElementById('cart-count');
            if (cartCountElement) {
                cartCountElement.textContent = data.count;
                cartCountElement.classList.toggle('hidden', data.count === 0);
            }
        });
}
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'}`;
    notification.textContent = message;
    document.body.appendChild(notification);
    setTimeout(() => { notification.remove(); }, 3000);
}
</script>
@endsection 