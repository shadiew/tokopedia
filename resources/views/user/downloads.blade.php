@extends('layouts.app')

@section('title', 'Riwayat Download - Tokopedia')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Riwayat Download</h1>
            <p class="text-gray-600">Lihat semua file yang telah Anda download</p>
        </div>

        <!-- Downloads List -->
        @if($downloads->count() > 0)
            <div class="space-y-6">
                @foreach($downloads as $item)
                    <div class="bg-white rounded-lg shadow-md border border-gray-200">
                        <div class="p-6">
                            <div class="flex items-start space-x-4">
                                <!-- Product Image -->
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

                                <!-- Product Info -->
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">
                                        {{ $item->product->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-2">
                                        {{ $item->product->description }}
                                    </p>
                                    
                                    <!-- Download Info -->
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-500">
                                        <div>
                                            <span class="font-medium">Order:</span> #{{ $item->order->order_number }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Dibeli:</span> {{ $item->order->created_at->format('d M Y, H:i') }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Download:</span> {{ $item->downloaded_at ? $item->downloaded_at->format('d M Y, H:i') : 'N/A' }}
                                        </div>
                                        <div>
                                            <span class="font-medium">Status:</span> 
                                            <span class="
                                                @if($item->order->status === 'paid') text-green-600
                                                @elseif($item->order->status === 'completed') text-blue-600
                                                @else text-gray-600 @endif">
                                                {{ ucfirst($item->order->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex-shrink-0 flex flex-col gap-2">
                                    <a href="{{ route('product.show', $item->product->slug) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                        Detail Produk
                                    </a>
                                    <a href="{{ route('product.download', $item->product->id) }}" 
                                       class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Ulang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $downloads->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada download</h3>
                <p class="mt-1 text-sm text-gray-500">Anda belum mendownload file apapun.</p>
                <div class="mt-6">
                    <a href="{{ route('user.purchases') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Lihat Produk yang Dibeli
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection 