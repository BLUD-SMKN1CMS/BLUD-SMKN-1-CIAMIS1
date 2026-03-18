@extends('layouts.app')

@section('title', $tefa->name . ' - ' . config('app.name'))

@section('content')
<section class="tefa-header-section">
    <div class="container">
        <div class="tefa-header-badge">
            <i class="fas fa-bookmark me-2"></i>Detail Jurusan
        </div>
        <h1 class="tefa-main-title">{{ $tefa->name }}</h1>
        @if($tefa->description)
        <p class="tefa-main-description">{{ $tefa->description }}</p>
        @endif
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
        $sliderImages = collect([$tefa->banner_url, $tefa->logo_url])->unique()->values();
        @endphp
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-8">
                <div class="spotlight-main-card">
                    <div id="tefaVisualSlider" class="carousel slide spotlight-slider" data-bs-ride="carousel" data-bs-interval="5000">
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
        <h2 class="section-title">Produk Jurusan</h2>
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

<style>
    .tefa-header-section {
        padding: 3.2rem 0 2rem;
        background: radial-gradient(circle at top left, #eaf5ff 0%, #f7fbff 45%, #ffffff 100%);
        border-bottom: 1px solid #e6edf4;
    }

    .tefa-header-badge {
        display: inline-flex;
        align-items: center;
        font-size: 0.82rem;
        font-weight: 700;
        color: #0b5f75;
        background: #e8f4f8;
        border: 1px solid #d4eaef;
        border-radius: 999px;
        padding: 0.4rem 0.8rem;
        margin-bottom: 0.9rem;
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
        padding: 2.5rem 0;
        background: #ffffff;
    }

    .spotlight-main-card {
        background: #ffffff;
        border: 1px solid #e9eef3;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(17, 45, 74, 0.08);
        height: 100%;
    }

    .spotlight-slider .carousel-item img {
        width: 100%;
        height: 390px;
        object-fit: cover;
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
        padding: 2.8rem 0 4rem;
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

    .visi-misi-section {
        padding: 4rem 0;
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
        content: '•';
        position: absolute;
        left: 0;
        color: #0d6675;
        font-weight: bold;
    }

    .prospek-kerja-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, #0a4d5c 0%, #0d6675 100%);
    }

    .prospek-kerja-section .section-title {
        color: white;
    }

    .prospek-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        padding: 2rem;
        height: 100%;
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
        color: white;
    }

    .prospek-title {
        font-size: 1.05rem;
        color: white;
        margin: 0;
    }

    .products-section {
        padding: 4rem 0;
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

    @media (max-width: 991px) {
        .tefa-header-section {
            padding: 2.4rem 0 1.4rem;
        }

        .spotlight-slider .carousel-item img {
            height: 310px;
        }

        .featured-services-card {
            margin-top: 0.35rem;
        }
    }

    @media (max-width: 767px) {
        .tefa-main-title {
            font-size: 1.55rem;
        }

        .tefa-main-description {
            font-size: 0.93rem;
        }

        .spotlight-slider .carousel-item img {
            height: 230px;
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

        .products-section,
        .visi-misi-section,
        .prospek-kerja-section {
            padding: 3rem 0;
        }
    }
</style>
@endsection
