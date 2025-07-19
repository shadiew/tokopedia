@extends('layouts.app')

@section('title', 'Lupa Password - Toko Digital Download')
@section('description', 'Reset password akun Anda dengan mudah dan aman.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark text-center">
                    <h4 class="mb-0">
                        <i class="fas fa-key me-2"></i>
                        Lupa Password
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="fas fa-envelope-open-text fa-3x text-muted mb-3"></i>
                        <p class="text-muted">
                            Masukkan alamat email Anda yang terdaftar. Kami akan mengirimkan link untuk reset password.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i> Email
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-paper-plane me-2"></i>
                                Kirim Link Reset
                            </button>
                        </div>
                    </form>

                    <hr class="my-4">

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali ke halaman login
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <span class="text-muted">Belum punya akun?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none ms-1">
                            Daftar sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 