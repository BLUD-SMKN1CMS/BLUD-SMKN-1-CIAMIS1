@extends('layouts.app')

@section('title', $tefa->name . ' - ' . config('app.name'))

@section('content')
<section class="tefa-header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="tefa-main-title">{{ $tefa->name }}</h1>
                @if($tefa->description)
                <p class="tefa-main-description">{{ $tefa->description }}</p>
                @endif
            </div>
            <div class="col-lg-4 d-flex justify-content-center mt-3 mt-lg-0">
                @if($tefa->logo)
                <img src="{{ asset($tefa->logo) }}" alt="Icon {{ $tefa->name }}" style="width: 180px; height: 180px; object-fit: contain; border-radius: 16px; border: 1px solid rgba(15, 23, 42, 0.12); box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16); background: #ffffff; padding: 10px;">
                @elseif($tefa->icon)
                <div style="font-size: 100px; line-height: 1; color: #4e73df; display:flex; align-items:center; justify-content:center; width:180px; height:180px; border-radius:16px; background:#eef3ff; border: 1px solid rgba(15, 23, 42, 0.12); box-shadow: 0 10px 24px rgba(15, 23, 42, 0.16);">
                    <i class="{{ $tefa->icon }}"></i>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

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

<section class="tefa-spotlight-section">
    <div class="container">
        @php
        $sliderImages = collect($tefa->slider_image_urls ?? [])
        ->filter(fn($url) => is_string($url) && trim($url) !== '')
        ->values();

        if ($sliderImages->isEmpty()) {
        $sliderImages = collect([$tefa->banner_url, $tefa->logo_url])
        ->filter(fn($url) => is_string($url) && trim($url) !== '')
        ->unique()
        ->values();
        }
        @endphp
        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <!-- Slider Card -->
                <div class="spotlight-main-card">
                    <div id="tefaVisualSlider" class="carousel slide carousel-fade spotlight-slider" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            @foreach($sliderImages as $index => $sliderImage)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ $sliderImage }}" class="d-block w-100" alt="Visual {{ $tefa->name }} {{ $index + 1 }}">
                            </div>
                            @endforeach
                        </div>
                        @if($sliderImages->count() > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#tefaVisualSlider" data-bs-slide="prev" aria-label="Sebelumnya">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#tefaVisualSlider" data-bs-slide="next" aria-label="Berikutnya">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                        @endif
                    </div>
                </div>

                <!-- About Content Card -->
                <div class="spotlight-about-card">
                    <div class="spotlight-content">
                        <h2>Tentang {{ $tefa->name }}</h2>
                        @if($tefa->about)
                        <p>{!! nl2br(e($tefa->about)) !!}</p>
                        @elseif($tefa->description)
                        <p>{{ $tefa->description }}</p>
                        @else
                        <p>{{ $tefa->name }} adalah salah satu program keahlian di SMKN 1 Ciamis yang berfokus pada pembelajaran berbasis industri dan penguatan kompetensi peserta didik.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <aside class="featured-services-card h-100">
                    <h3><i class="fas fa-fire me-2"></i>Layanan Unggulan</h3>
                    @if($featuredServices->isEmpty())
                    <div class="empty-featured-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada layanan unggulan untuk jurusan ini.</p>
                    </div>
                    @else
                    <div class="featured-services-list">
                        @foreach($featuredServices as $service)
                        @if(!empty($service->link_url))
                        <a href="{{ $service->link_url }}" class="featured-service-item">
                            <div class="featured-service-icon">
                                <i class="{{ $service->icon ?: 'fas fa-concierge-bell' }}"></i>
                            </div>
                            <div class="featured-service-text">
                                <h4>{{ $service->name }}</h4>
                                <p>{{ Str::limit(strip_tags($service->description), 60) }}</p>
                            </div>
                        </a>
                        @else
                        <div class="featured-service-item featured-service-item-static">
                            <div class="featured-service-icon">
                                <i class="{{ $service->icon ?: 'fas fa-concierge-bell' }}"></i>
                            </div>
                            <div class="featured-service-text">
                                <h4>{{ $service->name }}</h4>
                                <p>{{ Str::limit(strip_tags($service->description), 60) }}</p>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</section>

@php
$videoUrl = trim((string) ($tefa->video_url ?? ''));
$embedVideoUrl = null;

if ($videoUrl !== '') {
if (preg_match('/(?:youtube\.com\/(?:watch\?v=|shorts\/|embed\/)|youtu\.be\/)([A-Za-z0-9_-]{11})/', $videoUrl, $matches)) {
$embedVideoUrl = 'https://www.youtube.com/embed/' . $matches[1];
} elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
$embedVideoUrl = 'https://player.vimeo.com/video/' . $matches[1];
}
}
@endphp

@if($embedVideoUrl)
<section class="tefa-video-section">
    <div class="container">
        <div class="section-headline mb-3">
            <h2>Video Profil {{ $tefa->name }}</h2>
        </div>
        <div class="tefa-video-card">
            <div class="tefa-video-frame-wrap">
                <iframe
                    src="{{ $embedVideoUrl }}"
                    title="Video Profil {{ $tefa->name }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>
</section>
@endif

@if($tefa->vision || $tefa->mission)
<section class="visi-misi-section">
    <div class="container">
        <h2 class="section-title">Visi & Misi</h2>
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

@if($products->count() > 0)
<section class="products-section">
    <div class="container">
        <h2 class="section-title">Layanan Jurusan</h2>
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

        @if($products->hasPages())
        <div class="pagination-wrapper mt-5">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</section>
@endif

<section class="all-services-section">
    <div class="container">
        <div class="section-headline">
            <h2>Semua Layanan {{ $tefa->name }}</h2>
            <p>Daftar lengkap layanan jurusan, baik yang unggulan maupun non-unggulan.</p>
        </div>

        @if($allServices->isEmpty())
        <div class="all-services-empty">
            <i class="fas fa-tools"></i>
            <h3>Layanan Belum Tersedia</h3>
            <p>Data layanan untuk jurusan ini belum tersedia saat ini.</p>
        </div>
        @else
        <div class="row g-4">
            @foreach($allServices as $service)
            <div class="col-md-6 col-xl-4">
                @if(!empty($service->link_url))
                <a href="{{ $service->link_url }}" class="all-service-card">
                    <div class="all-service-media">
                        @if($service->image)
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}">
                        @else
                        <div class="all-service-icon-fallback">
                            <i class="{{ $service->icon ?: 'fas fa-cubes' }}"></i>
                        </div>
                        @endif
                    </div>
                    <div class="all-service-content">
                        <h3>{{ $service->name }}</h3>
                        <p>{{ Str::limit(strip_tags($service->description), 110) }}</p>
                        <span class="all-service-link">Lihat Detail <i class="fas fa-arrow-right ms-2"></i></span>
                    </div>
                </a>
                @else
                <div class="all-service-card all-service-card-static">
                    <div class="all-service-media">
                        <div class="all-service-icon-fallback">
                            <i class="{{ $service->icon ?: 'fas fa-cubes' }}"></i>
                        </div>
                    </div>
                    <div class="all-service-content">
                        <h3>{{ $service->name }}</h3>
                        <p>{{ Str::limit(strip_tags($service->description), 110) }}</p>
                        <span class="all-service-link text-muted">Data layanan jurusan</span>
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<section class="tefa-contact-cta">
    <div class="container">
        <div class="tefa-contact-card">
            <h2>Ada Pertanyaan?</h2>
            <p>Tim kami siap membantu Anda dengan senang hati</p>
            <div class="tefa-contact-actions">
                @if(!empty($tefaContactInfo['phone']))
                <a href="tel:{{ preg_replace('/\s+/', '', (string) $tefaContactInfo['phone']) }}" class="contact-btn contact-btn-outline">
                    <i class="fas fa-phone"></i> {{ $tefaContactInfo['phone'] }}
                </a>
                @endif

                @if(!empty($tefaContactInfo['email']))
                <a href="mailto:{{ $tefaContactInfo['email'] }}" class="contact-btn contact-btn-outline">
                    <i class="fas fa-envelope"></i> Email
                </a>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .tefa-header-section {
        padding: 3.2rem 0 2rem;
        background: radial-gradient(circle at top left, #eaf5ff 0%, #f7fbff 45%, #ffffff 100%);
        border-bottom: 1px solid #e6edf4;
    }

    .tefa-main-title {
        font-size: clamp(1.7rem, 2vw + 1.1rem, 2.55rem);
        font-weight: 800;
        color: #152332;
        margin-bottom: 0.6rem;
        line-height: 1.2;
    }

    .tefa-main-description {
        color: #4f6478;
        margin: 0;
        font-size: 1rem;
        max-width: 920px;
    }

    .breadcrumb-wrapper {
        background: #f8f9fa;
        padding: 0.9rem 0;
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

    .breadcrumb-item.active {
        color: #6c757d;
    }

    .tefa-spotlight-section {
        padding: 3rem 0;
        background: #ffffff;
    }

    .spotlight-main-card {
        background: #ffffff;
        border: 1px solid #e9eef3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(17, 45, 74, 0.08);
        height: auto;
    }

    .spotlight-about-card {
        background: #ffffff;
        border: 1px solid #e9eef3;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(17, 45, 74, 0.08);
        overflow: hidden;
        margin-top: 1rem;
    }

    .spotlight-slider {
        padding: 0;
        margin: 0;
        background: transparent;
        height: 390px;
        position: relative;
    }

    .spotlight-slider .carousel-inner,
    .spotlight-slider .carousel-item {
        background: transparent;
        height: 100%;
    }

    .spotlight-slider .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .spotlight-slider.carousel-fade .carousel-item {
        transition: opacity 0.5s ease-in-out;
    }

    .spotlight-slider .carousel-control-prev,
    .spotlight-slider .carousel-control-next {
        top: 50%;
        bottom: auto;
        transform: translateY(-50%);
    }

    .spotlight-content {
        padding: 1.5rem 1.6rem 1.8rem;
    }

    .spotlight-content h2 {
        font-size: 1.45rem;
        font-weight: 750;
        color: #162436;
        margin-bottom: 0.85rem;
    }

    .spotlight-content p {
        color: #56687a;
        line-height: 1.85;
        margin: 0;
    }

    .featured-services-card {
        background: #ffffff;
        border: 1px solid #e8edf3;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(19, 41, 61, 0.08);
        padding: 1.25rem;
    }

    .featured-services-card h3 {
        font-size: 1rem;
        font-weight: 700;
        color: #203246;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #edf1f5;
    }

    .featured-services-list {
        display: grid;
        gap: 0.8rem;
    }

    .featured-service-item {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
        border: 1px solid #ebf0f4;
        background: #fdfefe;
        border-radius: 12px;
        padding: 0.8rem;
        text-decoration: none;
        transition: all 0.24s ease;
    }

    .featured-service-item:hover {
        border-color: #b6d5df;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(16, 76, 94, 0.14);
    }

    .featured-service-item-static {
        cursor: default;
    }

    .featured-service-item-static:hover {
        transform: none;
        box-shadow: none;
    }

    .featured-service-icon {
        width: 36px;
        height: 36px;
        flex-shrink: 0;
        border-radius: 10px;
        background: #e8f4f8;
        color: #0f6b82;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .featured-service-text h4 {
        color: #203246;
        font-size: 0.95rem;
        font-weight: 700;
        margin: 0 0 0.35rem;
        line-height: 1.3;
    }

    .featured-service-text p {
        color: #6a7c8f;
        margin: 0;
        font-size: 0.84rem;
        line-height: 1.45;
    }

    .empty-featured-state {
        border: 1px dashed #d6e2eb;
        border-radius: 12px;
        background: #fbfdff;
        text-align: center;
        color: #7a8c9f;
        padding: 1.25rem 0.9rem;
    }

    .empty-featured-state i {
        font-size: 1.3rem;
        margin-bottom: 0.4rem;
    }

    .all-services-section {
        padding: 3rem 0;
        background: linear-gradient(180deg, #f7fafd 0%, #ffffff 65%);
    }

    .section-headline {
        margin-bottom: 1.8rem;
    }

    .section-headline h2 {
        font-size: 1.55rem;
        font-weight: 780;
        color: #1b2b3c;
        margin-bottom: 0.45rem;
    }

    .section-headline p {
        margin: 0;
        color: #6a7d90;
    }

    .all-services-empty {
        border: 1px dashed #cfdce7;
        border-radius: 14px;
        background: #ffffff;
        padding: 2rem;
        text-align: center;
        color: #688196;
    }

    .all-services-empty i {
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .all-services-empty h3 {
        font-size: 1.1rem;
        margin-bottom: 0.35rem;
        color: #1f3248;
    }

    .all-service-card {
        display: flex;
        flex-direction: column;
        text-decoration: none;
        border: 1px solid #e5ecf2;
        border-radius: 14px;
        overflow: hidden;
        background: #ffffff;
        height: 100%;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(23, 40, 63, 0.06);
    }

    .all-service-card:hover {
        transform: translateY(-5px);
        border-color: #9cc4d2;
        box-shadow: 0 10px 24px rgba(12, 88, 109, 0.14);
    }

    .all-service-card-static {
        cursor: default;
    }

    .all-service-card-static:hover {
        transform: none;
        border-color: #e5ecf2;
        box-shadow: 0 4px 14px rgba(23, 40, 63, 0.06);
    }

    .all-service-media {
        width: 100%;
        height: 190px;
        background: #f2f6fa;
    }

    .all-service-media img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .all-service-icon-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f6b82;
        background: linear-gradient(160deg, #e6f2f6 0%, #f3f8fb 100%);
    }

    .all-service-icon-fallback i {
        font-size: 2.1rem;
    }

    .all-service-content {
        padding: 1rem 1rem 1.15rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .all-service-content h3 {
        margin: 0 0 0.45rem;
        font-size: 1.04rem;
        font-weight: 740;
        color: #1d3043;
        line-height: 1.35;
    }

    .all-service-content p {
        color: #64788d;
        margin: 0 0 0.95rem;
        line-height: 1.55;
        font-size: 0.9rem;
        flex: 1;
    }

    .all-service-link {
        color: #0d6675;
        font-size: 0.9rem;
        font-weight: 700;
    }

    .tefa-video-section {
        padding: 3rem 0;
        background: #ffffff;
    }

    .tefa-video-card {
        background: #ffffff;
        border: 1px solid #e5ecf2;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(19, 41, 61, 0.08);
        padding: 1rem;
    }

    .tefa-video-frame-wrap {
        position: relative;
        width: 100%;
        padding-top: 56.25%;
        border-radius: 12px;
        overflow: hidden;
        background: #e9eef4;
    }

    .tefa-video-frame-wrap iframe {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }

    .visi-misi-section {
        padding: 3rem 0;
        background: #f8f9fa;
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 750;
        color: #1a1a2e;
        margin-bottom: 2rem;
        text-align: center;
    }

    .vm-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        height: 100%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .vm-title {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 1.2rem;
        padding-bottom: 0.6rem;
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
        margin-bottom: 0.7rem;
        position: relative;
    }

    .vm-content ul li::before {
        content: 'â€¢';
        position: absolute;
        left: 0;
        color: #0d6675;
        font-weight: bold;
    }

    .prospek-kerja-section {
        padding: 3rem 0;
        background: #f8f9fa;
    }

    .prospek-kerja-section .section-title {
        color: #1a1a2e;
    }

    .prospek-card {
        background: #ffffff;
        border: 1px solid #e5ecf2;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(23, 40, 63, 0.06);
        padding: 1.1rem 1rem;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .prospek-icon {
        width: 44px;
        height: 44px;
        background: #e8f4f8;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0;
        flex-shrink: 0;
    }

    .prospek-icon i {
        color: #0f6b82;
    }

    .prospek-title {
        font-size: 1.05rem;
        color: #1f2f42;
        font-weight: 700;
        margin: 0;
    }

    .products-section {
        padding: 3rem 0;
        background: #f8f9fa;
    }

    .product-card-link {
        text-decoration: none;
        display: block;
        height: 100%;
    }

    .product-display-card {
        background: #ffffff;
        border: 1px solid #e5ecf2;
        border-radius: 14px;
        overflow: hidden;
        height: 100%;
    }

    .product-display-image {
        height: 210px;
        background: #f1f4f8;
    }

    .product-display-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-display-icon-wrapper {
        padding: 1.2rem;
    }

    .product-display-icon {
        width: 58px;
        height: 58px;
        background: linear-gradient(135deg, #0d6675 0%, #0a4d5c 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-display-icon i {
        color: white;
        font-size: 1.4rem;
    }

    .product-display-content {
        padding: 1rem 1.2rem 1.2rem;
    }

    .product-display-title {
        margin: 0 0 0.5rem;
        color: #1f2f42;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .product-display-desc {
        color: #607489;
        font-size: 0.92rem;
        margin-bottom: 0.8rem;
    }

    .view-detail {
        color: #0d6675;
        font-weight: 700;
        font-size: 0.9rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    .tefa-contact-cta {
        padding: 0.5rem 0 2.8rem;
        background: linear-gradient(180deg, #f7fafd 0%, #ffffff 100%);
    }

    .tefa-contact-card {
        background: linear-gradient(135deg, #4f8fd8 0%, #4383cb 100%);
        border-radius: 18px;
        padding: 2.4rem 1.5rem;
        text-align: center;
        color: #fff;
    }

    .tefa-contact-card h2 {
        font-size: 2.1rem;
        font-weight: 800;
        margin-bottom: 0.35rem;
        color: #fff;
    }

    .tefa-contact-card p {
        margin-bottom: 1.3rem;
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.95);
    }

    .tefa-contact-actions {
        display: flex;
        gap: 0.8rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .contact-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.55rem;
        border-radius: 999px;
        padding: 0.72rem 1.5rem;
        font-weight: 700;
        text-decoration: none;
        border: 2px solid rgba(255, 255, 255, 0.95);
        transition: all 0.2s ease;
        min-width: 170px;
    }

    .contact-btn-whatsapp {
        background: #ffffff;
        color: #111827;
        border-color: #ffffff;
    }

    .contact-btn-whatsapp:hover {
        color: #111827;
        transform: translateY(-1px);
    }

    .contact-btn-outline {
        background: transparent;
        color: #ffffff;
    }

    .contact-btn-outline:hover {
        background: rgba(255, 255, 255, 0.14);
        color: #ffffff;
        transform: translateY(-1px);
    }

    @media (max-width: 991px) {
        .tefa-header-section {
            padding: 2.4rem 0 1.4rem;
        }

        .spotlight-slider {
            height: 310px;
        }

        .spotlight-slider .carousel-item img {
            height: 100%;
        }

        .featured-services-card {
            margin-top: 0.35rem;
        }
    }

    @media (max-width: 767px) {
        .tefa-main-title {
            font-size: 1.55rem;
        }

        .tefa-spotlight-section,
        .tefa-video-section,
        .all-services-section,
        .products-section,
        .visi-misi-section,
        .prospek-kerja-section {
            padding: 2.4rem 0;
        }

        .spotlight-about-card {
            margin-top: 0.85rem;
        }

        .spotlight-slider {
            height: 230px;
        }

        .tefa-main-description {
            font-size: 0.93rem;
        }

        .spotlight-slider .carousel-item img {
            height: 100%;
        }

        .spotlight-content {
            padding: 1rem 1rem 1.2rem;
        }

        .section-headline h2 {
            font-size: 1.3rem;
        }

        .all-service-media {
            height: 165px;
        }

        .tefa-contact-card {
            border-radius: 14px;
            padding: 2rem 1rem;
        }

        .tefa-contact-card h2 {
            font-size: 1.7rem;
        }

        .contact-btn {
            width: 100%;
            min-width: 0;
        }


    }
</style>
@endsection