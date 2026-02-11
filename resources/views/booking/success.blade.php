@extends('layouts.app')

@section('title', 'Pemesanan Berhasil - BLUD SMKN 1 CIAMIS')

@section('content')
<section class="success-page" style="min-height: 80vh; display: flex; align-items: center; background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); position: relative; overflow: hidden;">
    <div class="pattern" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1; background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Success Card -->
                <div class="success-card" style="background: white; border-radius: 30px; padding: 60px 40px; box-shadow: 0 20px 60px rgba(0,0,0,0.3); text-align: center;">
                    <!-- Success Icon Animation -->
                    <div class="success-icon mb-4" style="animation: scaleIn 0.5s ease-out;">
                        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(72, 187, 120, 0.4);">
                            <i class="fas fa-check" style="font-size: 4rem; color: white;"></i>
                        </div>
                    </div>
                    
                    <h1 class="fw-bold mb-3" style="color: #2d3748; font-size: 2.5rem;">Pemesanan Berhasil!</h1>
                    <p class="lead mb-4" style="color: #718096; font-size: 1.2rem;">
                        Terima kasih atas pemesanan Anda. Kami telah menerima permintaan Anda.
                    </p>
                    
                    <!-- Transaction Info -->
                    <div class="transaction-info" style="background: #f7fafc; border-radius: 20px; padding: 30px; margin: 30px 0; text-align: left;">
                        <h4 class="fw-bold mb-4" style="color: #2d3748; text-align: center;">Detail Transaksi</h4>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">ID Transaksi</span>
                                <strong style="color: #2d3748; font-size: 1.1rem;">{{ $payment->transaction_id }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">Nama Pemesan</span>
                                <strong style="color: #2d3748;">{{ $payment->rentalService->customer_name }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">Layanan</span>
                                <strong style="color: #2d3748;">{{ $payment->rentalService->service_type }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">Tanggal Sewa</span>
                                <strong style="color: #2d3748;">{{ \Carbon\Carbon::parse($payment->rentalService->rental_date)->format('d F Y') }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">Tanggal Kembali</span>
                                <strong style="color: #2d3748;">{{ \Carbon\Carbon::parse($payment->rentalService->return_date)->format('d F Y') }}</strong>
                            </div>
                        </div>
                        
                        <div class="info-row mb-3 pb-3" style="border-bottom: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500;">Metode Pembayaran</span>
                                <strong style="color: #2d3748; text-transform: capitalize;">
                                    @if($payment->payment_method == 'e-wallet')
                                        E-Wallet ({{ $payment->ewallet_type }})
                                    @else
                                        {{ $payment->payment_method == 'cash' ? 'Tunai' : 'Transfer Bank' }}
                                    @endif
                                </strong>
                            </div>
                        </div>
                        
                        <div class="info-row">
                            <div class="d-flex justify-content-between align-items-center">
                                <span style="color: #718096; font-weight: 500; font-size: 1.1rem;">Total Pembayaran</span>
                                <strong style="color: #4A90E2; font-size: 1.5rem;">Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Payment Instructions -->
                    <div class="payment-instructions" style="background: #fff5f5; border-left: 4px solid #f56565; border-radius: 12px; padding: 20px; margin: 30px 0; text-align: left;">
                        <h5 class="fw-bold mb-3" style="color: #c53030;">
                            <i class="fas fa-exclamation-circle me-2"></i>Instruksi Pembayaran
                        </h5>
                        <ul style="color: #742a2a; margin: 0; padding-left: 20px;">
                            <li class="mb-2">Silakan lakukan pembayaran sesuai metode yang dipilih</li>
                            <li class="mb-2">Simpan ID Transaksi untuk referensi pembayaran</li>
                            <li class="mb-2">Kami akan menghubungi Anda untuk konfirmasi lebih lanjut</li>
                            <li class="mb-2">Pembayaran DP minimal 30% dari total biaya</li>
                        </ul>
                    </div>
                    
                    @if($payment->payment_method == 'transfer')
                    <div class="bank-info" style="background: #ebf8ff; border-left: 4px solid #4299e1; border-radius: 12px; padding: 20px; margin: 30px 0; text-align: left;">
                        <h5 class="fw-bold mb-3" style="color: #2c5282;">
                            <i class="fas fa-university me-2"></i>Informasi Rekening
                        </h5>
                        <div class="mb-2">
                            <strong style="color: #2d3748;">Bank BRI</strong><br>
                            <span style="color: #4a5568;">No. Rek: 1234-5678-9012-3456</span><br>
                            <span style="color: #4a5568;">A.n. BLUD SMKN 1 CIAMIS</span>
                        </div>
                    </div>
                    @endif
                    
                    @if($payment->payment_method == 'e-wallet')
                    <div class="ewallet-info" style="background: #f0fff4; border-left: 4px solid #48bb78; border-radius: 12px; padding: 20px; margin: 30px 0; text-align: left;">
                        <h5 class="fw-bold mb-3" style="color: #22543d;">
                            <i class="fas fa-mobile-alt me-2"></i>Informasi E-Wallet
                        </h5>
                        <div class="mb-2">
                            <strong style="color: #2d3748;">{{ $payment->ewallet_type }}</strong><br>
                            <span style="color: #4a5568;">No: 0812-3456-7890</span><br>
                            <span style="color: #4a5568;">A.n. BLUD SMKN 1 CIAMIS</span>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons mt-4 d-flex gap-3 justify-content-center flex-wrap">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg px-5 py-3" style="border-radius: 50px; font-weight: 600; border-width: 2px;">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('services.all') }}" class="btn btn-primary btn-lg px-5 py-3" style="background: linear-gradient(135deg, #4A90E2 0%, #357ABD 100%); border: none; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                            <i class="fas fa-list me-2"></i>Lihat Layanan Lain
                        </a>
                    </div>
                    
                    <!-- Contact Support -->
                    <div class="contact-support mt-5 pt-4" style="border-top: 2px solid #e2e8f0;">
                        <p class="mb-3" style="color: #718096;">Butuh bantuan? Hubungi kami:</p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="https://wa.me/6281234567890" class="btn btn-success" style="border-radius: 50px; padding: 10px 20px;">
                                <i class="fab fa-whatsapp me-2"></i>WhatsApp
                            </a>
                            <a href="tel:(0265)123456" class="btn btn-info" style="border-radius: 50px; padding: 10px 20px;">
                                <i class="fas fa-phone me-2"></i>Telepon
                            </a>
                            <a href="mailto:blud@smkn1ciamis.sch.id" class="btn btn-secondary" style="border-radius: 50px; padding: 10px 20px;">
                                <i class="fas fa-envelope me-2"></i>Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes scaleIn {
    from {
        transform: scale(0);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.success-icon {
    animation: scaleIn 0.5s ease-out;
}
</style>

@endsection

