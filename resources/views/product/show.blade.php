@extends('layouts.app')

@section('title', $product->name . ' - ' . config('app.name'))

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-section">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.all') }}">Layanan</a></li>
                @if($product->tefa)
                <li class="breadcrumb-item"><a href="{{ route('tefa.show', $product->tefa->slug) }}">{{ $product->tefa->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<div class="product-detail-section">
    <div class="container">
        <div class="row g-5">
            <!-- Product Images -->
            <div class="col-lg-6">
                <div class="product-images">
                    @php
                    $images = [];
                    if($product->image) $images[] = $product->image_url;
                    if($product->image_2) $images[] = $product->image_2_url;
                    if($product->image_3) $images[] = $product->image_3_url;
                    if($product->image_4) $images[] = $product->image_4_url;
                    @endphp

                    <div class="main-image-wrapper">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="main-product-image" id="mainImage">
                    </div>

                    @if(count($images) > 1)
                    <div class="image-dots" id="imageDots">
                        @foreach($images as $key => $imgUrl)
                        <button type="button" class="image-dot {{ $key == 0 ? 'active' : '' }}" onclick="changeImageByIndex({{ $key }})" aria-label="Foto {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    @endif

                    <!-- Thumbnail Gallery -->
                    @if(count($images) > 1)
                    <div class="thumbnail-gallery">
                        @foreach($images as $key => $imgUrl)
                        <div class="thumbnail-item {{ $key == 0 ? 'active' : '' }}" onclick="changeImage(this, '{{ $imgUrl }}', {{ $key }})">
                            <img src="{{ $imgUrl }}" alt="{{ $product->name }}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Category & TEFA -->
                    <div class="product-meta">
                        @if($product->tefa)
                        <a href="{{ route('tefa.show', $product->tefa->slug) }}" class="tefa-badge">
                            <i class="fas fa-industry"></i> {{ $product->tefa->name }}
                        </a>
                        @endif
                        @if($product->category)
                        <span class="category-badge">
                            <i class="fas fa-tag"></i> {{ ucfirst($product->category) }}
                        </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="product-title">{{ $product->name }}</h1>

                    <!-- Description -->
                    <div class="product-description">
                        <h3>Deskripsi Layanan</h3>
                        <p>{{ $product->description ?? 'Layanan berkualitas dari ' . ($product->tefa->name ?? 'BLUD SMKN 1 CIAMIS') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Related Products Section -->
@if($relatedServices && $relatedServices->count() > 0)
<div class="related-products-section">
    <div class="container">
        <div class="section-header">
            <h2>Layanan Terkait</h2>
            <p>Layanan lainnya dari jurusan {{ $product->tefa->name ?? 'yang sama' }}</p>
        </div>

        <div class="row g-4">
            @foreach($relatedServices as $relatedService)
            <div class="col-md-6 col-lg-3">
                <a href="{{ $relatedService->url }}" class="product-card-link">
                    <div class="product-card">
                        <div class="product-card-image">
                            <img src="{{ $relatedService->image_url }}" alt="{{ $relatedService->name }}">
                            @if($relatedService->is_featured)
                            <div class="product-badge featured">Unggulan</div>
                            @endif
                        </div>
                        <div class="product-card-content">
                            <h3 class="product-card-title">{{ $relatedService->name }}</h3>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<style>
    /* Breadcrumb Section */
    .breadcrumb-section {
        background: var(--primary-blue);
        padding: 1.25rem 0;
        margin-bottom: 0;
        position: relative;
        overflow: hidden;
    }

    .breadcrumb-section::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.04);
        pointer-events: none;
    }

    .breadcrumb {
        background: transparent;
        margin: 0;
        padding: 0;
        position: relative;
        z-index: 1;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .breadcrumb-item a:hover {
        color: #fff;
    }

    .breadcrumb-item.active {
        color: #fff;
        font-weight: 600;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Product Detail Section */
    .product-detail-section {
        padding: 3.5rem 0 4rem;
        background: #f0f7ff;
    }

    /* Product Images */
    .product-images {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: column;
    }

    .main-image-wrapper {
        position: relative;
        background: #eef5fd;
        border-radius: 24px;
        overflow: hidden;
        border: 1px solid rgba(74, 144, 226, 0.2);
        box-shadow: 0 20px 45px rgba(30, 58, 138, 0.18);
        margin-bottom: 1rem;
        height: clamp(280px, 30vw, 400px);
    }

    .main-product-image {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease, opacity 0.2s ease;
    }

    .main-image-wrapper:hover .main-product-image {
        transform: scale(1.04);
    }

    .out-of-stock-badge,
    .low-stock-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 0.5rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }

    .out-of-stock-badge {
        background: rgba(220, 53, 69, 0.9);
        color: white;
    }

    .low-stock-badge {
        background: rgba(255, 193, 7, 0.9);
        color: #000;
    }

    .thumbnail-gallery {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 0.9rem;
        margin-top: 1rem;
    }

    .image-dots {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.45rem;
        margin: 0.1rem 0 0.75rem;
    }

    .image-dot {
        width: 9px;
        height: 9px;
        border: 0;
        border-radius: 999px;
        background: #c5d1df;
        padding: 0;
        transition: all 0.2s ease;
    }

    .image-dot.active {
        width: 20px;
        background: var(--primary-blue);
    }

    .thumbnail-item {
        width: 100%;
        height: 96px;
        border-radius: 12px;
        overflow: hidden;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(15, 23, 42, 0.1);
    }

    .thumbnail-item.active {
        border-color: var(--primary-blue);
    }

    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Product Info */
    .product-info {
        padding: 2rem;
        border-radius: 24px;
        border: 1px solid rgba(74, 144, 226, 0.18);
        background: rgba(255, 255, 255, 0.78);
        box-shadow: 0 14px 35px rgba(15, 23, 42, 0.1);
        backdrop-filter: blur(8px);
    }

    .product-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
    }

    .tefa-badge,
    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .tefa-badge {
        background: var(--primary-blue);
        color: white;
    }

    .tefa-badge:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(74, 144, 226, 0.4);
        color: white;
    }

    .category-badge {
        background: #eef5fd;
        color: var(--dark-blue);
        border: 1px solid #bfdbfe;
    }

    .product-title {
        font-size: clamp(2rem, 4vw, 3.25rem);
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.5rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .product-price {
        margin-bottom: 1.5rem;
    }

    .current-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-blue);
    }

    .stock-info {
        margin-bottom: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        display: inline-block;
    }

    .in-stock {
        color: #28a745;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .out-of-stock {
        color: #dc3545;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .stock-info i {
        margin-right: 0.5rem;
    }

    .product-description {
        margin-bottom: 0;
        padding: 1.5rem;
        border: 1px solid rgba(14, 165, 233, 0.22);
        border-radius: 16px;
        background: #ffffff;
    }

    .product-description h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .product-description p {
        color: #334155;
        line-height: 1.75;
        font-size: 1.04rem;
    }

    /* Product Features */
    .product-features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        padding: 2rem;
        background: #f8f9fa;
        border-radius: 15px;
    }

    .feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #495057;
        font-weight: 500;
    }

    .feature-item i {
        font-size: 1.5rem;
        color: #4A90E2;
    }

    /* Related Products Section */
    .related-products-section {
        padding: 5rem 0;
        background: #f0f7ff;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header h2 {
        font-size: clamp(2rem, 3.5vw, 2.9rem);
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .section-header p {
        color: #6c757d;
        font-size: 1.1rem;
    }

    /* Product Card */
    .product-card {
        background: white;
        border-radius: 18px;
        overflow: hidden;
        border: 1px solid rgba(148, 163, 184, 0.25);
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        transition: all 0.3s ease;
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 24px 40px rgba(30, 58, 138, 0.16);
        border-color: rgba(37, 99, 235, 0.3);
    }

    .product-card-image {
        position: relative;
        height: 250px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-card-image img {
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

    .product-card-content {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .product-card-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 0.75rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-card-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .product-card-footer {
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

    /* Responsive */
    @media (max-width: 991px) {
        .product-images {
            position: static;
            margin-bottom: 2rem;
        }

        .main-image-wrapper {
            height: 340px;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 2rem;
        }

        .current-price {
            font-size: 2rem;
        }
    }

    @media (max-width: 767px) {
        .main-image-wrapper {
            height: 240px;
        }

        .thumbnail-gallery {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .product-features {
            grid-template-columns: 1fr;
        }

        .section-header h2 {
            font-size: 2rem;
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

    .product-detail-section {
        animation: fadeInUp 0.6s ease;
    }
</style>

<script>
    function changeImage(element, src, index = null) {
        // Update main image
        const mainImage = document.getElementById('mainImage');
        mainImage.style.opacity = '0';

        setTimeout(() => {
            mainImage.src = src;
            mainImage.style.opacity = '1';
        }, 200);

        // Update active class
        document.querySelectorAll('.thumbnail-item').forEach(item => {
            item.classList.remove('active');
        });
        element.classList.add('active');

        if (index !== null) {
            document.querySelectorAll('.image-dot').forEach((dot, dotIndex) => {
                dot.classList.toggle('active', dotIndex === index);
            });
        }
    }

    function changeImageByIndex(index) {
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        const target = thumbnails[index];
        if (!target) return;

        const targetImage = target.querySelector('img');
        if (!targetImage) return;

        changeImage(target, targetImage.src, index);
    }
</script>
@endsection

