@extends('layouts.app')

@section('title', 'Invoice Pesanan #' . $order->order_number . ' - Tokopedia')

@section('content')
<div class="container mx-auto px-2 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg border border-gray-200 p-8 print:p-0 print:shadow-none print:border-0">
        <!-- Header: Logo & Invoice Title -->
        <div class="flex items-center justify-between border-b pb-4 mb-6">
            <div class="flex items-center gap-2">
                <span class="font-bold text-lg text-green-700">DigitalStore</span>
                <span class="text-xs text-gray-400">| Tokopedia</span>
            </div>
            <div class="text-right">
                <h1 class="text-2xl font-bold tracking-widest text-gray-900">INVOICE</h1>
                <div class="text-xs text-gray-500 mt-1">#{{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Info Order & Pembeli -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
            <div>
                <div class="text-xs text-gray-500 mb-1">Tanggal Order</div>
                <div class="text-sm text-gray-900 mb-2">{{ $order->created_at->format('d M Y, H:i') }}</div>
                <div class="text-xs text-gray-500 mb-1">Status Pesanan</div>
                <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-2
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($order->status === 'paid') bg-green-100 text-green-800
                    @elseif($order->status === 'completed') bg-blue-100 text-blue-800
                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800 @endif">
                    @switch($order->status)
                        @case('pending') Menunggu Pembayaran @break
                        @case('paid') Sudah Dibayar @break
                        @case('completed') Selesai @break
                        @case('cancelled') Dibatalkan @break
                        @default {{ ucfirst($order->status) }}
                    @endswitch
                </span>
                <div class="text-xs text-gray-500 mb-1">Metode</div>
                <div class="text-sm text-gray-900 mb-1">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</div>
                @if($order->payment)
                    <div class="text-xs text-gray-500 mb-1">Status Pembayaran</div>
                    <div class="text-sm font-semibold @if($order->payment->status === 'paid') text-green-600 @elseif($order->payment->status === 'pending') text-yellow-600 @else text-gray-600 @endif">{{ ucfirst($order->payment->status) }}</div>
                @endif
            </div>
            <div class="sm:text-right">
                <div class="text-xs text-gray-500 mb-1">Tagihan Kepada</div>
                <div class="text-sm text-gray-900 font-semibold">{{ $order->billing_name }}</div>
                <div class="text-xs text-gray-600">{{ $order->billing_email }}</div>
                @if($order->billing_phone)
                    <div class="text-xs text-gray-600">{{ $order->billing_phone }}</div>
                @endif
                @if($order->billing_address)
                    <div class="text-xs text-gray-600">{{ $order->billing_address }}</div>
                @endif
            </div>
        </div>

        <!-- Tabel Item Pesanan -->
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full text-xs sm:text-sm border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700 border-b">Produk</th>
                        <th class="px-3 py-2 text-center font-semibold text-gray-700 border-b">Qty</th>
                        <th class="px-3 py-2 text-right font-semibold text-gray-700 border-b">Harga</th>
                        <th class="px-3 py-2 text-right font-semibold text-gray-700 border-b">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                        <tr class="border-b last:border-b-0">
                            <td class="px-3 py-2">
                                <div class="flex items-center gap-2">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-8 h-8 object-cover rounded">
                                    @else
                                        <div class="w-8 h-8 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $item->product_name }}</div>
                                        @if(in_array($order->status, ['paid', 'completed']))
                                            <a href="{{ route('product.download', $item->product->id) }}" class="text-xs text-blue-600 hover:text-blue-800">Download</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-2 text-center">{{ $item->quantity }}</td>
                            <td class="px-3 py-2 text-right">Rp {{ number_format($item->price) }}</td>
                            <td class="px-3 py-2 text-right">Rp {{ number_format($item->subtotal) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Ringkasan Total di kanan bawah -->
        <div class="flex flex-col items-end mb-6">
            <div class="w-full sm:w-2/3 md:w-1/2">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Subtotal</span>
                    <span>Rp {{ number_format($order->total_amount) }}</span>
                </div>
                @if($order->tax_amount > 0)
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Pajak</span>
                        <span>Rp {{ number_format($order->tax_amount) }}</span>
                    </div>
                @endif
                @if($order->discount_amount > 0)
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">Diskon</span>
                        <span class="text-green-600">-Rp {{ number_format($order->discount_amount) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-base font-bold border-t pt-2 mt-2">
                    <span>Total</span>
                    <span>Rp {{ number_format($order->final_amount) }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons rata kanan -->
        <div class="flex flex-row justify-end gap-2 print:hidden">
            @if($order->status === 'pending')
                <a href="{{ route('checkout.pending', $order->order_number) }}" class="inline-flex justify-center items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-blue-600 hover:bg-blue-700">Lanjutkan Pembayaran</a>
            @endif
            <a href="{{ route('user.orders') }}" class="inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">Kembali</a>
            <button onclick="window.print()" class="inline-flex justify-center items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-xs font-medium text-gray-700 bg-white hover:bg-gray-50">Cetak</button>
        </div>
    </div>
</div>
@endsection 