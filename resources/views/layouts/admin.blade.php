<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Kadaju67') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar d-none d-md-block" style="width: 250px; flex-shrink: 0;">
            <div class="p-3 text-center border-bottom border-secondary">
                <h4 class="text-kadaju-gold mb-0">Kadaju67</h4>
                <small class="text-muted">Market Management</small>
            </div>
            <nav class="mt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a href="{{ route('vendors.index') }}" class="nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Vendors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('stalls.index') }}" class="nav-link {{ request()->routeIs('stalls.*') ? 'active' : '' }}">
                            <i class="bi bi-shop"></i> Stalls
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <small class="text-muted px-3">REPORTS</small>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <small class="text-muted px-3">SYSTEM</small>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                            <i class="bi bi-activity"></i> Activity Logs
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1" style="min-height: 100vh;">
            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-md navbar-dark bg-kadaju-black shadow-sm">
                <div class="container-fluid">
                    <button class="btn btn-link text-kadaju-gold d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <span class="navbar-brand d-md-none">Kadaju67</span>
                    <div class="ms-auto d-flex align-items-center">
                        <span class="text-white-50 me-3 d-none d-md-inline">
                            <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->name }}
                            <span class="badge bg-kadaju-gold text-black ms-1">{{ ucfirst(Auth::user()->role) }}</span>
                        </span>
                        <div class="dropdown">
                            <button class="btn btn-link text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear-fill"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="p-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Mobile Sidebar Offcanvas -->
    <div class="offcanvas offcanvas-start bg-kadaju-black" tabindex="-1" id="sidebarMobile">
        <div class="offcanvas-header border-bottom border-secondary">
            <h5 class="text-kadaju-gold mb-0">Kadaju67</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="mt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-1x2-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.index') }}" class="nav-link {{ request()->routeIs('vendors.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i> Vendors
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('stalls.index') }}" class="nav-link {{ request()->routeIs('stalls.*') ? 'active' : '' }}">
                            <i class="bi bi-shop"></i> Stalls
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                            <i class="bi bi-cash-stack"></i> Payments
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <small class="text-muted px-3">REPORTS</small>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-bar-graph-fill"></i> Reports
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <small class="text-muted px-3">SYSTEM</small>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                            <i class="bi bi-activity"></i> Activity Logs
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
