@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Tokopedia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Pesanan</h1>
            <p class="text-gray-600">Kelola dan lihat semua pesanan Anda</p>
        </div>

        <!-- Orders List -->
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200">
                        <!-- Order Header -->
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Order #{{ $order->order_number }}
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="mt-3 sm:mt-0">
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
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                    <div class="flex items-center space-x-4">
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
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $item->product_name }}
                                            </h4>
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

                        <!-- Order Footer -->
                        <div class="px-6 py-4 bg-gray-50 rounded-b-lg">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                                <div class="text-sm text-gray-600">
                                    <p>Total: <span class="font-medium text-gray-900">Rp {{ number_format($order->final_amount) }}</span></p>
                                    <p class="mt-1">Metode Pembayaran: <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span></p>
                                </div>
                                <div class="mt-3 sm:mt-0 space-x-2">
                                    <a href="{{ route('user.orderDetail', $order->order_number) }}" 
                                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        Detail Pesanan
                                    </a>
                                    @if($order->status === 'pending')
                                        <a href="{{ route('checkout.pending', $order->order_number) }}" 
                                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                            Lanjutkan Pembayaran
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum memiliki riwayat pesanan.</p>
                <div class="mt-6">
                    <a href="{{ route('store') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 