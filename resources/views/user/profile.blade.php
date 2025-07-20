@extends('layouts.app')

@section('title', 'Profil Saya - Tokopedia')

@section('content')
<div class="container py-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-2">Profil Saya</h1>
            <p class="text-muted">Kelola informasi profil dan keamanan akun Anda</p>
        </div>
        <div class="row g-4">
            <!-- Profile Information -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="h5 fw-semibold mb-4">Informasi Profil</h2>
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <form action="{{ route('user.updateProfile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" readonly disabled>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $user->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Update Profil</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Change Password -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="h5 fw-semibold mb-4">Ubah Password</h2>
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('user.changePassword') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Account Information -->
        <div class="mt-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h5 fw-semibold mb-4">Informasi Akun</h2>
                    <div class="row g-4">
                        <div class="col-md-3">
                            <h6 class="text-secondary mb-1">Member Sejak</h6>
                            <p class="mb-0">{{ $user->created_at->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-secondary mb-1">Status Akun</h6>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-secondary mb-1">Total Pesanan</h6>
                            <p class="mb-0">{{ $user->orders()->count() }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="text-secondary mb-1">Total Pembelian</h6>
                            <p class="mb-0">Rp {{ number_format($user->orders()->whereIn('status', ['paid', 'completed'])->sum('final_amount')) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 