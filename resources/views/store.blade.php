@extends('layouts.app')

@section('title', 'Toko - Semua Produk Digital')
@section('description', 'Jelajahi ribuan produk digital berkualitas tinggi dengan berbagai kategori dan harga terjangkau.')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-filter me-2"></i>Filter</h6>
                </div>
                <div class="card-body">
                    <!-- Search -->
                    <form action="{{ route('store') }}" method="GET" class="mb-4">
                        <div class="mb-3">
                            <label for="search" class="form-label">Cari Produk</label>
                            <input type="text" class="form-control" id="search" name="search" 
                                   value="{{ request('search') }}" placeholder="Nama produk...">
                        </div>
                        
                        <!-- Category Filter -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Price Range -->
                        <div class="mb-3">
                            <label class="form-label">Rentang Harga</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="number" class="form-control" name="min_price" 
                                           placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" name="max_price" 
                                           placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sort -->
                        <div class="mb-3">
                            <label for="sort" class="form-label">Urutkan</label>
                            <select class="form-select" id="sort" name="sort">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Terapkan Filter
                        </button>
                        
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort']))
                            <a href="{{ route('store') }}" class="btn btn-outline-secondary w-100 mt-2">
                                <i class="fas fa-times me-2"></i>Reset Filter
                            </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Product Grid -->
        <div class="col-lg-9">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">Semua Produk</h2>
                    <p class="text-muted mb-0">
                        {{ $products->total() }} produk ditemukan
                        @if(request('search'))
                            untuk "{{ request('search') }}"
                        @endif
                    </p>
                </div>
                
                <!-- View Toggle -->
                <div class="btn-group" role="group">
                    <input type="radio" class="btn-check" name="view" id="grid-view" checked>
                    <label class="btn btn-outline-primary" for="grid-view">
                        <i class="fas fa-th"></i>
                    </label>
                    
                    <input type="radio" class="btn-check" name="view" id="list-view">
                    <label class="btn btn-outline-primary" for="list-view">
                        <i class="fas fa-list"></i>
                    </label>
                </div>
            </div>
            
            <!-- Products -->
            @if($products->count() > 0)
                <div class="row g-4" id="products-grid">
                    @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card product-card h-100">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                                 class="card-img-top product-image" alt="{{ $product->name }}">
                            
                            @if($product->is_featured)
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="badge bg-warning">
                                        <i class="fas fa-star me-1"></i>Unggulan
                                    </span>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <div class="mb-2">
                                    <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                </div>
                                
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 100) }}</p>
                                
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
                                    
                                    <div class="mt-2 text-muted small">
                                        <i class="fas fa-download me-1"></i>{{ $product->download_count }} download
                                        <span class="ms-2">
                                            <i class="fas fa-eye me-1"></i>{{ $product->view_count }} dilihat
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-3x text-muted"></i>
                    </div>
                    <h4 class="text-muted">Tidak ada produk ditemukan</h4>
                    <p class="text-muted">
                        @if(request('search'))
                            Tidak ada produk yang sesuai dengan pencarian "{{ request('search') }}"
                        @else
                            Belum ada produk yang tersedia saat ini
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                        <a href="{{ route('store') }}" class="btn btn-primary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- List View (Hidden by default) -->
<div class="container py-5" id="products-list" style="display: none;">
    <div class="row">
        <div class="col-12">
            @if($products->count() > 0)
                @foreach($products as $product)
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-3">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                                 class="img-fluid rounded-start h-100" style="object-fit: cover;" alt="{{ $product->name }}">
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="mb-2">
                                            <span class="badge bg-secondary">{{ $product->category->name }}</span>
                                            @if($product->is_featured)
                                                <span class="badge bg-warning ms-1">
                                                    <i class="fas fa-star me-1"></i>Unggulan
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 200) }}</p>
                                        
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="product-price fs-5">{{ $product->formatted_price }}</span>
                                                <small class="text-muted ms-2">{{ $product->formatted_file_size }}</small>
                                            </div>
                                            
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </a>
                                                <button class="btn btn-primary add-to-cart" data-product-id="{{ $product->id }}">
                                                    <i class="fas fa-cart-plus me-1"></i> Tambah ke Keranjang
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-2 text-muted small">
                                            <i class="fas fa-download me-1"></i>{{ $product->download_count }} download
                                            <span class="ms-3">
                                                <i class="fas fa-eye me-1"></i>{{ $product->view_count }} dilihat
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const gridView = document.getElementById('grid-view');
    const listView = document.getElementById('list-view');
    const productsGrid = document.getElementById('products-grid');
    const productsList = document.getElementById('products-list');
    
    gridView.addEventListener('change', function() {
        productsGrid.style.display = 'flex';
        productsList.style.display = 'none';
    });
    
    listView.addEventListener('change', function() {
        productsGrid.style.display = 'none';
        productsList.style.display = 'block';
    });
});
</script>
@endpush 