@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <a href="{{ route('home') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-external-link-alt fa-sm text-white-50"></i> Lihat Website
        </a>
    </div>

    <!-- Content Row -->
    <div class="row @if(!Auth::guard('admin')->user()->isSuperAdmin()) justify-content-center @endif">
        <!-- TEFA Jurusan Card - Super Admin only -->
        @if(Auth::guard('admin')->user()->isSuperAdmin())
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
        @endif

        <!-- Total Produk Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Layanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] ?? 0 }}</div>
                            <div class="text-xs text-muted mt-1">Layanan dari 7 TEFA</div>
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

    <!-- Row Bawah: Pesan Terbaru -->
    <div class="row mt-2">
        <!-- Pesan Masuk Terbaru -->
        <div class="col-lg-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-envelope me-2"></i>Pesan Masuk Terbaru
                    </h6>
                    <a href="{{ route('admin.contacts.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if($recentContacts->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-inbox fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada pesan masuk</p>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($recentContacts as $contact)
                        <div class="list-group-item list-group-item-action px-3 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">{{ $contact->name }}</div>
                                    <small class="text-muted">{{ Str::limit($contact->message, 60) }}</small>
                                </div>
                                <small class="text-muted text-nowrap ms-2">{{ $contact->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection