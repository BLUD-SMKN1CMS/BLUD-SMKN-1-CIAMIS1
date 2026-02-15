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
                    <a href="#booking-form" class="btn btn-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                        <i class="fas fa-calendar-check me-2"></i>Pesan Sekarang
                    </a>
                    <a href="#service-details" class="btn btn-outline-light btn-lg px-4 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                        <i class="fas fa-info-circle me-2"></i>Detail Layanan
                    </a>
                </div>
            </div>
            
            <div class="col-lg-4 text-center mt-4 mt-lg-0">
                <div class="service-badge" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); border-radius: 20px; padding: 30px; border: 2px solid rgba(255,255,255,0.2);">
                    <div class="badge-icon mb-3" style="font-size: 4rem;">
                        <i class="fas fa-{{ $service->unit == 'orang' ? 'users' : ($service->unit == 'bus' ? 'bus' : ($service->unit == 'lab' ? 'laptop' : 'box')) }}" style="color: white; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.2));"></i>
                    </div>
                    <h3 class="text-white mb-2">Kapasitas</h3>
                    <p class="h2 text-white fw-bold mb-0">{{ $service->capacity }} {{ ucfirst($service->unit) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Quick Info Cards -->
<section class="quick-info" style="margin-top: -40px; position: relative; z-index: 10;">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="info-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.1)';">
                    <div class="icon mb-3" style="width: 60px; height: 60px; background: #4A90E2; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-clock" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Harga Per Jam</h5>
                    <p class="h3 mb-0" style="color: #4A90E2; font-weight: 700;">Rp {{ number_format($service->price_per_hour, 0, ',', '.') }}</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="info-card" style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease, box-shadow 0.3s ease;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 50px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.1)';">
                    <div class="icon mb-3" style="width: 60px; height: 60px; background: #f5576c; border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar-day" style="font-size: 1.5rem; color: white;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Harga Per Hari</h5>
                    <p class="h3 mb-0" style="color: #f5576c; font-weight: 700;">Rp {{ number_format($service->price_per_day, 0, ',', '.') }}</p>
                </div>
            </div>
            
            <div class="col-md-4">
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
</section>

<!-- Service Details -->
<section id="service-details" class="py-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="service-content" style="background: white; border-radius: 20px; padding: 40px; box-shadow: 0 5px 30px rgba(0,0,0,0.08);">
                    <h2 class="fw-bold mb-4" style="color: #2d3748;">Deskripsi Layanan</h2>
                    <p style="font-size: 1.1rem; line-height: 1.8; color: #4a5568;">
                        {{ $service->description }}
                    </p>
                    
                    <hr class="my-5" style="opacity: 0.1;">
                    
                    <h3 class="fw-bold mb-4" style="color: #2d3748;">Fasilitas & Keunggulan</h3>
                    <div class="row g-3">
                        @php
                            $features = [
                                ['icon' => 'fa-shield-alt', 'title' => 'Aman & Terpercaya', 'desc' => 'Dijamin keamanan dan kualitasnya'],
                                ['icon' => 'fa-headset', 'title' => 'Dukungan 24/7', 'desc' => 'Tim support siap membantu kapan saja'],
                                ['icon' => 'fa-tools', 'title' => 'Perawatan Rutin', 'desc' => 'Fasilitas terawat dengan baik'],
                                ['icon' => 'fa-dollar-sign', 'title' => 'Harga Kompetitif', 'desc' => 'Harga terjangkau dan transparan'],
                                ['icon' => 'fa-clock', 'title' => 'Fleksibel', 'desc' => 'Waktu penyewaan yang fleksibel'],
                                ['icon' => 'fa-certificate', 'title' => 'Bersertifikat', 'desc' => 'Standar kualitas terjamin'],
                            ];
                        @endphp
                        
                        @foreach($features as $feature)
                        <div class="col-md-6">
                            <div class="feature-item d-flex align-items-start p-3" style="border-radius: 12px; transition: all 0.3s ease;" onmouseover="this.style.background='#f7fafc';" onmouseout="this.style.background='transparent';">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; background: #4A90E2; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas {{ $feature['icon'] }}" style="color: white; font-size: 1.2rem;"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1" style="color: #2d3748;">{{ $feature['title'] }}</h5>
                                    <p class="mb-0" style="color: #718096; font-size: 0.95rem;">{{ $feature['desc'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <hr class="my-5" style="opacity: 0.1;">
                    
                    <h3 class="fw-bold mb-4" style="color: #2d3748;">Syarat & Ketentuan</h3>
                    <ul class="list-unstyled" style="font-size: 1.05rem; color: #4a5568;">
                        <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> Melakukan pemesanan minimal 3 hari sebelumnya</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> Membayar DP minimal 30% dari total biaya</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> Menyertakan identitas diri yang valid (KTP/SIM)</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> Bertanggung jawab atas kerusakan yang terjadi</li>
                        <li class="mb-3"><i class="fas fa-check-circle me-2" style="color: #48bb78;"></i> Mengembalikan fasilitas sesuai waktu yang disepakati</li>
                    </ul>
                </div>
            </div>
            
            <!-- Booking Form Sidebar -->
            <div class="col-lg-4">
                <div id="booking-form" class="booking-sidebar" style="background: white; border-radius: 20px; padding: 30px; box-shadow: 0 5px 30px rgba(0,0,0,0.08); position: sticky; top: 100px;">
                    <h4 class="fw-bold mb-4" style="color: #2d3748;">Formulir Pemesanan</h4>
                    
                    <form id="bookingForm">
                        <input type="hidden" id="serviceName" value="{{ $service->name }}">
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Nama Lengkap</label>
                            <input type="text" name="customer_name" class="form-control" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;" placeholder="Masukkan nama lengkap">
                        </div>
                        

                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">No. Telepon</label>
                            <input type="tel" name="customer_phone" class="form-control" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;" placeholder="08xxxxxxxxxx">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Jenis Sewa</label>
                            <select name="rental_type" id="rentalType" class="form-select" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;">
                                <option value="Harian">Harian</option>
                                <option value="Bulanan">Bulanan</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Tanggal Sewa</label>
                            <input type="date" name="rental_date" class="form-control" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;" min="{{ date('Y-m-d', strtotime('+3 days')) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Tanggal Kembali</label>
                            <input type="date" name="return_date" class="form-control" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;" min="{{ date('Y-m-d', strtotime('+4 days')) }}">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Metode Pembayaran</label>
                                <select name="payment_method" id="paymentMethod" class="form-select" required style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;">
                                    <option value="cash" selected>💵 Tunai</option>
                                </select>
                        </div>
                        

                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold" style="color: #4a5568;">Catatan (Opsional)</label>
                            <textarea name="notes" class="form-control" rows="3" style="border-radius: 10px; padding: 12px; border: 2px solid #e2e8f0;" placeholder="Tambahkan catatan jika ada"></textarea>
                        </div>
                        
                        <button type="button" onclick="sendToWhatsapp(event)" class="btn btn-success w-100 py-3" style="background: #25D366; border: none; border-radius: 12px; font-weight: 600; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);">
                             <i class="fab fa-whatsapp me-2"></i>Pesan via WhatsApp
                        </button>
                        
                        <p class="text-center mt-3 mb-0" style="font-size: 0.85rem; color: #a0aec0;">
                            <i class="fas fa-check-circle me-1"></i> Anda akan diarahkan ke WhatsApp Admin
                        </p>
                    </form>
                </div>
            </div>
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
                        <i class="fas fa-{{ $relatedService->unit == 'orang' ? 'users' : ($relatedService->unit == 'bus' ? 'bus' : ($relatedService->unit == 'lab' ? 'laptop' : 'box')) }}" style="font-size: 4rem; color: white; opacity: 0.9;"></i>
                    </div>
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-2" style="color: #2d3748;">{{ $relatedService->name }}</h5>
                        <p class="text-muted mb-3" style="font-size: 0.95rem;">{{ Str::limit($relatedService->description, 80) }}</p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <small class="text-muted d-block">Mulai dari</small>
                                <strong style="color: #4A90E2; font-size: 1.2rem;">Rp {{ number_format($relatedService->price_per_hour, 0, ',', '.') }}</strong>
                                <small class="text-muted">/jam</small>
                            </div>
                        </div>
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

<script>
function sendToWhatsapp(e) {
    e.preventDefault();
    
    // Ambil data dari form
    const serviceName = document.getElementById('serviceName').value;
    const name = document.querySelector('input[name="customer_name"]').value;

    const phone = document.querySelector('input[name="customer_phone"]').value;
    const rentalType = document.getElementById('rentalType').value;
    const rentalDate = document.querySelector('input[name="rental_date"]').value;
    const returnDate = document.querySelector('input[name="return_date"]').value;
    const notes = document.querySelector('textarea[name="notes"]').value; // Opsional
    
    // Format tanggal agar lebih mudah dibaca (DD-MM-YYYY)
    const formatDate = (dateStr) => {
        const date = new Date(dateStr);
        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    };

    // Buat pesan WhatsApp
    let message = `*Halo Admin BLUD SMKN 1 Ciamis* 👋\n\n`;
    message += `Saya ingin memesan layanan berikut:\n`;
    message += `🏫 *Layanan:* ${serviceName}\n\n`;
    message += `📋 *Data Pemesan:*\n`;
    message += `👤 Nama: ${name}\n`;
    message += `📱 No. HP: ${phone}\n\n`;
    message += `📅 *Detail Sewa:*\n`;
    message += `Jenis: ${rentalType}\n`;
    message += `Mulai: ${formatDate(rentalDate)}\n`;
    message += `Selesai: ${formatDate(returnDate)}\n`;
    message += `💰 Metode Bayar: Tunai\n`;
    
    if(notes) {
        message += `📝 Catatan: ${notes}\n`;
    }
    
    message += `\nMohon informasi ketersediaan dan total biayanya. Terima kasih!`;

    // Encode pesan untuk URL
    const encodedMessage = encodeURIComponent(message);
    
    // Nomor WhatsApp Admin (Sesuai Request: 0877-9098-4032)
    const adminPhone = "6287790984032";
    
    // Buka WhatsApp di tab baru
    window.open(`https://wa.me/${adminPhone}?text=${encodedMessage}`, '_blank');
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

