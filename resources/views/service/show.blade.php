@extends('layouts.app')

@section('title', $service->name . ' - BLUD SMKN 1 CIAMIS')

@section('content')
<!-- Hero Section -->
<section class="service-hero" style="background: #4A90E2; padding: 100px 0 60px; position: relative; overflow: hidden;">
    <div class="hero-pattern" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="container" style="position: relative; z-index: 1;">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border-radius: 50px; padding: 12px 24px;">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: white; text-decoration: none;">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('services.all') }}" style="color: white; text-decoration: none;">Layanan</a></li>
                        <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">{{ $service->name }}</li>
                    </ol>
                </nav>

                <h1 class="display-4 fw-bold text-white mb-3" style="text-shadow: 0 2px 20px rgba(0,0,0,0.2);">
                    {{ $service->name }}
                </h1>
                <p class="lead text-white mb-4" style="opacity: 0.95; font-size: 1.2rem;">
                    {{ Str::limit($service->description, 150) }}
                </p>

                <div class="d-flex gap-3 flex-wrap">
                    <a href="#service-details" class="btn btn-outline-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                        <i class="fas fa-info-circle me-2"></i>Detail Layanan
                    </a>
                </div>
            </div>

            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="service-badge" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; border: 2px solid rgba(255,255,255,0.2);">
                    <div class="badge-icon mb-3" style="font-size: 4rem;">
                        <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }}" style="color: white; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2));"></i>
                    </div>
                    <h3 class="text-white mb-2">{{ $service->name }}</h3>
                    <p class="h5 text-white mb-0">Layanan {{ $service->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Info Cards
<section class="quick-info" style="margin-top: -40px; position: relative; z-index: 10;">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-6">
                <div class="info-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.1)';">
                    <div class="icon mb-3" style="width: 60px; height: 60px; background: #00f2fe; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check-circle" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Status</h5>
                    <p class="h3 mb-0" style="color: #00f2fe; font-weight: 700; text-transform: capitalize;">{{ $service->status == 'available' ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                </div>
            </div>
        </div>
    </div>
</section> -->

<!-- Service Details -->
<section id="service-details" class="py-5 mt-5">
    <div class="container">
        @php
            $servicePhotoUrls = collect();

            if (!empty($service->image)) {
                $servicePhotoUrls->push(asset('storage/' . ltrim($service->image, '/')));
            }

            $servicePhotoUrls = $servicePhotoUrls
                ->concat(collect($service->gallery_image_urls ?? []))
                ->filter(fn($url) => is_string($url) && trim($url) !== '')
                ->unique()
                ->values();

            $hasSidebarMedia = $servicePhotoUrls->isNotEmpty() || !empty($service->panorama_image_url);
        @endphp
        <div class="row g-4">
            <div class="col-lg-{{ $hasSidebarMedia ? '8' : '12' }}">
                <div class="service-content" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 5px 30px rgba(0,0,0,0.08);">
                    <h2 class="fw-bold mb-4" style="color: #2d3748;">Deskripsi Layanan</h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: #4a5568;">
                        {{ $service->description }}
                    </p>

                    <hr class="my-5" style="opacity: 0.1;">

                    <h3 class="fw-bold mb-4" style="color: #2d3748;">Fasilitas & Keunggulan</h3>
                    <div class="row g-3">
                        @php
                        $featureLines = collect(preg_split('/\r\n|\r|\n/', (string) $service->facilities))
                            ->map(fn($line) => trim($line))
                            ->filter()
                            ->values();

                        $defaultFeatures = collect([
                            ['title' => 'Aman & Terpercaya', 'desc' => 'Dijamin keamanan dan kualitasnya'],
                            ['title' => 'Dukungan 24/7', 'desc' => 'Tim support siap membantu kapan saja'],
                            ['title' => 'Perawatan Rutin', 'desc' => 'Fasilitas terawat dengan baik'],
                        ]);

                        $parsedFeatures = $featureLines->map(function ($line) {
                            $parts = array_map('trim', explode('|', $line, 2));
                            return [
                                'title' => $parts[0] ?? $line,
                                'desc' => $parts[1] ?? '',
                            ];
                        });

                        $features = $parsedFeatures->isNotEmpty() ? $parsedFeatures : $defaultFeatures;
                        @endphp

                        @foreach($features as $feature)
                        <div class="col-md-6">
                            <div class="feature-item d-flex align-items-start p-3" style="border-radius: 12px; transition: all 0.3s ease;" onmouseover="this.style.background='#f7fafc';" onmouseout="this.style.background='transparent';">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; background: #4A90E2; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-check" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: #2d3748;">{{ $feature['title'] }}</h5>
                                    @if(!empty($feature['desc']))
                                        <p class="mb-0" style="color: #718096; font-size: 0.95rem;">{{ $feature['desc'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <hr class="my-5" style="opacity: 0.1;">

                    <h3 class="fw-bold mb-4" style="color: #2d3748;">Syarat & Ketentuan</h3>
                    @php
                    $terms = collect(preg_split('/\r\n|\r|\n/', (string) $service->terms_conditions))
                        ->map(fn($line) => trim($line))
                        ->filter()
                        ->values();

                    if ($terms->isEmpty()) {
                        $terms = collect([
                            'Melakukan pemesanan minimal 3 hari sebelumnya',
                            'Membayar DP minimal 30% dari total biaya',
                            'Menyertakan identitas diri yang valid (KTP/SIM)',
                        ]);
                    }
                    @endphp
                    <ul class="list-unstyled" style="font-size: 1.05rem; color: #4a5568;">
                        @foreach($terms as $term)
                            <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> {{ $term }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            @if($hasSidebarMedia)
            <div class="col-lg-4">
                <div class="service-content" style="background: white; border-radius: 20px; padding: 20px; box-shadow: 0 5px 30px rgba(0,0,0,0.08); position: sticky; top: 100px;">
                    @if($servicePhotoUrls->isNotEmpty())
                        <h3 class="fw-bold mb-3" style="color: #2d3748;">Foto Layanan</h3>
                        @if($servicePhotoUrls->count() > 1)
                            <div id="servicePhotoCarousel" class="carousel slide {{ $service->panorama_image_url ? 'mb-4' : 'mb-0' }}" data-bs-ride="false" data-bs-interval="false">
                                <div class="carousel-indicators mb-0">
                                    @foreach($servicePhotoUrls as $index => $servicePhotoUrl)
                                        <button type="button" data-bs-target="#servicePhotoCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>

                                <div class="carousel-inner rounded" style="border: 1px solid #e2e8f0; border-radius: 12px; height: 220px;">
                                    @foreach($servicePhotoUrls as $index => $servicePhotoUrl)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" style="height: 220px;">
                                            <img src="{{ $servicePhotoUrl }}" alt="Foto layanan {{ $service->name }}" style="width: 100%; height: 220px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#servicePhotoCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#servicePhotoCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        @else
                            <div class="{{ $service->panorama_image_url ? 'mb-4' : 'mb-0' }}">
                                <img src="{{ $servicePhotoUrls->first() }}" alt="Foto layanan {{ $service->name }}" style="width: 100%; height: 220px; border-radius: 12px; object-fit: cover; border: 1px solid #e2e8f0;">
                            </div>
                        @endif
                    @endif

                    @if($service->panorama_image_url)
                        <h3 class="fw-bold mb-3" style="color: #2d3748;">Foto 360 Derajat</h3>
                        <div id="panorama-viewer" style="width: 100%; height: 360px; border-radius: 14px; overflow: hidden;"></div>
                        <p class="small text-muted mt-3 mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Geser gambar untuk melihat sudut 360°.
                        </p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<!-- Related Services -->
@if($footerServices && $footerServices->count() > 0)
<section class="related-services py-5" style="background: #f7fafc;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #2d3748;">Layanan Lainnya</h2>
            <p class="text-muted">Jelajahi layanan sewa lainnya yang tersedia</p>
        </div>

        <div class="row g-4">
            @foreach($footerServices->where('id', '!=', $service->id)->take(3) as $relatedService)
            <div class="col-md-4">
                <div class="service-card" style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.08)';">
                    <div class="card-image" style="height: 200px; background: #4A90E2; display: flex; align-items: center; justify-content: center;">
                        <i class="{{ $relatedService->icon ?? 'fas fa-concierge-bell' }}" style="font-size: 4rem; color: white; opacity: 0.9;"></i>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2" style="color: #2d3748;">{{ $relatedService->name }}</h5>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">{{ Str::limit($relatedService->description, 80) }}</p>
                        <a href="{{ route('service.show', $relatedService->slug) }}" class="btn btn-outline-primary w-100" style="border-radius: 10px; font-weight: 600;">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Contact CTA -->
<section class="contact-cta py-5" style="background: #4A90E2;">
    <div class="container text-center">
        <h2 class="text-white fw-bold mb-3">Ada Pertanyaan?</h2>
        <p class="text-white mb-4" style="opacity: 0.9; font-size: 1.1rem;">Tim kami siap membantu Anda dengan senang hati</p>
        <div class="d-flex gap-3 justify-content-center flex-wrap">
            <a href="https://wa.me/6287790984032" class="btn btn-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600;">
                <i class="fab fa-whatsapp me-2"></i>WhatsApp
            </a>
            <a href="tel:{{ $contactInfo['company_phone'] }}" class="btn btn-outline-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                <i class="fas fa-phone me-2"></i>Telepon
            </a>
            <a href="mailto:{{ $contactInfo['company_email'] }}" class="btn btn-outline-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                <i class="fas fa-envelope me-2"></i>Email
            </a>
        </div>
    </div>
</section>

@if($service->panorama_image_url)
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize panorama viewer using uploaded 360 image.
        const viewerContainer = document.getElementById('panorama-viewer');
        if (viewerContainer && window.pannellum) {
            try {
                pannellum.viewer('panorama-viewer', {
                    type: 'equirectangular',
                    panorama: "{{ $service->panorama_image_url }}",
                    autoLoad: true,
                    showZoomCtrl: true,
                    showFullscreenCtrl: true,
                    compass: false,
                    hfov: 110,
                });
            } catch (error) {
                viewerContainer.innerHTML = `<img src="{{ $service->panorama_image_url }}" alt="Foto 360" style="width:100%;height:100%;object-fit:cover;">`;
            }
        } else if (viewerContainer) {
            viewerContainer.innerHTML = `<img src="{{ $service->panorama_image_url }}" alt="Foto 360" style="width:100%;height:100%;object-fit:cover;">`;
        }
    });
</script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const panoramaHint = document.querySelector('#panorama-viewer')?.nextElementSibling;
        if (panoramaHint && !window.pannellum) {
            panoramaHint.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Viewer 360 tidak termuat, menampilkan gambar biasa.';
        }
    });
</script>

<script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
</script>

@endsection
