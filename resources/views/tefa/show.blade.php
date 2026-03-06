@extends('layouts.app')

@section('title', $tefa->name . ' - ' . config('app.name'))

@section('content')
<!-- Hero Banner Section -->
<div class="tefa-hero-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="hero-title">{{ $tefa->name }}</h1>
                <div class="hero-divider"></div>
                @if($tefa->description)
                <p class="hero-description">{{ $tefa->description }}</p>
                @endif
            </div>
            <div class="col-lg-5 text-center">
                <div class="hero-illustration">
                    @if($tefa->icon)
                    <i class="{{ $tefa->icon }} hero-icon"></i>
                    @else
                    <i class="fas fa-graduation-cap hero-icon"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Breadcrumb -->
<div class="breadcrumb-wrapper">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('tefa.all') }}">Program Keahlian</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $tefa->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- About Section -->
<section class="about-section">
    <div class="container">
        <h2 class="section-title">Tentang Jurusan Ini</h2>
        <div class="section-content">
            @if($tefa->about)
            <p>{!! nl2br(e($tefa->about)) !!}</p>
            @elseif($tefa->description)
            <p>{{ $tefa->description }}</p>
            @else
            <p>{{ $tefa->name }} adalah salah satu program keahlian yang ada di SMKN 1 Ciamis yang bertujuan untuk menghasilkan lulusan yang kompeten di bidangnya.</p>
            @endif
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
@if($tefa->vision || $tefa->mission)
<section class="visi-misi-section">
    <div class="container">
        <div class="row g-4">
            @if($tefa->vision)
            <div class="col-md-{{ $tefa->mission ? '6' : '12' }}">
                <div class="vm-card vm-visi">
                    <h3 class="vm-title">VISI</h3>
                    <div class="vm-content">
                        <p>{!! nl2br(e($tefa->vision)) !!}</p>
                    </div>
                </div>
            </div>
            @endif
            @if($tefa->mission)
            <div class="col-md-{{ $tefa->vision ? '6' : '12' }}">
                <div class="vm-card vm-misi">
                    <h3 class="vm-title">MISI</h3>
                    <div class="vm-content">
                        @php
                        $missions = array_filter(array_map('trim', explode("\n", $tefa->mission)));
                        @endphp
                        @if(count($missions) > 0)
                        <ul>
                            @foreach($missions as $missionItem)
                            <li>{{ $missionItem }}</li>
                            @endforeach
                        </ul>
                        @else
                        <p>{!! nl2br(e($tefa->mission)) !!}</p>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif

<!-- Video Section -->
@if($tefa->video_url)
<section class="video-section">
    <div class="container">
        <h2 class="section-title">Video Profil</h2>
        <div class="video-wrapper">
            <div class="ratio ratio-16x9">
                @php
                $videoUrl = $tefa->video_url;
                // Convert YouTube watch URL to embed URL
                if (strpos($videoUrl, 'youtube.com/watch') !== false) {
                parse_str(parse_url($videoUrl, PHP_URL_QUERY), $params);
                $videoUrl = 'https://www.youtube.com/embed/' . ($params['v'] ?? '');
                } elseif (strpos($videoUrl, 'youtu.be/') !== false) {
                $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                $videoUrl = 'https://www.youtube.com/embed/' . $videoId;
                }
                @endphp
                <iframe src="{{ $videoUrl }}" title="Video Profil {{ $tefa->name }}" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Kompetensi Keahlian Section -->
@if(is_array($tefa->services) && !empty($tefa->services))
<section class="kompetensi-section">
    <div class="container">
        <h2 class="section-title">Kompetensi Keahlian</h2>
        <div class="row g-4 justify-content-center">
            @foreach($tefa->services as $index => $service)
            <div class="col-md-6 col-lg-3">
                <div class="kompetensi-card">
                    <div class="kompetensi-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h4 class="kompetensi-title">{{ $service }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Prospek Kerja Section -->
@if(is_array($tefa->job_prospects) && !empty($tefa->job_prospects))
<section class="prospek-kerja-section">
    <div class="container">
        <h2 class="section-title text-white">Prospek Kerja</h2>

        <div class="row g-4 justify-content-center">
            @foreach($tefa->job_prospects as $job)
            <div class="col-md-6 col-lg-4">
                <div class="prospek-card">
                    <div class="prospek-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h4 class="prospek-title">{{ $job }}</h4>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Products Section (tetap ada untuk produk TEFA) -->
@if($products->count() > 0)
<section class="products-section">
    <div class="container">
        <h2 class="section-title">Produk & Layanan TEFA</h2>
        <p class="section-subtitle text-center mb-5">Produk dan layanan yang kami tawarkan</p>

        <div class="row g-4">
            @foreach($products as $product)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('products.show', $product->slug) }}" class="product-card-link">
                    <div class="product-display-card">
                        @if($product->image)
                        <div class="product-display-image">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </div>
                        @else
                        <div class="product-display-icon-wrapper">
                            <div class="product-display-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                        </div>
                        @endif
                        <div class="product-display-content">
                            <h4 class="product-display-title">{{ $product->name }}</h4>
                            @if($product->description)
                            <p class="product-display-desc">{{ Str::limit($product->description, 100) }}</p>
                            @endif
                            <div class="product-display-footer">
                                <span class="view-detail">Lihat Detail <i class="fas fa-arrow-right ms-2"></i></span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
        <div class="pagination-wrapper mt-5">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</section>
@endif

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
    /* Hero Banner Section */
    .tefa-hero-banner {
        background: #4A90E2;
        padding: 4rem 0;
        position: relative;
        overflow: hidden;
    }

    .tefa-hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
        opacity: 0.1;
    }

    .tefa-hero-banner .container {
        position: relative;
        z-index: 2;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
    }

    .hero-divider {
        width: 60px;
        height: 4px;
        background: white;
        margin-bottom: 1.5rem;
    }

    .hero-description {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.8;
    }

    .hero-illustration {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .hero-icon {
        font-size: 8rem;
        color: rgba(255, 255, 255, 0.2);
    }

    /* Breadcrumb */
    .breadcrumb-wrapper {
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
        color: #0d6675;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        color: #0a4d5c;
        text-decoration: underline;
    }

    .breadcrumb-item.active {
        color: #6c757d;
    }

    /* Section Styles */
    .about-section,
    .kompetensi-section,
    .video-section {
        padding: 4rem 0;
        background: #fff;
    }

    .visi-misi-section {
        padding: 4rem 0;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 2rem;
        text-align: center;
    }

    .section-content {
        max-width: 900px;
        margin: 0 auto;
        font-size: 1rem;
        line-height: 1.8;
        color: #495057;
        text-align: justify;
    }

    /* Visi Misi Cards */
    .vm-card {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        height: 100%;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .vm-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .vm-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid;
    }

    .vm-visi .vm-title {
        color: #0d6675;
        border-bottom-color: #0d6675;
    }

    .vm-misi .vm-title {
        color: #0a4d5c;
        border-bottom-color: #0a4d5c;
    }

    .vm-content {
        font-size: 1rem;
        line-height: 1.8;
        color: #495057;
    }

    .vm-content ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .vm-content ul li {
        padding-left: 1.5rem;
        margin-bottom: 0.75rem;
        position: relative;
    }

    .vm-content ul li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #0d6675;
        font-weight: bold;
    }

    /* Video Section */
    .video-wrapper {
        max-width: 900px;
        margin: 0 auto;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .video-wrapper iframe {
        border: none;
    }

    /* Kompetensi Keahlian */
    .kompetensi-card {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 2rem 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        border: 2px solid transparent;
    }

    .kompetensi-card:hover {
        transform: translateY(-5px);
        background: white;
        border-color: #0d6675;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .kompetensi-icon {
        width: 60px;
        height: 60px;
        background: #e3f7fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .kompetensi-icon i {
        font-size: 1.8rem;
        color: #0d6675;
    }

    .kompetensi-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    /* Prospek Kerja Section */
    .prospek-kerja-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #0a4d5c 0%, #0d6675 100%);
    }

    .prospek-kerja-section .section-title {
        color: white;
    }

    .prospek-card-link {
        text-decoration: none;
        display: block;
    }

    .prospek-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        padding: 2rem;
        height: 100%;
        transition: all 0.3s ease;
    }

    .prospek-card:hover {
        background: rgba(255, 255, 255, 0.15);
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .prospek-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .prospek-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .prospek-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        margin-bottom: 0.75rem;
    }

    .prospek-desc {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        line-height: 1.6;
    }

    /* Products Section */
    .products-section {
        padding: 4rem 0;
        background: #f8f9fa;
    }

    .products-section .section-title {
        color: #1a1a2e;
    }

    .section-subtitle {
        color: #6c757d;
        font-size: 1rem;
    }

    .product-card-link {
        text-decoration: none;
        display: block;
    }

    .product-display-card {
        background: white;
        border-radius: 12px;
        padding: 0;
        height: 100%;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    .product-display-card:hover {
        border-color: #0d6675;
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(13, 102, 117, 0.15);
    }

    .product-display-icon-wrapper {
        padding: 2rem 2rem 0 2rem;
    }

    .product-display-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #0d6675 0%, #0a4d5c 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .product-display-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .product-display-image {
        width: 100%;
        height: 220px;
        border-radius: 0;
        overflow: hidden;
        margin-bottom: 0;
        background: #f8f9fa;
    }

    .product-display-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-display-card:hover .product-display-image img {
        transform: scale(1.05);
    }

    .product-display-content {
        padding: 1.5rem 2rem 2rem 2rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-display-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 1rem;
        line-height: 1.4;
    }

    .product-display-desc {
        font-size: 0.95rem;
        color: #6c757d;
        margin-bottom: 1.5rem;
        line-height: 1.6;
        flex: 1;
    }

    .product-display-footer {
        padding-top: 1rem;
        border-top: 2px solid #e9ecef;
    }

    .view-detail {
        color: #0d6675;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .product-display-card:hover .view-detail {
        color: #0a4d5c;
    }

    /* Contact Section */
    .contact-section {
        padding: 4rem 0;
        background: #f8f9fa;
    }

    .contact-card {
        background: white;
        padding: 3rem;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .contact-card h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 0.5rem;
    }

    .contact-card>p {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .btn-contact-whatsapp {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 2rem;
        background: #25D366;
        color: white;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3);
    }

    .btn-contact-whatsapp:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
        color: white;
    }

    .btn-contact-whatsapp i {
        font-size: 1.5rem;
    }

    .contact-details {
        border-top: 2px solid #f0f0f0;
        padding-top: 2rem;
        margin-top: 2rem;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
    }

    .contact-item i {
        font-size: 1.5rem;
        color: #0d6675;
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
        font-size: 0.95rem;
    }

    .contact-item a {
        color: #0d6675;
        text-decoration: none;
    }

    .contact-item a:hover {
        text-decoration: underline;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Pagination untuk section dark (prospek kerja) */
    .prospek-kerja-section .pagination-wrapper .pagination .page-link {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .prospek-kerja-section .pagination-wrapper .pagination .page-link:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .prospek-kerja-section .pagination-wrapper .pagination .page-item.active .page-link {
        background: white;
        color: #0d6675;
        border-color: white;
    }

    /* Pagination untuk section light (produk & layanan) */
    .products-section .pagination-wrapper .pagination .page-link {
        color: #0d6675;
        background: white;
        border: 1px solid #dee2e6;
    }

    .products-section .pagination-wrapper .pagination .page-link:hover {
        background: #0d6675;
        color: white;
        border-color: #0d6675;
    }

    .products-section .pagination-wrapper .pagination .page-item.active .page-link {
        background: #0d6675;
        color: white;
        border-color: #0d6675;
    }

    /* Responsive */
    @media (max-width: 991px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-icon {
            font-size: 5rem;
        }
    }

    @media (max-width: 767px) {
        .tefa-hero-banner {
            padding: 3rem 0;
        }

        .hero-title {
            font-size: 1.75rem;
        }

        .hero-icon {
            font-size: 4rem;
            margin-top: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
        }

        .vm-card,
        .contact-card {
            padding: 1.5rem;
        }

        .btn-contact-whatsapp {
            width: 100%;
            justify-content: center;
            margin-top: 1.5rem;
        }
    }
</style>
@endsection