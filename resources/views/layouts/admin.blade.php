<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'Admin Dashboard - DigitalStore')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Additional Styles -->
    @stack('styles')
    
    <style>
        .admin-sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .admin-content {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        
        .sidebar-link {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            padding: 0.75rem 1rem;
            display: block;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        
        .sidebar-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            text-decoration: none;
        }
        
        .sidebar-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        .stat-card {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid #e9ecef;
        }
        
        .stat-icon {
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="admin-sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="text-white mb-0">
                            <i class="fas fa-crown me-2"></i>
                            Admin Panel
                        </h4>
                        <small class="text-white-50">DigitalStore</small>
                    </div>
                    
                    <hr class="border-white-50">
                    
                    <nav class="nav flex-column">
                        <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                        
                        <a class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : '' }}" 
                           href="{{ route('admin.users') }}">
                            <i class="fas fa-users me-2"></i>
                            Pengguna
                        </a>
                        
                        <a class="sidebar-link {{ request()->routeIs('admin.products') ? 'active' : '' }}" 
                           href="{{ route('admin.products') }}">
                            <i class="fas fa-box me-2"></i>
                            Produk
                        </a>
                        
                        <a class="sidebar-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}" 
                           href="{{ route('admin.orders') }}">
                            <i class="fas fa-shopping-cart me-2"></i>
                            Pesanan
                        </a>
                        
                        <a class="sidebar-link {{ request()->routeIs('admin.categories') ? 'active' : '' }}" 
                           href="{{ route('admin.categories') }}">
                            <i class="fas fa-tags me-2"></i>
                            Kategori
                        </a>
                        
                        <a class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}" 
                           href="{{ route('admin.reports') }}">
                            <i class="fas fa-chart-bar me-2"></i>
                            Laporan
                        </a>
                    </nav>
                    
                    <hr class="border-white-50 mt-4">
                    
                    <div class="text-center">
                        <small class="text-white-50">Logged in as</small>
                        <div class="text-white">{{ Auth::user()->name }}</div>
                        <a href="{{ route('home') }}" class="btn btn-outline-light btn-sm mt-2">
                            <i class="fas fa-home me-1"></i>
                            Back to Site
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="admin-content p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-0">@yield('page-title', 'Dashboard')</h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin</a></li>
                                    @yield('breadcrumb')
                                </ol>
                            </nav>
                        </div>
                        
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i>
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('home') }}">
                                    <i class="fas fa-home me-2"></i> Back to Site
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Alert Container -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Main Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 