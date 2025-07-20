@extends('layouts.admin')

@section('title', 'Kelola Pengguna - Admin Dashboard')
@section('page-title', 'Kelola Pengguna')

@section('head')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endsection

@section('breadcrumb')
<li class="breadcrumb-item active">Pengguna</li>
@endsection

@section('content')
<div class="table-responsive rounded shadow-sm">
    <table id="users-table" class="table table-striped table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
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
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role == 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role == 'member')
                        <span class="badge bg-warning text-dark">Member</span>
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
                <td><span class="badge bg-info text-dark">{{ $user->orders_count }} pesanan</span></td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($user->id !== auth()->id())
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada pengguna</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function() {
    $('#users-table').DataTable({
        language: {
            search: 'Cari:',
            lengthMenu: 'Tampilkan _MENU_ entri',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
            paginate: { previous: 'Sebelumnya', next: 'Berikutnya' },
            zeroRecords: 'Tidak ada data ditemukan',
        },
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: 7 }
        ]
    });
});
</script>
@endpush 