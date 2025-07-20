@extends('layouts.app')

@section('title', 'Riwayat Pesanan - Tokopedia')

@section('head')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="container py-4">
    <div class="max-w-5xl mx-auto">
        <div class="mb-4 mt-5">
            <h1 class="h4 fw-bold text-dark mb-2">Riwayat Pesanan</h1>
            <p class="text-muted">Daftar semua pesanan Anda</p>
        </div>
        @if($orders->count() > 0)
        <div class="table-responsive bg-white rounded shadow border mb-5">
            <table id="orders-table" class="table table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nomor Order</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <span class="badge 
                                @if($order->status=='pending') bg-warning text-dark
                                @elseif($order->status=='paid') bg-success
                                @elseif($order->status=='completed') bg-primary
                                @elseif($order->status=='cancelled') bg-danger
                                @else bg-secondary @endif">
                                @switch($order->status)
                                    @case('pending') Belum Dibayar @break
                                    @case('paid') Sudah Dibayar @break
                                    @case('completed') Selesai @break
                                    @case('cancelled') Dibatalkan @break
                                    @default {{ ucfirst($order->status) }}
                                @endswitch
                            </span>
                        </td>
                        <td class="text-end">Rp {{ number_format($order->final_amount) }}</td>
                        <td class="text-center">
                            <a href="{{ route('user.orderDetail', $order->order_number) }}" class="btn btn-outline-secondary btn-sm">Detail</a>
                            @if($order->status=='pending' && $order->checkout_url)
                            <a href="{{ $order->checkout_url }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm ms-1">Bayar Sekarang</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <svg class="mx-auto mb-3" width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="mb-2 h6 text-dark">Belum ada pesanan</h3>
            <p class="text-muted">Anda belum memiliki riwayat pesanan.</p>
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
            $('#orders-table').DataTable({
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampilkan _MENU_ entri',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
                    zeroRecords: 'Tidak ada data ditemukan',
                },
                order: [[1, 'desc']],
                columnDefs: [
                    { orderable: false, targets: 4 }
                ]
            });
        });
    </script>
@endsection 