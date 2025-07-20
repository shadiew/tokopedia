@extends('layouts.app')

@section('title', 'Keranjang Belanja - Toko Digital Download')
@section('description', 'Kelola keranjang belanja Anda dan lanjutkan ke pembayaran.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </h1>
        </div>
    </div>

    @if(count($products) > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-list me-2"></i>Produk dalam Keranjang ({{ count($products) }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($products as $product)
                        <div class="row align-items-center mb-4 pb-4 border-bottom">
                            <div class="col-md-2">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $product->name }}" style="height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-md-4">
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->category->name }}</small><br>
                                <small class="text-muted">{{ $product->formatted_file_size }}</small>
                            </div>
                            <div class="col-md-2">
                                <form method="POST" action="{{ route('cart.update', $product->id) }}" class="d-flex align-items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="decrement">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" name="quantity" class="form-control text-center form-control-sm" value="{{ $product->quantity }}" min="1" max="10" style="width: 40px;">
                                    <button class="btn btn-outline-secondary btn-sm" type="submit" name="action" value="increment">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="fw-bold">{{ $product->formatted_subtotal }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <form method="POST" action="{{ route('cart.remove', $product->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="text-end">
                            <!-- Tombol trigger modal -->
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#modalClearCart">
                                <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
                            </button>
                        </div>
                        <!-- Modal Bootstrap 5 -->
                        <div class="modal fade" id="modalClearCart" tabindex="-1" aria-labelledby="modalClearCartLabel" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalClearCartLabel">Konfirmasi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                              </div>
                              <div class="modal-body">
                                Apakah Anda yakin ingin mengosongkan keranjang?
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <form method="POST" action="{{ route('cart.clear') }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Kosongkan</button>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Ringkasan Pesanan
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal ({{ count($products) }} item)</span>
                            <span>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Pajak</span>
                            <span>Rp 0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Diskon</span>
                            <span>Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Total</span>
                            <span class="fw-bold fs-5 text-primary">{{ 'Rp ' . number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card me-2"></i>Lanjut ke Pembayaran
                            </a>
                            <a href="{{ route('store') }}" class="btn btn-outline-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Produk Lain
                            </a>
                        </div>
                        
                        <div class="mt-3">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Pembayaran aman dengan enkripsi SSL
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted mb-3">Keranjang Belanja Kosong</h4>
                        <p class="text-muted mb-4">
                            Anda belum menambahkan produk ke keranjang belanja.
                        </p>
                        <a href="{{ route('store') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-store me-2"></i>Mulai Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(productId, change) {
    const input = document.getElementById(`quantity-${productId}`);
    let newQuantity = parseInt(input.value) + change;
    
    if (newQuantity < 1) newQuantity = 1;
    if (newQuantity > 10) newQuantity = 10;
    
    input.value = newQuantity;
    
    // Update cart via AJAX
    fetch(`/cart/update/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ quantity: newQuantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Terjadi kesalahan saat memperbarui keranjang');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memperbarui keranjang');
    });
}

function removeItem(productId) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
        fetch(`/cart/remove/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan saat menghapus produk');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus produk');
        });
    }
}

// Update quantity on input change
document.addEventListener('DOMContentLoaded', function() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.id.replace('quantity-', '');
            const quantity = parseInt(this.value);
            
            if (quantity < 1) this.value = 1;
            if (quantity > 10) this.value = 10;
            
            updateQuantity(productId, 0);
        });
    });
});
</script>
@endpush 