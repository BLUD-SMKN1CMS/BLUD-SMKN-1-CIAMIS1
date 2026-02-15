@extends('layouts.app')

@section('title', 'FAQ - Pertanyaan Umum')

@section('content')
<!-- Hero Section -->
<section class="faq-hero py-5 mb-5" style="background: #4A90E2; color: white; position: relative; overflow: hidden;">
    <div class="container position-relative z-1 text-center py-5">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Pertanyaan Umum (FAQ)</h1>
        <p class="lead mb-0" data-aos="fade-up" data-aos-delay="100">Temukan jawaban atas pertanyaan Anda seputar layanan dan produk kami.</p>
    </div>
    <!-- Decorative Circle -->
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
</section>

<!-- Main Content -->
<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="accordion custom-accordion" id="faqAccordion">
                
                <!-- Kategori: Umum -->
                <div class="faq-category mb-4" data-aos="fade-up">
                    <h3 class="fw-bold text-primary mb-3"><i class="fas fa-info-circle me-2"></i>Umum</h3>
                    
                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Apa itu BLUD SMKN 1 Ciamis?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                BLUD SMKN 1 Ciamis adalah Badan Layanan Umum Daerah yang dikelola oleh SMKN 1 Ciamis. Kami menyediakan berbagai produk dan jasa hasil karya siswa (Teaching Factory) dengan standar industri dan harga kompetitif.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Dimana lokasi BLUD SMKN 1 Ciamis?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Kami berlokasi di Jl. Jend. Sudirman No. 269, Sindangrasa, Kec. Ciamis, Kab. Ciamis, Jawa Barat 46213. Silakan kunjungi kami pada jam kerja.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori: Pemesanan & Pembayaran -->
                <div class="faq-category mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h3 class="fw-bold text-primary mb-3"><i class="fas fa-shopping-cart me-2"></i>Pemesanan & Pembayaran</h3>
                    
                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Bagaimana cara memesan produk atau layanan?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Anda dapat memesan melalui website ini dengan memilih produk/layanan yang diinginkan, kemudian klik tombol "Pesan via WhatsApp". Anda akan diarahkan langsung ke admin kami untuk konfirmasi detail pesanan.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Metode pembayaran apa saja yang tersedia?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Saat ini kami menerima pembayaran melalui Transfer Bank (BCA, BRI, Mandiri), E-Wallet (GoPay, OVO, ShopeePay), dan Pembayaran Tunai (COD) khusus untuk wilayah sekitar Ciamis.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kategori: Pengiriman & Pengembalian -->
                <div class="faq-category mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h3 class="fw-bold text-primary mb-3"><i class="fas fa-truck me-2"></i>Pengiriman & Kebijakan</h3>
                    
                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Berapa lama proses pengiriman barang?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Untuk produk ready stock, pengiriman dilakukan H+1 setelah pembayaran terkonfirmasi. Estimasi sampai tergantung ekspedisi yang dipilih (JNE, J&T, SiCepat). Untuk produk pre-order, waktu pengerjaan akan diinfokan oleh admin.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingSix">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Apakah barang bisa dikembalikan (Retur)?
                            </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Kami menerima retur jika barang yang diterima rusak, cacat produksi, atau tidak sesuai pesanan. Wajib menyertakan video unboxing maksimal 1x24 jam setelah barang diterima. Biaya kirim retur ditanggung pembeli kecuali kesalahan dari pihak kami.
                            </div>
                        </div>
                    </div>
                </div>

                 <!-- Kategori: Layanan Sewa -->
                 <div class="faq-category mb-4" data-aos="fade-up" data-aos-delay="300">
                    <h3 class="fw-bold text-primary mb-3"><i class="fas fa-handshake me-2"></i>Syarat & Ketentuan Sewa</h3>
                    
                    <div class="accordion-item shadow-sm border-0 mb-3 rounded overflow-hidden">
                        <h2 class="accordion-header" id="headingSeven">
                            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                                Apa syarat menyewa fasilitas (Gedung/Alat)?
                            </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-muted">
                                Penyewa wajib menyerahkan identitas diri (KTP/SIM) asli sebagai jaminan. Pembayaran DP minimal 30% saat booking, dan pelunasan maksimal H-1 penggunaan. Kerusakan fasilitas akibat kelalaian penyewa menjadi tanggung jawab penyewa sepenuhnya.
                            </div>
                        </div>
                    </div>
                </div>

            </div>

             <!-- Contact CTA -->
             <div class="text-center mt-5" data-aos="zoom-in">
                <p class="lead mb-4">Masih punya pertanyaan lain?</p>
                <a href="{{ route('contact') }}" class="btn btn-whatsapp btn-lg px-5 py-3 rounded-pill fw-bold shadow">
                    <i class="fab fa-whatsapp me-2"></i>Hubungi Kami Langsung
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        background-color: #e7f1ff;
        color: #0d6efd;
        box-shadow: none;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .btn-whatsapp {
        background: #25D366;
        color: white;
        transition: transform 0.3s;
    }
    .btn-whatsapp:hover {
        transform: translateY(-3px);
        color: white;
    }
</style>
@endsection
