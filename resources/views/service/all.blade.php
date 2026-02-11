@extends('layouts.app')

@section('title', 'Layanan Kami - BLUD SMKN 1 CIAMIS')

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5 position-relative overflow-hidden" 
    style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); min-height: 300px; display: flex; align-items: center;">
    <div class="hero-pattern" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="container position-relative z-index-1 text-center text-white">
        <h1 class="display-4 fw-bold mb-3" style="text-shadow: 0 2px 10px rgba(0,0,0,0.1);">Layanan & Fasilitas</h1>
        <p class="lead mb-4 mx-auto" style="max-width: 700px; opacity: 0.9;">
            Temukan berbagai layanan profesional dan fasilitas berkualitas yang kami sediakan untuk kebutuhan Anda.
        </p>
        
        <!-- Search Box -->
        <div class="search-box mx-auto" style="max-width: 600px;">
            <form action="{{ route('services.all') }}" method="GET" class="position-relative">
                <input type="text" name="search" class="form-control form-control-lg rounded-pill ps-4 pe-5 border-0 shadow-lg" 
                    placeholder="Cari layanan yang Anda butuhkan..." value="{{ request('search') }}"
                    style="height: 60px; font-size: 1.1rem;">
                <button type="submit" class="btn btn-primary rounded-circle position-absolute top-50 end-0 translate-middle-y me-2" 
                    style="width: 48px; height: 48px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- Services List -->
<section class="services-list py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Breadcrumb & Filter Info -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Layanan</li>
                </ol>
            </nav>
            
            @if(request('search'))
                <div class="text-muted">
                    Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
                    <a href="{{ route('services.all') }}" class="text-danger ms-2 text-decoration-none small">
                        <i class="fas fa-times-circle"></i> Reset
                    </a>
                </div>
            @endif
        </div>

        @if($services->count() > 0)
            <div class="row g-4">
                @foreach($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm hover-shadow transition-all" style="border-radius: 15px; overflow: hidden;">
                            <!-- Service Image/Icon Header -->
                            <div class="card-img-top position-relative" style="height: 200px; background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%); display: flex; align-items: center; justify-content: center;">
                                @if($service->image && file_exists(public_path('storage/' . $service->image)))
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="text-center text-primary opacity-75">
                                        <i class="fas fa-{{ $service->unit == 'orang' ? 'users' : ($service->unit == 'bus' ? 'bus' : ($service->unit == 'lab' ? 'laptop' : 'box')) }} fa-4x mb-3"></i>
                                    </div>
                                @endif
                                
                                <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark-transparent">
                                    <span class="badge bg-primary rounded-pill">
                                        <i class="fas fa-check-circle me-1"></i> Tersedia
                                    </span>
                                </div>
                            </div>
                            
                            <div class="card-body p-4 d-flex flex-column">
                                <h5 class="card-title fw-bold mb-2 text-dark">{{ $service->name }}</h5>
                                <p class="card-text text-muted mb-3 flex-grow-1" style="font-size: 0.95rem; line-height: 1.6;">
                                    {{ Str::limit($service->description, 100) }}
                                </p>
                                
                                <div class="pricing-info mb-4 bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <small class="text-muted"><i class="fas fa-clock me-1"></i> Per Jam</small>
                                        <span class="fw-bold text-primary">{{ $service->price_per_hour > 0 ? 'Rp ' . number_format($service->price_per_hour, 0, ',', '.') : '-' }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted"><i class="fas fa-calendar-day me-1"></i> Per Hari</small>
                                        <span class="fw-bold text-success">{{ $service->price_per_day > 0 ? 'Rp ' . number_format($service->price_per_day, 0, ',', '.') : '-' }}</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('service.show', $service->slug) }}" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold">
                                    Lihat Detail & Pesan <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $services->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-search fa-4x text-muted opacity-50"></i>
                </div>
                <h4 class="text-muted fw-bold">Layanan tidak ditemukan</h4>
                <p class="text-muted">Coba kata kunci lain atau reset pencarian Anda.</p>
                <a href="{{ route('services.all') }}" class="btn btn-primary mt-3 rounded-pill px-4">
                    <i class="fas fa-sync-alt me-2"></i> Reset Pencarian
                </a>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-white border-top">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Butuh Bantuan?</h2>
        <p class="text-muted mb-4 mx-auto" style="max-width: 600px;">
            Hubungi tim kami untuk informasi lebih lanjut mengenai layanan dan penyewaan fasilitas di BLUD SMKN 1 Ciamis.
        </p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="https://wa.me/{{ $contactInfo['whatsapp_number'] ?? '6281234567890' }}" target="_blank" class="btn btn-success btn-lg rounded-pill px-4 shadow-sm">
                <i class="fab fa-whatsapp me-2"></i> Chat WhatsApp
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg rounded-pill px-4">
                <i class="fas fa-envelope me-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    }
    .transition-all {
        transition: all 0.3s ease;
    }
    .object-fit-cover {
        object-fit: cover;
    }
    .bg-gradient-dark-transparent {
        background: linear-gradient(to top, rgba(0,0,0,0.5), transparent);
    }
    .page-item.active .page-link {
        background-color: #4A90E2;
        border-color: #4A90E2;
    }
    .page-link {
        color: #4A90E2;
    }
    .text-primary {
        color: #4A90E2 !important;
    }
    .btn-primary {
        background-color: #4A90E2;
        border-color: #4A90E2;
    }
    .btn-primary:hover {
        background-color: #357ABD;
        border-color: #357ABD;
    }
    .btn-outline-primary {
        color: #4A90E2;
        border-color: #4A90E2;
    }
    .btn-outline-primary:hover {
        background-color: #4A90E2;
        color: white;
    }
</style>
@endpush
