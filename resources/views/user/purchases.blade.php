@extends('layouts.app')

@section('title', 'Produk yang Dibeli - Tokopedia')

@section('head')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">
    <div class="max-w-6xl mx-auto">
        <div class="mb-4">
            <h1 class="h4 fw-bold text-dark mb-2">Produk yang Dibeli</h1>
            <p class="text-muted">Akses semua produk yang telah Anda beli</p>
        </div>
        @if($purchasedProducts->count() > 0)
        <div class="table-responsive bg-white rounded shadow border mb-5">
            <table id="purchases-table" class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Deskripsi</th>
                        <th>Order</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchasedProducts as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded" style="width:40px;height:40px;object-fit:cover;" />
                                @else
                                    <div class="rounded bg-secondary d-flex align-items-center justify-content-center" style="width:40px;height:40px;">
                                        <svg class="text-white" width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <span>{{ $item->product->name }}</span>
                            </div>
                        </td>
                        <td class="text-truncate" style="max-width:200px;">{{ $item->product->description }}</td>
                        <td class="text-muted">#{{ $item->order->order_number }}</td>
                        <td class="text-muted">{{ $item->order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <span class="badge 
                                @if($item->order->status=='paid') bg-success
                                @elseif($item->order->status=='completed') bg-primary
                                @else bg-secondary @endif">
                                @switch($item->order->status)
                                    @case('paid') Sudah Dibayar @break
                                    @case('completed') Selesai @break
                                    @default {{ ucfirst($item->order->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('product.show', $item->product->slug) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                            <a href="{{ route('product.download', $item->product->id) }}" class="btn btn-success btn-sm ms-1">Download</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="mb-2 h6 text-dark">Belum ada produk yang dibeli</h3>
            <p class="text-muted">Anda belum membeli produk apapun.</p>
            <a href="{{ route('store') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#purchases-table').DataTable({
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ entri',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                    zeroRecords: 'Tidak ada data ditemukan',
                },
                order: [[3, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 5 }
                ]
            });
        });
    </script>
@endsection 