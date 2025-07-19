@extends('layouts.app')

@section('title', 'Checkout - Toko Digital Download')
@section('description', 'Lengkapi informasi pembayaran untuk menyelesaikan pesanan Anda.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-credit-card me-2"></i>Checkout
            </h1>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Billing Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-user me-2"></i>Informasi Pembayaran
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_name" class="form-label">Nama Lengkap *</label>
                                <input type="text" class="form-control @error('billing_name') is-invalid @enderror" 
                                       id="billing_name" name="billing_name" value="{{ old('billing_name', Auth::user()->name ?? '') }}" required>
                                @error('billing_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="billing_email" class="form-label">Email *</label>
                                <input type="email" class="form-control @error('billing_email') is-invalid @enderror" 
                                       id="billing_email" name="billing_email" value="{{ old('billing_email', Auth::user()->email ?? '') }}" required>
                                @error('billing_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="billing_phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('billing_phone') is-invalid @enderror" 
                                       id="billing_phone" name="billing_phone" value="{{ old('billing_phone', Auth::user()->phone ?? '') }}">
                                @error('billing_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">Metode Pembayaran *</label>
                                <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                    <option value="">Pilih metode pembayaran</option>
                                    <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>
                                        Bank Transfer
                                    </option>
                                    <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>
                                        Credit Card
                                    </option>
                                    <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>
                                        PayPal
                                    </option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Alamat (Opsional)</label>
                            <textarea class="form-control @error('billing_address') is-invalid @enderror" 
                                      id="billing_address" name="billing_address" rows="3">{{ old('billing_address', Auth::user()->address ?? '') }}</textarea>
                            @error('billing_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2" 
                                      placeholder="Catatan khusus untuk pesanan Anda...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-shopping-bag me-2"></i>Detail Pesanan
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($products as $product)
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/placeholder.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $product->name }}" style="height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->category->name }}</small><br>
                                <small class="text-muted">{{ $product->formatted_file_size }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">Qty: {{ $product->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="fw-bold">{{ $product->formatted_subtotal }}</span>
                            </div>
                        </div>
                        @endforeach
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
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-lock me-2"></i>Bayar Sekarang
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Keranjang
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

                <!-- Payment Security -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h6 class="mb-0">
                            <i class="fas fa-shield-alt me-2"></i>Keamanan Pembayaran
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="text-center p-2 border rounded">
                                    <i class="fas fa-lock text-success mb-1"></i>
                                    <div class="small">SSL Secure</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 border rounded">
                                    <i class="fas fa-user-shield text-success mb-1"></i>
                                    <div class="small">Data Protected</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 border rounded">
                                    <i class="fas fa-credit-card text-success mb-1"></i>
                                    <div class="small">Secure Payment</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center p-2 border rounded">
                                    <i class="fas fa-headset text-success mb-1"></i>
                                    <div class="small">24/7 Support</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Terms -->
                <div class="card mt-3">
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agree_terms" required>
                            <label class="form-check-label small" for="agree_terms">
                                Saya setuju dengan <a href="{{ route('terms') }}" target="_blank">Syarat & Ketentuan</a> dan 
                                <a href="{{ route('privacy') }}" target="_blank">Kebijakan Privasi</a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    });
});
</script>
@endpush 