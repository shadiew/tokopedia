@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - Tokopedia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Detail Pesanan</h1>
                    <p class="text-gray-600">Order #{{ $order->order_number }}</p>
                </div>
                <a href="{{ route('user.orders') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Pesanan
                </a>
            </div>
        </div>

        <!-- Order Status -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 mb-6">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">Status Pesanan</h2>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'paid') bg-green-100 text-green-800
                            @elseif($order->status === 'completed') bg-blue-100 text-blue-800
                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                            @else bg-gray-100 text-gray-800 @endif">
                            @switch($order->status)
                                @case('pending')
                                    Menunggu Pembayaran
                                    @break
                                @case('paid')
                                    Sudah Dibayar
                                    @break
                                @case('completed')
                                    Selesai
                                    @break
                                @case('cancelled')
                                    Dibatalkan
                                    @break
                                @default
                                    {{ ucfirst($order->status) }}
                            @endswitch
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Tanggal Pesanan</p>
                        <p class="text-lg font-medium text-gray-900">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Item Pesanan</h2>
                        
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-medium text-gray-900">
                                            {{ $item->product_name }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Qty: {{ $item->quantity }} × Rp {{ number_format($item->price) }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex-shrink-0 text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($item->subtotal) }}
                                        </p>
                                        @if(in_array($order->status, ['paid', 'completed']))
                                            <a href="{{ route('product.download', $item->product->id) }}" 
                                               class="text-xs text-blue-600 hover:text-blue-800 mt-1 inline-block">
                                                Download
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md border border-gray-200">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($order->total_amount) }}</span>
                            </div>
                            
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pajak</span>
                                    <span class="font-medium">Rp {{ number_format($order->tax_amount) }}</span>
                                </div>
                            @endif
                            
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diskon</span>
                                    <span class="font-medium text-green-600">-Rp {{ number_format($order->discount_amount) }}</span>
                                </div>
                            @endif
                            
                            <hr class="my-3">
                            
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span>Rp {{ number_format($order->final_amount) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Metode Pembayaran</span>
                                <p class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                            </div>
                            
                            @if($order->payment)
                                <div>
                                    <span class="text-sm text-gray-600">Status Pembayaran</span>
                                    <p class="font-medium 
                                        @if($order->payment->status === 'paid') text-green-600
                                        @elseif($order->payment->status === 'pending') text-yellow-600
                                        @else text-gray-600 @endif">
                                        {{ ucfirst($order->payment->status) }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Billing Information -->
                <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penagihan</h2>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Nama</span>
                                <p class="font-medium">{{ $order->billing_name }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm text-gray-600">Email</span>
                                <p class="font-medium">{{ $order->billing_email }}</p>
                            </div>
                            
                            @if($order->billing_phone)
                                <div>
                                    <span class="text-sm text-gray-600">Telepon</span>
                                    <p class="font-medium">{{ $order->billing_phone }}</p>
                                </div>
                            @endif
                            
                            @if($order->billing_address)
                                <div>
                                    <span class="text-sm text-gray-600">Alamat</span>
                                    <p class="font-medium">{{ $order->billing_address }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 space-y-3">
                    @if($order->status === 'pending')
                        <a href="{{ route('checkout.pending', $order->order_number) }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Lanjutkan Pembayaran
                        </a>
                    @endif
                    
                    <a href="{{ route('user.orders') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Kembali ke Daftar Pesanan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 