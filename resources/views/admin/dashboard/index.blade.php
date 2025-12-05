@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a href="{{ route('home') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-external-link-alt fa-sm text-white-50"></i> Lihat Website
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- TEFA Jurusan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                TEFA Jurusan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_tefas'] ?? 0 }}</div>
                            <div class="text-xs text-muted mt-1">7 jurusan TEFA tersedia</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-school fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.tefas.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produk Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Produk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] ?? 0 }}</div>
                            <div class="text-xs text-muted mt-1">Produk dari 7 TEFA</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Sewa Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Layanan Sewa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_services'] ?? 0 }}</div>
                            <div class="text-xs text-muted mt-1">3 layanan penyewaan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-outline-info">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesan Masuk Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pesan Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_contacts'] ?? 0 }}</div>
                            <div class="text-xs text-muted mt-1">Pesan dari pengunjung</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <!-- Quick Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Menu Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('admin.tefas.index') }}" class="btn btn-primary m-1">
                            <i class="fas fa-school me-1"></i> TEFA
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-success m-1">
                            <i class="fas fa-box-open me-1"></i> Produk
                        </a>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-info m-1">
                            <i class="fas fa-handshake me-1"></i> Layanan
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" class="btn btn-warning m-1">
                            <i class="fas fa-envelope me-1"></i> Pesan
                        </a>
                        <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary m-1">
                            <i class="fas fa-user me-1"></i> Profil
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-dark m-1">
                            <i class="fas fa-cog me-1"></i> Pengaturan
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <!-- System Info Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Aplikasi:</strong> BLUD SMKN 1 CIAMIS</p>
                            <p><strong>Versi:</strong> 1.0.0</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Framework:</strong> Laravel {{ app()->version() }}</p>
                            <p><strong>PHP:</strong> {{ phpversion() }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> <span class="badge bg-success">Aktif</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Waktu:</strong> {{ now()->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection