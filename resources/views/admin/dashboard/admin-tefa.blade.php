@extends('admin.layouts.app')

@section('title', 'Dashboard ' . Auth::guard('admin')->user()->name)

@section('content')
<div class="container-fluid admintefa-dashboard">
    <div class="dashboard-hero mb-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h1 class="dashboard-title mb-1">
                    Dashboard Admin TEFA
                    @if($myTefa)
                    <span class="badge bg-primary ms-2 align-middle">{{ $myTefa->name }}</span>
                    @endif
                </h1>
                <p class="dashboard-subtitle mb-0">
                    Selamat datang, <strong>{{ Auth::guard('admin')->user()->name }}</strong>
                    @if($myTefa)
                    · Kelola data jurusan Anda dengan cepat dan rapi
                    @endif
                </p>
            </div>
        </div>
    </div>

    @if($myTefa)
    <div class="tefa-info-card mb-4">
        <div class="tefa-icon-wrap">
            <i class="{{ $myTefa->icon ?? 'fas fa-school' }}"></i>
        </div>
        <div>
            <h6 class="mb-1 fw-bold text-primary">{{ $myTefa->name }}</h6>
            <p class="mb-0 text-muted small">{{ $myTefa->description ?? 'Jurusan TEFA Anda' }}</p>
        </div>
    </div>
    @endif

    <div class="row g-4 mb-4">
        <div class="col-xl-6 col-md-6">
            <div class="stat-card stat-card-primary h-100">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Total Layanan</div>
                        <div class="stat-value">{{ $stats['total_products'] }}</div>
                        <div class="stat-note">Layanan aktif di jurusan Anda</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                </div>
                <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-sm btn-outline-primary mt-3">
                    <i class="fas fa-cog me-1"></i> Kelola Layanan
                </a>
            </div>
        </div>

        @if(Route::has($routePrefix . '.contacts.index'))
        <div class="col-xl-6 col-md-6">
            <div class="stat-card stat-card-success h-100">
                <div class="stat-top">
                    <div>
                        <div class="stat-label">Pesan Masuk</div>
                        <div class="stat-value">{{ $stats['total_contacts'] }}</div>
                        <div class="stat-note">Pesan belum dibaca</div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <a href="{{ route($routePrefix . '.contacts.index') }}" class="btn btn-sm btn-outline-success mt-3">
                    <i class="fas fa-cog me-1"></i> Kelola Pesan
                </a>
            </div>
        </div>
        @endif
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-box-open me-2"></i>Layanan Terbaru
                    </h6>
                    <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="content-card-body p-0">
                    @if($recentProducts->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-box-open mb-2"></i>
                        <p class="mb-0">Belum ada layanan</p>
                        <a href="{{ route($routePrefix . '.products.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i> Tambah Layanan
                        </a>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($recentProducts as $product)
                        <div class="list-group-item list-item-modern">
                            <div class="d-flex justify-content-between align-items-center gap-2">
                                <div>
                                    <div class="fw-semibold">{{ $product->name }}</div>
                                </div>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ \App\Helpers\StatusHelper::getProductStatusLabel($product->status) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if(Route::has($routePrefix . '.contacts.index'))
        <div class="col-lg-6">
            <div class="content-card h-100">
                <div class="content-card-header">
                    <h6 class="m-0 fw-bold text-success">
                        <i class="fas fa-envelope me-2"></i>Pesan Masuk Terbaru
                    </h6>
                    <a href="{{ route($routePrefix . '.contacts.index') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>
                <div class="content-card-body p-0">
                    @if($recentContacts->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-inbox mb-2"></i>
                        <p class="mb-0">Belum ada pesan masuk</p>
                    </div>
                    @else
                    <div class="list-group list-group-flush">
                        @foreach($recentContacts as $contact)
                        <a href="{{ route($routePrefix . '.contacts.show', $contact->id) }}" class="list-group-item list-group-item-action list-item-modern {{ $contact->status == 'new' ? 'list-group-item-primary' : '' }}">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <div class="fw-semibold">
                                        {{ $contact->name }}
                                        @if($contact->status == 'new')
                                        <span class="badge bg-danger ms-1" style="font-size:0.65em;">Baru</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">{{ Str::limit($contact->subject, 60) }}</small>
                                </div>
                                <small class="text-muted text-nowrap">{{ $contact->created_at->diffForHumans() }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    .admintefa-dashboard .dashboard-hero {
        background: #ffffff;
        border: 1px solid #e7edf3;
        border-radius: 14px;
        padding: 1.1rem 1.25rem;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
    }

    .admintefa-dashboard .dashboard-title {
        font-size: 1.45rem;
        font-weight: 800;
        color: #1f2937;
    }

    .admintefa-dashboard .dashboard-subtitle {
        color: #6b7280;
        font-size: 0.92rem;
    }

    .admintefa-dashboard .tefa-info-card {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        background: #ffffff;
        border: 1px solid #e7edf3;
        border-radius: 14px;
        padding: 0.9rem 1rem;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
    }

    .admintefa-dashboard .tefa-icon-wrap {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(78, 115, 223, 0.12);
        color: #4e73df;
        font-size: 1.35rem;
        flex-shrink: 0;
    }

    .admintefa-dashboard .stat-card {
        background: #ffffff;
        border: 1px solid #e7edf3;
        border-radius: 14px;
        padding: 1.1rem 1.1rem 1rem;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
    }

    .admintefa-dashboard .stat-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 0.75rem;
    }

    .admintefa-dashboard .stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        color: #6b7280;
        margin-bottom: 0.2rem;
    }

    .admintefa-dashboard .stat-value {
        font-size: 1.7rem;
        font-weight: 800;
        color: #1f2937;
        line-height: 1.1;
    }

    .admintefa-dashboard .stat-note {
        margin-top: 0.35rem;
        font-size: 0.82rem;
        color: #6b7280;
    }

    .admintefa-dashboard .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #ffffff;
        flex-shrink: 0;
    }

    .admintefa-dashboard .stat-card-primary .stat-icon {
        background: #4e73df;
    }

    .admintefa-dashboard .stat-card-success .stat-icon {
        background: #1cc88a;
    }

    .admintefa-dashboard .content-card {
        background: #ffffff;
        border: 1px solid #e7edf3;
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.06);
        overflow: hidden;
    }

    .admintefa-dashboard .content-card-header {
        padding: 0.95rem 1rem;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.6rem;
    }

    .admintefa-dashboard .list-item-modern {
        padding: 0.75rem 1rem;
        border-color: #eef2f7;
    }

    .admintefa-dashboard .empty-state {
        text-align: center;
        padding: 1.8rem 1rem;
        color: #6b7280;
    }

    .admintefa-dashboard .empty-state i {
        font-size: 1.6rem;
        color: #9ca3af;
        display: block;
    }

    @media (max-width: 767px) {
        .admintefa-dashboard .dashboard-title {
            font-size: 1.2rem;
        }

        .admintefa-dashboard .dashboard-hero,
        .admintefa-dashboard .tefa-info-card,
        .admintefa-dashboard .stat-card {
            border-radius: 12px;
        }
    }
</style>
@endsection
