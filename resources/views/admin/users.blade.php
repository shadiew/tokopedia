@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Dashboard')
@section('page-title', 'Kelola Pengguna')

@section('breadcrumb')
<li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <i class="fas fa-users me-2"></i>
            Daftar Pengguna
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-sm btn-outline-secondary" onclick="exportUsers()">
                <i class="fas fa-download me-1"></i> Export
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Pesanan</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-2" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->phone)
                                        <br><small class="text-muted">{{ $user->phone }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'member')
                                <span class="badge bg-warning">Member</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $user->orders_count }} pesanan</span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" data-bs-target="#userModal{{ $user->id }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" 
                                      class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    
                    <!-- User Detail Modal -->
                    <div class="modal fade" id="userModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pengguna</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Informasi Pribadi</h6>
                                            <table class="table table-sm">
                                                <tr>
                                                    <td><strong>Nama:</strong></td>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Email:</strong></td>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Telepon:</strong></td>
                                                    <td>{{ $user->phone ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Role:</strong></td>
                                                    <td>
                                                        @if($user->role == 'admin')
                                                            <span class="badge bg-danger">Admin</span>
                                                        @elseif($user->role == 'member')
                                                            <span class="badge bg-warning">Member</span>
                                                        @else
                                                            <span class="badge bg-secondary">User</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Status:</strong></td>
                                                    <td>
                                                        @if($user->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bergabung:</strong></td>
                                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Alamat</h6>
                                            <p class="text-muted">{{ $user->address ?? 'Tidak ada alamat' }}</p>
                                            
                                            <h6>Statistik</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="text-center p-3 bg-light rounded">
                                                        <h4 class="mb-0">{{ $user->orders_count }}</h4>
                                                        <small class="text-muted">Total Pesanan</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="text-center p-3 bg-light rounded">
                                                        <h4 class="mb-0">{{ $user->orders()->where('status', 'completed')->count() }}</h4>
                                                        <small class="text-muted">Pesanan Selesai</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada pengguna</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $users->total() }}</h3>
                <p class="mb-0">Total Pengguna</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $users->where('role', 'user')->count() }}</h3>
                <p class="mb-0">User</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $users->where('role', 'member')->count() }}</h3>
                <p class="mb-0">Member</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body text-center">
                <h3 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h3>
                <p class="mb-0">Admin</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportUsers() {
    // Implementation for exporting users data
    alert('Fitur export akan segera tersedia');
}
</script>
@endpush 