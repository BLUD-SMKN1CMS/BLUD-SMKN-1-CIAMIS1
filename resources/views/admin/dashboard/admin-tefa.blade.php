@extends('admin.layouts.app')

@section('title', 'Dashboard ' . Auth::guard('admin')->user()->name)

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                Dashboard
                @if($myTefa)
                <span class="badge bg-primary ms-2" style="font-size: 0.7em;">{{ $myTefa->name }}</span>
                @endif
            </h1>
            <small class="text-muted">Selamat datang, <strong>{{ Auth::guard('admin')->user()->name }}</strong> — Admin {{ $myTefa->name ?? '' }}</small>
        </div>
        <a href="{{ route('home') }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
            <i class="fas fa-external-link-alt fa-sm text-white-50"></i> Lihat Website
        </a>
    </div>

    {{-- Info TEFA --}}
    @if($myTefa)
    <div class="alert border-left-primary bg-white shadow-sm mb-4 d-flex align-items-center">
        <div class="me-3">
            <i class="{{ $myTefa->icon ?? 'fas fa-school' }} fa-2x text-primary"></i>
        </div>
        <div>
            <strong>{{ $myTefa->name }}</strong>
            <p class="mb-0 text-muted small">{{ $myTefa->description ?? 'Jurusan TEFA Anda' }}</p>
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row justify-content-center">

        <!-- Total Layanan -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Layanan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_products'] }}</div>
                            <div class="text-xs text-muted mt-1">Layanan aktif di jurusan Anda</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Sewa -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Layanan Sewa</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_services'] }}</div>
                            <div class="text-xs text-muted mt-1">Layanan sewa di jurusan Anda</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route($routePrefix . '.services.index') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pesan Masuk -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pesan Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_contacts'] }}</div>
                            <div class="text-xs text-muted mt-1">Pesan belum dibaca</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route($routePrefix . '.contacts.index') }}" class="btn btn-sm btn-outline-success">
                            <i class="fas fa-cog me-1"></i> Kelola
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row Bawah -->
    <div class="row">

        <!-- Layanan Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-box-open me-2"></i>Layanan Terbaru
                    </h6>
                    <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if($recentProducts->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada layanan</p>
                        <a href="{{ route($routePrefix . '.products.create') }}" class="btn btn-sm btn-success mt-2">
                            <i class="fas fa-plus me-1"></i> Tambah Layanan
                        </a>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($recentProducts as $product)
                        <div class="list-group-item px-3 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                    <small class="text-muted">Rp {{ number_format($product->price, 0, ',', '.') }}</small>
                                </div>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ strtoupper($product->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Layanan Sewa Terbaru -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-handshake me-2"></i>Layanan Sewa Terbaru
                    </h6>
                    <a href="{{ route($routePrefix . '.services.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    @if($recentServices->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-handshake fa-2x mb-2"></i>
                        <p class="mb-0">Belum ada layanan sewa</p>
                        <a href="{{ route($routePrefix . '.services.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Tambah Layanan Sewa
                        </a>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($recentServices as $service)
                        <div class="list-group-item px-3 py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }} me-2 text-primary"></i>
                                    <span class="fw-semibold">{{ $service->name }}</span>
                                    <br>
                                    <small class="text-muted">Rp {{ number_format($service->price_per_day, 0, ',', '.') }} / hari</small>
                                </div>
                                <span class="badge {{ $service->status == 'available' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ strtoupper($service->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Pesan Masuk Terbaru -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-envelope me-2"></i>Pesan Masuk Terbaru
                    </h6>
                    <a href="{{ route($routePrefix . '.contacts.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
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
                        <a href="{{ route($routePrefix . '.contacts.show', $contact->id) }}" class="list-group-item list-group-item-action px-3 py-2 {{ $contact->status == 'new' ? 'list-group-item-primary' : '' }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $contact->name }}
                                        @if($contact->status == 'new')
                                        <span class="badge bg-danger ms-1" style="font-size:0.65em;">Baru</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ Str::limit($contact->subject, 60) }}</small>
                                </div>
                                <small class="text-muted text-nowrap ms-2">{{ $contact->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection