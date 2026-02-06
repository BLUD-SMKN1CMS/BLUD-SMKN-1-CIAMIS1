<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo $__env->yieldContent('title', 'Dashboard'); ?> - Admin BLUD SMKN 1 Ciamis</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom Admin CSS -->
    <style>
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #87CEEB;
            --dark-color: #2c3e50;
            --light-color: #f8f9fa;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            min-height: 100vh;
            display: flex;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            height: 100vh;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: white;
        }

        .sidebar-brand img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .sidebar-brand-text h4 {
            font-size: 1.2rem;
            margin-bottom: 0;
            font-weight: 600;
        }

        .sidebar-brand-text small {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 12px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: white;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-left-color: white;
            font-weight: 500;
        }

        .nav-link i {
            width: 24px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .badge-counter {
            background: #e74c3c;
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.75rem;
            margin-left: auto;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 20px;
        }

        .sidebar-heading {
            font-size: 0.85rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            padding: 0 20px 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* ===== MAIN CONTENT ===== */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 30px;
            position: sticky;
            top: 0;
            z-index: 999;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h1 {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 5px;
        }

        .topbar-left p {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-dropdown {
            position: relative;
        }

        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--dark-color);
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .user-info {
            line-height: 1.2;
        }

        .user-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .user-role {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px 0;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 8px 20px;
            color: #495057;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            color: var(--primary-color);
        }

        .dropdown-divider {
            margin: 8px 0;
        }

        /* ===== CONTENT AREA ===== */
        .content-area {
            flex: 1;
            padding: 30px;
            background: #f5f7fb;
        }

        /* ===== CARDS ===== */
        .admin-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: none;
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid #eaeaea;
            padding: 20px 25px;
            border-radius: 12px 12px 0 0 !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h5 {
            color: var(--dark-color);
            font-weight: 600;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 25px;
        }

        /* ===== STATS CARDS ===== */
        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--primary-color);
            height: 100%;
        }

        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .stats-icon-primary {
            background: rgba(74, 144, 226, 0.1);
            color: var(--primary-color);
        }

        .stats-icon-success {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .stats-icon-info {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }

        .stats-icon-warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            line-height: 1;
            margin-bottom: 5px;
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .stats-desc {
            font-size: 0.85rem;
            color: #adb5bd;
            margin-bottom: 15px;
        }

        /* ===== BUTTONS ===== */
        .btn-admin {
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 500;
            border: none;
            transition: all 0.3s;
        }

        .btn-admin-primary {
            background: var(--primary-color);
            color: white;
        }

        .btn-admin-primary:hover {
            background: #357ae8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(74, 144, 226, 0.3);
        }

        .btn-admin-outline {
            background: transparent;
            border: 1px solid #dee2e6;
            color: #6c757d;
        }

        .btn-admin-outline:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            background: rgba(74, 144, 226, 0.05);
        }

        /* ===== TABLES ===== */
        .table-admin {
            width: 100%;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table-admin th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            color: var(--dark-color);
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .table-admin td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f1f1;
        }

        .table-admin tr:hover {
            background: #f8f9fa;
        }

        /* ===== FORMS ===== */
        .form-control-admin {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 10px 15px;
            transition: all 0.3s;
        }

        .form-control-admin:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.25);
        }

        /* ===== ALERTS ===== */
        .alert-admin {
            border-radius: 8px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
        }

        .alert-warning {
            background: #fff3cd;
            color: #664d03;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* ===== BADGES ===== */
        .badge-admin {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .badge-success {
            background: #d1e7dd;
            color: #0f5132;
        }

        .badge-primary {
            background: rgba(74, 144, 226, 0.1);
            color: var(--primary-color);
        }

        .badge-secondary {
            background: #e9ecef;
            color: #6c757d;
        }

        /* ===== FOOTER ===== */
        .admin-footer {
            background: white;
            padding: 20px 30px;
            border-top: 1px solid #eaeaea;
            text-align: center;
            color: #6c757d;
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

    <?php echo $__env->yieldPushContent('styles'); ?>
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
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-brand">
                <img src="<?php echo e(asset('assets/iconsmea.png')); ?>" alt="Logo">
                <div class="sidebar-brand-text">
                    <h4>BLUD SMKN 1</h4>
                    <small>Admin Panel</small>
                </div>
            </a>
        </div>

        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <!-- Dashboard -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Kelola Konten</div>

            <!-- Content Management -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.tefas.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/tefas*') ? 'active' : ''); ?>">
                        <i class="fas fa-university"></i>
                        <span>Jurusan TEFA</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.products.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/products*') ? 'active' : ''); ?>">
                        <i class="fas fa-box-open"></i>
                        <span>Produk</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.services.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/services*') ? 'active' : ''); ?>">
                        <i class="fas fa-handshake"></i>
                        <span>Layanan Sewa</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.carousels.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/carousels*') ? 'active' : ''); ?>">
                        <i class="fas fa-images"></i>
                        <span>Carousel</span>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Komunikasi</div>

            <!-- Communication -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.contacts.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/contacts*') ? 'active' : ''); ?>">
                        <i class="fas fa-envelope"></i>
                        <span>Pesan Masuk</span>
                        <?php
                            $unreadCount = \App\Models\Contact::where('status', 'new')->count();
                        ?>
                        <?php if($unreadCount > 0): ?>
                            <span class="badge-counter"><?php echo e($unreadCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
            <div class="sidebar-heading">Pengaturan</div>

            <!-- Settings -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.settings.index')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/settings*') ? 'active' : ''); ?>">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan Website</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('admin.profile.edit')); ?>"
                        class="nav-link <?php echo e(request()->is('admin/profile*') ? 'active' : ''); ?>">
                        <i class="fas fa-user"></i>
                        <span>Profil Admin</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="<?php echo e(route('home')); ?>" target="_blank" class="nav-link">
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
                <h1><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h1>
                <p><?php echo $__env->yieldContent('page-subtitle', 'Panel Admin BLUD SMKN 1 Ciamis'); ?></p>
            </div>

            <div class="topbar-right">
                <!-- User Dropdown -->
                <div class="user-dropdown">
                    <a href="#" class="user-dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-avatar">
                            <?php echo e(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)); ?>

                        </div>
                        <div class="user-info">
                            <div class="user-name"><?php echo e(Auth::guard('admin')->user()->name ?? 'Administrator'); ?></div>
                            <div class="user-role">Super Admin</div>
                        </div>
                        <i class="fas fa-chevron-down ms-2"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile.edit')); ?>">
                            <i class="fas fa-user me-2"></i> Profil
                        </a>
                        <a class="dropdown-item" href="<?php echo e(route('admin.profile.change-password')); ?>">
                            <i class="fas fa-key me-2"></i> Ubah Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>" id="logoutForm">
                            <?php echo csrf_field(); ?>
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
            <?php if(session('success')): ?>
                <div class="alert-admin alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert-admin alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('warning')): ?>
                <div class="alert-admin alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('warning')); ?>

                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert-admin alert-info">
                    <i class="fas fa-info-circle"></i>
                    <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <!-- Footer -->
        <footer class="admin-footer">
            <p class="mb-0">
                &copy; <?php echo e(date('Y')); ?> BLUD SMKN 1 Ciamis |
                <strong>Versi:</strong> 1.0.0 |
                <strong>Waktu Server:</strong> <?php echo e(now()->format('d F Y H:i:s')); ?>

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

            // Initialize all dropdowns manually
            const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(
                dropdownToggleEl));
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/layouts/app.blade.php ENDPATH**/ ?>