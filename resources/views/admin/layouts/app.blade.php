<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Admin BLUD SMKN 1 Ciamis</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Admin CSS - Filament Style -->
    <style>
        :root {
            --primary-color: #0992C2;
            --primary-hover: #077ba3;
            --dark-color: #0f172a;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', sans-serif;
            background-color: var(--gray-50);
            min-height: 100vh;
            display: flex;
            color: var(--gray-700);
        }

        /* ===== FILAMENT SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: white;
            color: var(--gray-700);
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            border-right: 1px solid var(--gray-200);
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid var(--gray-200);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--gray-900);
        }

        .sidebar-brand img {
            width: 36px;
            height: 36px;
            border-radius: 8px;
        }

        .sidebar-brand-text h4 {
            font-size: 1.15rem;
            margin-bottom: 0;
            font-weight: 700;
            color: var(--gray-900);
        }

        .sidebar-brand-text small {
            font-size: 0.75rem;
            color: var(--gray-500);
            font-weight: 500;
        }

        .sidebar-menu {
            padding: 16px 12px;
        }

        .nav-item {
            margin-bottom: 4px;
        }

        .nav-link {
            color: var(--gray-600);
            padding: 10px 12px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.2s;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .nav-link:hover {
            background: var(--gray-100);
            color: var(--primary-color);
        }

        .nav-link.active {
            background: rgba(9, 146, 194, 0.1);
            color: var(--primary-color);
            font-weight: 600;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1rem;
        }

        .badge-counter {
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            padding: 2px 8px;
            font-size: 0.7rem;
            margin-left: auto;
            font-weight: 600;
        }

        .sidebar-divider {
            border-top: 1px solid var(--gray-200);
            margin: 16px 12px;
        }

        .sidebar-heading {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--gray-400);
            padding: 12px 12px 8px;
            font-weight: 700;
            letter-spacing: 0.8px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== FILAMENT TOPBAR ===== */
        .topbar {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 24px;
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h1 {
            font-size: 1.5rem;
            color: var(--gray-900);
            margin-bottom: 0;
            font-weight: 700;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--gray-700);
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .user-dropdown-toggle:hover {
            background: var(--gray-100);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info {
            line-height: 1.3;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--gray-900);
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        .dropdown-menu {
            border: 1px solid var(--gray-200);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 6px;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 10px 12px;
            color: var(--gray-700);
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 6px;
            font-size: 0.9rem;
        }

        .dropdown-item:hover {
            background: var(--gray-100);
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 6px 0;
            border-color: var(--gray-200);
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            flex: 1;
            padding: 24px;
            background: var(--gray-50);
        }

        /* ===== FILAMENT CARDS ===== */
        .admin-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--gray-200);
            margin-bottom: 24px;
            transition: all 0.2s;
        }

        .admin-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 16px 20px;
            border-radius: 12px 12px 0 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h5 {
            color: var(--gray-900);
            font-weight: 700;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 20px;
        }

        /* ===== FILAMENT STATS CARDS ===== */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid var(--gray-200);
            height: 100%;
            transition: all 0.2s;
        }

        .stats-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 12px;
        }

        .stats-icon-primary {
            background: rgba(9, 146, 194, 0.1);
            color: var(--primary-color);
        }

        .stats-icon-success {
            background: rgba(34, 197, 94, 0.1);
            color: #22c55e;
        }

        .stats-icon-info {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .stats-icon-warning {
            background: rgba(251, 191, 36, 0.1);
            color: #fbbf24;
        }

        .stats-value {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stats-label {
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .stats-desc {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-bottom: 12px;
        }

        /* ===== FILAMENT BUTTONS ===== */
        .btn-admin {
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            transition: all 0.2s;
            font-size: 0.875rem;
        }

        .btn-admin-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-admin-primary:hover {
            background: var(--primary-hover);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(9, 146, 194, 0.3);
        }

        .btn-admin-outline {
            background: transparent;
            border: 1px solid var(--gray-300);
            color: var(--gray-700);
        }

        .btn-admin-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(9, 146, 194, 0.05);
        }

        /* ===== FILAMENT TABLES ===== */
        .table-admin {
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        .table-admin th {
            background: var(--gray-50);
            border: none;
            font-weight: 700;
            color: var(--gray-700);
            padding: 12px 16px;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-admin td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
            font-size: 0.9rem;
        }

        .table-admin tr:hover {
            background: var(--gray-50);
        }

        /* ===== FILAMENT FORMS ===== */
        .form-control-admin {
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            padding: 10px 12px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .form-control-admin:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(9, 146, 194, 0.1);
            outline: none;
        }

        /* ===== FILAMENT ALERTS ===== */
        .alert-admin {
            border-radius: 8px;
            border: 1px solid;
            padding: 12px 16px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #f0fdf4;
            border-color: #86efac;
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-color: #fca5a5;
            color: #991b1b;
        }

        .alert-warning {
            background: #fefce8;
            border-color: #fde047;
            color: #854d0e;
        }

        .alert-info {
            background: #eff6ff;
            border-color: #93c5fd;
            color: #1e40af;
        }

        /* ===== FILAMENT BADGES ===== */
        .badge-admin {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-primary {
            background: rgba(9, 146, 194, 0.1);
            color: var(--primary-color);
        }

        .badge-secondary {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        /* ===== FILAMENT DROPDOWN MENU ===== */
        .nav-dropdown {
            cursor: pointer;
            position: relative;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .nav-dropdown-toggle .dropdown-arrow {
            transition: transform 0.2s;
            font-size: 0.8rem;
        }

        .nav-dropdown.active .dropdown-arrow {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .nav-dropdown.active .nav-dropdown-menu {
            max-height: 500px;
        }

        .nav-dropdown-menu .nav-link {
            padding-left: 48px;
            font-size: 0.875rem;
        }

        /* ===== FILAMENT FOOTER ===== */
        .admin-footer {
            background: white;
            padding: 16px 24px;
            border-top: 1px solid var(--gray-200);
            text-align: center;
            color: var(--gray-500);
            font-size: 0.85rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .topbar-right {
                width: 100%;
                justify-content: flex-end;
            }

            .content-area {
                padding: 20px;
            }

            .mobile-menu-toggle {
                display: block !important;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1001;
                background: var(--primary-color);
                color: white;
                border: none;
                width: 45px;
                height: 45px;
                border-radius: 8px;
                font-size: 1.2rem;
            }
        }

        .mobile-menu-toggle {
            display: none;
        }

        /* ===== PAGE LOADER ===== */
        .page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* ===== TOAST ===== */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        .toast {
            background: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
            min-width: 300px;
        }

        .toast-header {
            background: white;
            border-bottom: 1px solid #eaeaea;
            border-radius: 8px 8px 0 0;
        }

        /* ===== UTILITIES ===== */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .bg-primary {
            background: var(--primary-color) !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .border-radius-8 {
            border-radius: 8px;
        }

        .border-radius-12 {
            border-radius: 12px;
        }

        .shadow-sm {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        }

        .shadow-md {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .shadow-lg {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader-spinner"></div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                <img src="{{ asset('assets/iconsmea.png') }}" alt="Logo">
                <div class="sidebar-brand-text">
                    <h4>BLUD SMKN 1</h4>
                    <small>Admin</small>
                </div>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <!-- Dashboard -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>

            <!-- Content Management Dropdown -->
            <ul class="nav flex-column">
                <li class="nav-item nav-dropdown {{ request()->is('admin/tefas*', 'admin/products*', 'admin/services*', 'admin/carousels*') ? 'active' : '' }}">
                    <a class="nav-link nav-dropdown-toggle">
                        <div style="display: flex; align-items: center;">
                            <i class="fas fa-folder-open"></i>
                            <span>Kelola Konten</span>
                        </div>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </a>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('admin.tefas.index') }}"
                            class="nav-link {{ request()->is('admin/tefas*') ? 'active' : '' }}">
                            <i class="fas fa-university"></i>
                            <span>Jurusan TEFA</span>
                        </a>
                        <a href="{{ route('admin.products.index') }}"
                            class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                            <i class="fas fa-box-open"></i>
                            <span>Produk</span>
                        </a>
                        <a href="{{ route('admin.services.index') }}"
                            class="nav-link {{ request()->is('admin/services*') ? 'active' : '' }}">
                            <i class="fas fa-handshake"></i>
                            <span>Layanan Sewa</span>
                        </a>
                        <a href="{{ route('admin.carousels.index') }}"
                            class="nav-link {{ request()->is('admin/carousels*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            <span>Carousel</span>
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Komunikasi</div>

            <!-- Communication -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.contacts.index') }}"
                        class="nav-link {{ request()->is('admin/contacts*') ? 'active' : '' }}">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan Masuk</span>
                        @php
                        $unreadCount = \App\Models\Contact::where('status', 'new')->count();
                        @endphp
                        @if ($unreadCount > 0)
                        <span class="badge-counter">{{ $unreadCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Pengaturan</div>

            <!-- Settings -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}"
                        class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan Website</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.profile.edit') }}"
                        class="nav-link {{ request()->is('admin/profile*') ? 'active' : '' }}">
                        <i class="fas fa-user"></i>
                        <span>Profil Admin</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('home') }}" target="_blank" class="nav-link">
                        <i class="fas fa-external-link-alt"></i>
                        <span>Lihat Website</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <h1>@yield('page-title', 'Dashboard')</h1>
            </div>

            <div class="topbar-right">
                <!-- User Dropdown -->
                <div class="user-dropdown">
                    <a href="#" class="user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            {{ substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="user-info">
                            <div class="user-name">{{ Auth::guard('admin')->user()->name ?? 'Administrator' }}</div>
                            <div class="user-role">Super Admin</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                        <a class="dropdown-item" href="{{ route('admin.profile.change-password') }}">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
                            @csrf
                            <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <!-- Session Messages -->
            @if (session('success'))
            <div class="alert-admin alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session('error'))
            <div class="alert-admin alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session('warning'))
            <div class="alert-admin alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if (session('info'))
            <div class="alert-admin alert-info">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p class="mb-0">
                &copy; {{ date('Y') }} BLUD SMKN 1 Ciamis |
                <strong>Versi:</strong> 1.0.0 |
                <strong>Waktu Server:</strong> {{ now()->format('d F Y H:i:s') }}
            </p>
        </footer>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Custom Scripts -->
    <script>
        // Wait for page to load
        document.addEventListener('DOMContentLoaded', function() {
            // Hide page loader
            setTimeout(function() {
                document.getElementById('pageLoader').style.display = 'none';
            }, 500);

            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const sidebar = document.getElementById('sidebar');

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert-admin').forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            // Initialize DataTables if table exists
            if ($.fn.DataTable.isDataTable('.table-admin')) {
                $('.table-admin').DataTable().destroy();
            }

            $('.table-admin').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                pageLength: 10,
                responsive: true,
                order: [
                    [0, 'asc']
                ],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                    '<"row"<"col-sm-12"tr>>' +
                    '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
            });

            // Confirm delete with SweetAlert
            window.confirmDelete = function(event, message = 'Apakah Anda yakin ingin menghapus data ini?') {
                event.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        event.target.closest('form').submit();
                    }
                });
            };

            // Image preview
            window.previewImage = function(input, previewId) {
                const preview = document.getElementById(previewId);
                const file = input.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            };

            // Show toast notification
            window.showToast = function(type, message) {
                const toast = $(`
                    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-header">
                            <i class="fas fa-${type === 'success' ? 'check-circle text-success' : 'exclamation-circle text-danger'} me-2"></i>
                            <strong class="me-auto">${type === 'success' ? 'Sukses' : 'Error'}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                        </div>
                        <div class="toast-body">${message}</div>
                    </div>
                `);

                $('#toastContainer').append(toast);
                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();

                // Remove after hide
                toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            };

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickOnMenuToggle = mobileMenuToggle.contains(event.target);

                if (window.innerWidth <= 768 &&
                    !isClickInsideSidebar &&
                    !isClickOnMenuToggle &&
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });

            // Dropdown menu toggle
            document.querySelectorAll('.nav-dropdown-toggle').forEach(function(toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const parent = this.closest('.nav-dropdown');

                    // Close other dropdowns
                    document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
                        if (dropdown !== parent) {
                            dropdown.classList.remove('active');
                        }
                    });

                    // Toggle current dropdown
                    parent.classList.toggle('active');
                });
            });

            // Keep dropdown open if one of its items is active
            document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
                if (dropdown.querySelector('.nav-dropdown-menu .nav-link.active')) {
                    dropdown.classList.add('active');
                }
            });

            // Initialize all dropdowns manually
            const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(
                dropdownToggleEl));
        });
    </script>

    @stack('scripts')
</body>

</html>