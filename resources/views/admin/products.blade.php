@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin Dashboard')
@section('page-title', 'Kelola Produk')

@section('breadcrumb')
<li class="breadcrumb-item active">Produk</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-box me-2"></i>
            Daftar Produk
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" onclick="exportProducts()">
                <i class="fas fa-download me-1"></i> Export
            </button>
            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="fas fa-plus me-1"></i> Tambah Produk
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Statistik</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded d-flex align-items-center justify-content-center me-2" 
                                     style="width: 50px; height: 50px;">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <div>
                                    <strong>{{ $product->name }}</strong>
                                    <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($product->category)
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                            @else
                                <span class="badge bg-secondary">No Category</span>
                            @endif
                        </td>
                        <td>
                            <strong>Rp {{ number_format($product->price) }}</strong>
                        </td>
                        <td>
                            @if($product->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                @if($product->is_featured)
                                    <span class="badge bg-warning">Featured</span>
                                @endif
                                @if($product->is_recommended)
                                    <span class="badge bg-info">Recommended</span>
                                @endif
                                @if($product->is_bestseller)
                                    <span class="badge bg-success">Bestseller</span>
                                @endif
                            </div>
                            <small class="text-muted d-block mt-1">
                                {{ $product->download_count }} downloads, {{ $product->view_count }} views
                            </small>
                        </td>
                        <td>{{ $product->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#productModal{{ $product->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                        onclick="toggleProductStatus({{ $product->id }})">
                                    <i class="fas fa-toggle-on"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.products.delete', $product->id) }}" 
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Product Detail Modal -->
                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Informasi Produk</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Nama:</strong></td>
                                                    <td>{{ $product->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Slug:</strong></td>
                                                    <td>{{ $product->slug }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Kategori:</strong></td>
                                                    <td>{{ $product->category->name ?? 'No Category' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Harga:</strong></td>
                                                    <td>Rp {{ number_format($product->price) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @if($product->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>File:</strong></td>
                                                    <td>{{ $product->file_name ?? 'No file' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>File Size:</strong></td>
                                                    <td>{{ $product->file_size ? number_format($product->file_size / 1024 / 1024, 2) . ' MB' : 'N/A' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Flags</h6>
                                            <div class="mb-3">
                                                @if($product->is_featured)
                                                    <span class="badge bg-warning me-1">Featured</span>
                                                @endif
                                                @if($product->is_recommended)
                                                    <span class="badge bg-info me-1">Recommended</span>
                                                @endif
                                                @if($product->is_bestseller)
                                                    <span class="badge bg-success me-1">Bestseller</span>
                                                @endif
                                            </div>
                                            
                                            <h6>Statistik</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="text-center p-3 bg-light rounded">
                                                        <h4 class="mb-0">{{ $product->download_count }}</h4>
                                                        <small class="text-muted">Downloads</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-center p-3 bg-light rounded">
                                                        <h4 class="mb-0">{{ $product->view_count }}</h4>
                                                        <small class="text-muted">Views</small>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <h6 class="mt-3">Deskripsi</h6>
                                            <p class="text-muted">{{ $product->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada produk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $products->total() }}</h3>
                <p class="mb-0">Total Produk</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $products->where('is_active', true)->count() }}</h3>
                <p class="mb-0">Produk Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
        <div class="card-body text-center">
                <h3 class="mb-0">{{ $products->where('is_featured', true)->count() }}</h3>
                <p class="mb-0">Featured</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $products->sum('download_count') }}</h3>
                <p class="mb-0">Total Downloads</p>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="#" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select" name="category_id" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Harga</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">File Produk</label>
                                <input type="file" class="form-control" name="file" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured">
                                <label class="form-check-label" for="is_featured">
                                    Featured
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_recommended" id="is_recommended">
                                <label class="form-check-label" for="is_recommended">
                                    Recommended
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_bestseller" id="is_bestseller">
                                <label class="form-check-label" for="is_bestseller">
                                    Bestseller
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan Produk</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportProducts() {
    alert('Fitur export akan segera tersedia');
}

function toggleProductStatus(productId) {
    if (confirm('Yakin ingin mengubah status produk ini?')) {
        fetch(`/admin/products/${productId}/toggle`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
@endpush 