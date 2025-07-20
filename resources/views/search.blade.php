@extends('layouts.app')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="container py-5">
    <h2>Hasil Pencarian</h2>
    {{-- Tampilkan hasil pencarian di sini --}}
    @if(isset($products) && count($products))
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Tidak ada produk ditemukan.</p>
    @endif
</div>
@endsection 