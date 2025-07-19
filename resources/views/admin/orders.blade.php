@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin Dashboard')
@section('page-title', 'Kelola Pesanan')

@section('breadcrumb')
<li class="breadcrumb-item active">Pesanan</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-shopping-cart me-2"></i>
            Daftar Pesanan
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" onclick="exportOrders()">
                <i class="fas fa-download me-1"></i> Export
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td>
                            <strong>{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div>
                                <strong>{{ $order->user->name }}</strong>
                                <br><small class="text-muted">{{ $order->user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $order->items->count() }} items</span>
                            <br><small class="text-muted">
                                @foreach($order->items->take(2) as $item)
                                    {{ $item->product->name }}{{ !$loop->last ? ', ' : '' }}
                                @endforeach
                                @if($order->items->count() > 2)
                                    +{{ $order->items->count() - 2 }} more
                                @endif
                            </small>
                        </td>
                        <td>
                            <strong>Rp {{ number_format($order->final_amount) }}</strong>
                        </td>
                        <td>
                            @if($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($order->status == 'paid')
                                <span class="badge bg-info">Paid</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($order->payment)
                                <span class="badge bg-{{ $order->payment->status == 'success' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                                <br><small class="text-muted">{{ ucfirst($order->payment->payment_method) }}</small>
                            @else
                                <span class="badge bg-secondary">No Payment</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#orderModal{{ $order->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'pending')">
                                            Set Pending
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'paid')">
                                            Set Paid
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'completed')">
                                            Set Completed
                                        </a></li>
                                        <li><a class="dropdown-item" href="#" onclick="updateStatus({{ $order->id }}, 'cancelled')">
                                            Set Cancelled
                                        </a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Order Detail Modal -->
                    <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pesanan #{{ $order->order_number }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Informasi Pesanan</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Order Number:</strong></td>
                                                    <td>{{ $order->order_number }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @if($order->status == 'completed')
                                                            <span class="badge bg-success">Completed</span>
                                                        @elseif($order->status == 'pending')
                                                            <span class="badge bg-warning">Pending</span>
                                                        @elseif($order->status == 'paid')
                                                            <span class="badge bg-info">Paid</span>
                                                        @elseif($order->status == 'cancelled')
                                                            <span class="badge bg-danger">Cancelled</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Total Amount:</strong></td>
                                                    <td>Rp {{ number_format($order->total_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Final Amount:</strong></td>
                                                    <td>Rp {{ number_format($order->final_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Tax Amount:</strong></td>
                                                    <td>Rp {{ number_format($order->tax_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Discount Amount:</strong></td>
                                                    <td>Rp {{ number_format($order->discount_amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Payment Method:</strong></td>
                                                    <td>{{ $order->payment_method ?? 'Not specified' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Order Date:</strong></td>
                                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Informasi Customer</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Name:</strong></td>
                                                    <td>{{ $order->user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email:</strong></td>
                                                    <td>{{ $order->user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Phone:</strong></td>
                                                    <td>{{ $order->user->phone ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Billing Name:</strong></td>
                                                    <td>{{ $order->billing_name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Billing Email:</strong></td>
                                                    <td>{{ $order->billing_email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Billing Phone:</strong></td>
                                                    <td>{{ $order->billing_phone ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Billing Address:</strong></td>
                                                    <td>{{ $order->billing_address ?? '-' }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <h6>Order Items</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                    <th>Downloaded</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($order->items as $item)
                                                <tr>
                                                    <td>{{ $item->product->name }}</td>
                                                    <td>Rp {{ number_format($item->price) }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>Rp {{ number_format($item->subtotal) }}</td>
                                                    <td>
                                                        @if($item->is_downloaded)
                                                            <span class="badge bg-success">Yes</span>
                                                            <br><small class="text-muted">{{ $item->downloaded_at->format('d/m/Y H:i') }}</small>
                                                        @else
                                                            <span class="badge bg-secondary">No</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($order->notes)
                                    <hr>
                                    <h6>Notes</h6>
                                    <p class="text-muted">{{ $order->notes }}</p>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada pesanan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $orders->total() }}</h3>
                <p class="mb-0">Total Pesanan</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $orders->where('status', 'pending')->count() }}</h3>
                <p class="mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $orders->where('status', 'completed')->count() }}</h3>
                <p class="mb-0">Completed</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">Rp {{ number_format($orders->where('status', 'completed')->sum('final_amount')) }}</h3>
                <p class="mb-0">Total Revenue</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportOrders() {
    alert('Fitur export akan segera tersedia');
}

function updateStatus(orderId, status) {
    if (confirm(`Yakin ingin mengubah status pesanan menjadi ${status}?`)) {
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan');
        });
    }
}
</script>
@endpush 