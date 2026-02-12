@extends('layouts.app')

@section('title', $tefa->name . ' - ' . config('app.name'))

@section('content')
<!-- Hero Banner Section -->
<div class="tefa-hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-text">
                        @if($tefa->icon)
                        <div class="tefa-icon-large">
                            <i class="{{ $tefa->icon }}"></i>
                        </div>
                        @endif
                        <h1 class="hero-title">{{ $tefa->name }}</h1>
                        <p class="hero-subtitle">{{ $tefa->code }}</p>
                        @if($tefa->description)
                        <p class="hero-description">{{ Str::limit($tefa->description, 200) }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tefa.all') }}">TEFA</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $tefa->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- About TEFA Section -->
@if($tefa->description)
<div class="about-tefa-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Tentang {{ $tefa->name }}</h2>
            <div class="header-divider"></div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="about-content">
                    <p>{{ $tefa->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Services Section -->
@if(is_array($tefa->services) && !empty($tefa->services))
<div class="services-section">
    <div class="container">
        <div class="section-header text-center">
            <h2>Layanan Kami</h2>
            <p>Berbagai layanan yang kami tawarkan</p>
            <div class="header-divider"></div>
        </div>
        <div class="row g-4">
            @foreach($tefa->services as $index => $service)
            <div class="col-md-6 col-lg-4">
                <div class="service-card" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="service-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="service-title">{{ $service }}</h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Products Section -->
<div class="products-section">
    <div class="container">
        <div class="section-header text-center">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h2>Produk Kami</h2>
                    <p class="mb-0">Produk berkualitas dari {{ $tefa->name }}</p>
                </div>
                <a href="{{ route('products.all', ['tefa' => $tefa->slug]) }}" class="btn btn-outline-primary">
                    <i class="fas fa-search"></i> Cari & Filter
                </a>
            </div>
            <div class="header-divider mb-5"></div>
        </div>

        @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-md-6 col-lg-3">
                <div class="product-card" onclick="window.location.href='{{ route('products.show', $product->slug) }}'">
                    <div class="product-image">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        @if($product->stock <= 0)
                            <div class="product-badge out-of-stock">Habis
                    </div>
                    @elseif($product->is_featured)
                    <div class="product-badge featured">Unggulan</div>
                    @endif
                </div>
                <div class="product-content">
                    <h3 class="product-title">{{ $product->name }}</h3>
                    @if($product->category)
                    <p class="product-category">{{ ucfirst($product->category) }}</p>
                    @endif
                    <p class="product-price">{{ $product->formatted_price }}</p>
                    <div class="product-footer">
                        @if($product->stock > 0)
                        <span class="stock-available">
                            <i class="fas fa-check-circle"></i> Tersedia
                        </span>
                        @else
                        <span class="stock-unavailable">
                            <i class="fas fa-times-circle"></i> Habis
                        </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="pagination-wrapper">
        {{ $products->links() }}
    </div>
    @endif
    @else
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <h3>Belum Ada Produk</h3>
        <p>Produk dari {{ $tefa->name }} akan segera hadir</p>
    </div>
    @endif
</div>
</div>

<!-- Contact Section -->
<div class="contact-section">
    <div class="container">
        <div class="contact-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3>Tertarik dengan {{ $tefa->name }}?</h3>
                    <p>Hubungi kami untuk informasi lebih lanjut atau pemesanan produk</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @php
                    // Temporarily hardcoded number
                    $targetWa = '6287790984032';
                    @endphp
                    <a href="https://wa.me/{{ $targetWa }}?text=Halo, saya tertarik dengan layanan di {{ urlencode($tefa->name) }}" target="_blank" class="btn-contact-whatsapp">
                        <i class="fab fa-whatsapp"></i> Hubungi via WhatsApp
                    </a>
                </div>
            </div>

            @if($tefa->contact_person || $tefa->contact_email || $tefa->contact_number)
            <div class="contact-details">
                <div class="row g-4 mt-3">
                    @if($tefa->contact_person)
                    <div class="col-md-4">
                        <div class="contact-item">
                            <i class="fas fa-user"></i>
                            <div>
                                <strong>Contact Person</strong>
                                <p>{{ $tefa->contact_person }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($tefa->contact_email)
                    <div class="col-md-4">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong>
                                <p><a href="mailto:{{ $tefa->contact_email }}">{{ $tefa->contact_email }}</a></p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($tefa->contact_number)
                    <div class="col-md-4">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Telepon</strong>
                                <p><a href="tel:{{ $tefa->contact_number }}">{{ $tefa->contact_number }}</a></p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Hero Section */
    .tefa-hero-section {
        position: relative;
        background: #0992C2;
        padding: 6rem 0 4rem;
        margin-bottom: 0;
        overflow: hidden;
    }

    .tefa-hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        opacity: 0.3;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: transparent;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .tefa-icon-large {
        display: inline-block;
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .tefa-icon-large i {
        font-size: 2.5rem;
        color: white;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1.5rem;
        font-weight: 500;
    }

    .hero-description {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.8;
        max-width: 700px;
    }

    /* Breadcrumb */
    .breadcrumb-section {
        background: #f8f9fa;
        padding: 1rem 0;
        border-bottom: 1px solid #e9ecef;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        padding: 0;
    }

    .breadcrumb-item a {
        color: #4A90E2;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #357ABD;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    /* Section Styles */
    .about-tefa-section,
    .services-section,
    .products-section {
        padding: 5rem 0;
    }

    .section-header {
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: #6c757d;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .header-divider {
        width: 80px;
        height: 4px;
        background: #0992C2;
        margin: 0 auto;
        border-radius: 2px;
    }

    /* About Content */
    .about-content {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        font-size: 1.1rem;
        line-height: 1.8;
        color: #495057;
    }

    /* Services Section */
    .services-section {
        background: #ffffff;
    }

    .service-card {
        background: white;
        padding: 2.5rem 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        height: 100%;
        border-left: 4px solid #4A90E2;
    }

    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .service-icon {
        width: 60px;
        height: 60px;
        background: #0992C2;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .service-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .service-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
        line-height: 1.5;
    }

    /* Products Section */
    .product-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .product-badge.featured {
        background: rgba(255, 193, 7, 0.9);
        color: #000;
    }

    .product-badge.out-of-stock {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    .product-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-category {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.75rem;
    }

    .product-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0992C2;
        margin-bottom: 1rem;
    }

    .product-footer {
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .stock-available {
        color: #28a745;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .stock-unavailable {
        color: #dc3545;
        font-weight: 600;
        font-size: 0.9rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
    }

    .empty-state i {
        font-size: 5rem;
        color: #dee2e6;
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.8rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: #adb5bd;
        font-size: 1.1rem;
    }

    /* Contact Section */
    .contact-section {
        padding: 5rem 0;
        background: #0992C2;
    }

    .contact-card {
        background: white;
        padding: 3rem;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
    }

    .contact-card h3 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }

    .contact-card>p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    .btn-contact-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        background: #0992C2;
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
    }

    .btn-contact-whatsapp:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(37, 211, 102, 0.6);
        color: white;
    }

    .btn-contact-whatsapp i {
        font-size: 1.5rem;
    }

    .contact-details {
        border-top: 2px solid #f0f0f0;
        padding-top: 2rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .contact-item i {
        font-size: 1.5rem;
        color: #4A90E2;
        margin-top: 0.25rem;
    }

    .contact-item strong {
        display: block;
        color: #1a1a2e;
        margin-bottom: 0.25rem;
        font-size: 1rem;
    }

    .contact-item p {
        margin: 0;
        color: #6c757d;
    }

    .contact-item a {
        color: #4A90E2;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .contact-item a:hover {
        color: #357ABD;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
        }

        .section-header h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .tefa-hero-section {
            padding: 4rem 0 3rem;
        }

        .hero-title {
            font-size: 2rem;
        }

        .about-content {
            padding: 2rem;
        }

        .contact-card {
            padding: 2rem;
        }

        .btn-contact-whatsapp {
            width: 100%;
            justify-content: center;
            margin-top: 1rem;
        }
    }

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-content,
    .about-content,
    .service-card,
    .product-card {
        animation: fadeInUp 0.6s ease;
    }
</style>
@endsection