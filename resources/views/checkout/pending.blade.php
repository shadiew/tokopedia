@extends('layouts.app')

@section('title', 'Menunggu Pembayaran - Toko Digital Download')
@section('description', 'Pesanan Anda sedang menunggu konfirmasi pembayaran.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-warning bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-clock fa-3x"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold text-warning mb-3">Menunggu Pembayaran</h2>
                    <p class="lead text-muted mb-4">
                        Pesanan Anda telah dibuat dan sedang menunggu konfirmasi pembayaran.
                    </p>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold">Nomor Pesanan</h6>
                                    <p class="mb-0">{{ $order->order_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold">Total Pembayaran</h6>
                                    <p class="mb-0">{{ $order->formatted_final_amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bank Transfer Instructions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">
                                <i class="fas fa-university me-2"></i>Instruksi Pembayaran Bank Transfer
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Bank BCA</h6>
                                    <p class="mb-1">No. Rekening: 1234567890</p>
                                    <p class="mb-1">Atas Nama: DigitalStore</p>
                                    <p class="mb-3">Cabang: Jakarta Pusat</p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Bank Mandiri</h6>
                                    <p class="mb-1">No. Rekening: 0987654321</p>
                                    <p class="mb-1">Atas Nama: DigitalStore</p>
                                    <p class="mb-3">Cabang: Jakarta Selatan</p>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <h6 class="fw-bold mb-2">Langkah Pembayaran:</h6>
                                <ol class="mb-0">
                                    <li>Transfer ke salah satu rekening di atas</li>
                                    <li>Jumlah transfer: <strong>{{ $order->formatted_final_amount }}</strong></li>
                                    <li>Simpan bukti transfer</li>
                                    <li>Upload bukti transfer melalui dashboard</li>
                                    <li>Tunggu konfirmasi dari admin (maksimal 24 jam)</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Produk yang Dibeli</h5>
                        @foreach($order->orderItems as $item)
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $item->product->name }}" style="height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->product->category->name }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="fw-bold">{{ $item->formatted_subtotal }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('user.dashboard') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-list me-2"></i>Lihat Pesanan
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-muted small">
                            Email konfirmasi telah dikirim ke <strong>{{ $order->billing_email }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Important Notes -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Penting
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-warning">Batas Waktu Pembayaran</h6>
                            <p class="text-muted small">
                                Pembayaran harus dilakukan dalam waktu 24 jam setelah pesanan dibuat. 
                                Jika tidak, pesanan akan dibatalkan otomatis.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-info">Konfirmasi Pembayaran</h6>
                            <p class="text-muted small">
                                Setelah melakukan transfer, upload bukti transfer melalui dashboard 
                                untuk mempercepat proses konfirmasi.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contact Support -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-headset me-2"></i>Butuh Bantuan?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <i class="fas fa-envelope fa-2x text-primary mb-2"></i>
                            <h6>Email</h6>
                            <small class="text-muted">support@digitalstore.com</small>
                        </div>
                        <div class="col-md-4">
                            <i class="fab fa-whatsapp fa-2x text-success mb-2"></i>
                            <h6>WhatsApp</h6>
                            <small class="text-muted">+62 812-3456-7890</small>
                        </div>
                        <div class="col-md-4">
                            <i class="fas fa-phone fa-2x text-info mb-2"></i>
                            <h6>Telepon</h6>
                            <small class="text-muted">+62 21-1234-5678</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 