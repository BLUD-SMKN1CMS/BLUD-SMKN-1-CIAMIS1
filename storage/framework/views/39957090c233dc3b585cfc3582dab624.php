<?php $__env->startSection('title', 'Beranda - BLUD SMKN 1 CIAMIS'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Carousel -->
<section class="hero-section position-relative fade-in">
    <div class="container position-relative">
        <!-- CAROUSEL DARI DATABASE -->
        <?php if($carousels->count() > 0): ?>
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <?php $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button type="button" data-bs-target="#heroCarousel" 
                                data-bs-slide-to="<?php echo e($key); ?>" 
                                class="<?php echo e($key == 0 ? 'active' : ''); ?>"
                                aria-current="<?php echo e($key == 0 ? 'true' : 'false'); ?>"
                                aria-label="Slide <?php echo e($key + 1); ?>"></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="carousel-inner">
                    <?php $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="carousel-item <?php echo e($key == 0 ? 'active' : ''); ?>">
                            <?php if($item->image): ?>
                                <img src="<?php echo e(asset('storage/' . $item->image)); ?>" 
                                     class="d-block w-100" 
                                     alt="<?php echo e($item->title); ?>" 
                                     loading="lazy" 
                                     style="height: 60vh; object-fit: cover;">
                            <?php else: ?>
                                <!-- Fallback jika tidak ada gambar -->
                                <div class="d-block w-100 bg-primary" style="height: 60vh; display: flex; align-items: center; justify-content: center;">
                                    <div class="text-white text-center">
                                        <i class="fas fa-image fa-4x mb-3"></i>
                                        <h3><?php echo e($item->title); ?></h3>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Caption hanya untuk desktop -->
                            <?php if($item->title || $item->description): ?>
                            <div class="carousel-caption d-none d-md-block">
                                <?php if($item->title): ?>
                                <h2 class="h3 fw-bold text-white mb-2"><?php echo e($item->title); ?></h2>
                                <?php endif; ?>
                                
                                <?php if($item->description): ?>
                                <p class="small text-light mb-3 opacity-90"><?php echo e(Str::limit($item->description, 100)); ?></p>
                                <?php endif; ?>
                                
                                <?php if($item->button_text && $item->button_url): ?>
                                <a href="<?php echo e($item->button_url); ?>" class="btn btn-primary btn-sm px-3 py-2">
                                    <i class="fas fa-arrow-right me-2"></i> <?php echo e($item->button_text); ?>

                                </a>
                                <?php else: ?>
                                <a href="#produk-section" class="btn btn-primary btn-sm px-3 py-2">
                                    <i class="fas fa-shopping-bag me-2"></i> Lihat Produk
                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <?php if($carousels->count() > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                <?php endif; ?>
                
                <!-- Badge info rasio carousel -->
                <div class="position-absolute bottom-0 end-0 m-3">
                    <span class="badge bg-dark bg-opacity-50 px-2 py-1" style="font-size: 0.7rem;">
                        <i class="fas fa-info-circle me-1"></i> Rasio: 16:9
                    </span>
                </div>
            </div>
        <?php else: ?>
            <!-- Fallback jika tidak ada carousel di database -->
            <div class="text-center py-5" style="background: linear-gradient(135deg, #E3F2FD 0%, #87CEEB 100%); border-radius: 20px;">
                <img src="<?php echo e(asset('assets/teachingfactorysmea.png')); ?>" 
                     alt="TEFA SMKN 1 Ciamis" 
                     class="img-fluid mb-4"
                     style="max-height: 300px;">
                <h1 class="display-5 fw-bold text-primary">Selamat Datang di BLUD SMKN 1 Ciamis</h1>
                <p class="lead">Teaching Factory untuk mengasah keterampilan siswa</p>
                <a href="#tefa-section" class="btn btn-primary btn-lg mt-3">
                    <i class="fas fa-arrow-down me-2"></i> Jelajahi TEFA
                </a>
            </div>
        <?php endif; ?>
        
        <!-- Hero Stats - DINAMIS DARI DATABASE! -->
        <div class="row mt-5 pt-3 justify-content-center" data-aos="fade-up" data-aos-delay="300">
            <div class="col-md-10">
                <div class="row text-center">
                    <!-- TEFA Jurusan -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card p-3 bg-white rounded-3 shadow-sm">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?php echo e($stats['total_tefas'] ?? 0); ?></h3>
                            <p class="text-muted mb-0">TEFA Jurusan</p>
                        </div>
                    </div>
                    
                    <!-- Total Produk -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card p-3 bg-white rounded-3 shadow-sm">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-box-open fa-2x text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?php echo e($stats['total_products'] ?? 0); ?>+</h3>
                            <p class="text-muted mb-0">Produk</p>
                        </div>
                    </div>
                    
                    <!-- Layanan Sewa -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card p-3 bg-white rounded-3 shadow-sm">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-handshake fa-2x text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?php echo e($stats['total_services'] ?? 0); ?></h3>
                            <p class="text-muted mb-0">Layanan Sewa</p>
                        </div>
                    </div>
                    
                    <!-- Siswa -->
                    <div class="col-md-3 mb-4">
                        <div class="stat-card p-3 bg-white rounded-3 shadow-sm">
                            <div class="stat-icon mb-2">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <h3 class="fw-bold mb-1"><?php echo e($stats['total_students'] ?? 0); ?>+</h3>
                            <p class="text-muted mb-0">Siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- TEFA Section -->
    <section id="tefa-section" class="py-5" data-aos="fade-up">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold text-primary mb-3">Teaching Factory (TEFA)</h2>
                    <p class="lead text-muted">7 Jurusan Unggulan SMKN 1 Ciamis</p>
                    <div class="section-title"></div>
                </div>
            </div>
            
            <div class="row g-4">
                <?php $__currentLoopData = $tefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                        <a href="<?php echo e(route('tefa.show', $tefa->slug)); ?>" class="text-decoration-none">
                            <div class="tefa-card p-4 text-center h-100">
                                <div class="tefa-icon">
                                    <i class="fas fa-<?php echo e($tefa->code == 'AKL' ? 'calculator' : ($tefa->code == 'PM' ? 'chart-line' : ($tefa->code == 'MPLB' ? 'building' : ($tefa->code == 'HOTEL' ? 'hotel' : ($tefa->code == 'KULINER' ? 'utensils' : ($tefa->code == 'DKV' ? 'palette' : 'code')))))); ?>"></i>
                                </div>
                                <h4 class="fw-bold mb-2"><?php echo e($tefa->name); ?></h4>
                                <p class="text-muted small"><?php echo e(Str::limit($tefa->description, 80)); ?></p>
                                <div class="mt-3">
                                    <span class="badge bg-primary"><?php echo e($tefa->products_count ?? 0); ?> Produk</span>
                                    <span class="badge bg-success ms-1"><?php echo e($tefa->code); ?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <div class="col-12 text-center mt-5" data-aos="fade-up" data-aos-delay="300">
                <a href="<?php echo e(route('tefa.all')); ?>" class="btn btn-primary btn-lg px-5 py-3">
                    <i class="fas fa-eye me-2"></i> Lihat Semua TEFA
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="produk-section" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold text-primary mb-3">Produk Unggulan</h2>
                    <p class="lead text-muted">Hasil karya siswa yang kreatif dan inovatif</p>
                    <div class="section-title"></div>
                </div>
            </div>
            
            <!-- ======= Featured Products Section ======= -->
<section id="featured-products" class="featured-products">
    <div class="container">
        <div class="row">
            <!-- PRODUK UNGGULAN BARU -->
            <?php $__currentLoopData = $featuredProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-3 col-sm-6" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 50); ?>">
                <div class="product-card card shadow-sm h-100">
                    <div class="position-relative overflow-hidden">
                        <img src="<?php echo e($product->image_url); ?>" 
                             class="card-img-top product-img" 
                             alt="<?php echo e($product->name); ?>" 
                             loading="lazy" 
                             style="height: 200px; object-fit: cover;"
                             onerror="this.src='https://via.placeholder.com/300x200/4A90E2/FFFFFF?text=<?php echo e(urlencode(substr($product->name, 0, 20))); ?>'">
                        
                        <span class="position-absolute top-0 end-0 m-2 badge bg-success">
                            <?php echo e($product->tefa->code ?? 'TEFA'); ?>

                        </span>
                        <?php if($product->is_featured): ?>
                            <span class="position-absolute top-0 start-0 m-2 badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i> Unggulan
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo e($product->name); ?></h5>
                        <p class="card-text flex-grow-1 small text-muted">
                            <?php echo e(Str::limit($product->description, 60)); ?>

                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="fw-bold text-primary">
                                Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                            </span>
                            <a href="<?php echo e(route('product.show', $product->slug)); ?>" 
                               class="btn btn-sm btn-outline-primary">
                                Detail <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

    <!-- Rental Services -->
<section id="layanan-section" class="py-5" data-aos="fade-up">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="display-5 fw-bold text-primary mb-3">Layanan Penyewaan</h2>
                <p class="lead text-muted">Fasilitas yang dapat disewa oleh masyarakat umum</p>
                <div class="section-title"></div>
            </div>
        </div>
        
        <div class="row g-4 justify-content-center">
            <?php if($services->count() > 0): ?>
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo e($loop->index * 100); ?>">
                        <div class="card border-0 shadow-sm h-100 service-card">
                            <div class="card-body text-center p-4">
                                <div class="service-icon-wrapper mb-3">
                                    <i class="fas fa-<?php echo e($service->name == 'Air Minum' ? 'tint' : ($service->name == 'Gedung Serbaguna' ? 'building' : 'bus')); ?> fa-3x service-icon"></i>
                                </div>
                                <h4 class="card-title fw-bold"><?php echo e($service->name); ?></h4>
                                <p class="card-text text-muted"><?php echo e($service->description ?? 'Layanan penyewaan ' . $service->name); ?></p>
                                
                                <?php if($service->unit == 'galon'): ?>
                                    <h5 class="text-success fw-bold mb-3">
                                        Rp <?php echo e(number_format($service->price_per_day, 0, ',', '.')); ?>

                                        <small class="text-muted">/<?php echo e($service->unit); ?></small>
                                    </h5>
                                <?php else: ?>
                                    <h5 class="text-success fw-bold mb-3">
                                        Rp <?php echo e(number_format($service->price_per_day, 0, ',', '.')); ?>

                                        <small class="text-muted">/hari</small>
                                    </h5>
                                <?php endif; ?>
                                
                                <div class="mt-3">
                                    <a href="<?php echo e(route('service.show', $service->slug)); ?>" 
                                       class="btn btn-primary px-4">
                                        <i class="fas fa-info-circle me-2"></i> Detail Layanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <!-- Jika tidak ada data di database -->
                <div class="col-12 text-center py-5" data-aos="fade-in">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Belum ada layanan tersedia. Admin bisa menambahkan layanan di panel admin.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="row mt-5">
            <div class="col-12 text-center" data-aos="fade-up">
                <a href="<?php echo e(route('services.all')); ?>" class="btn btn-outline-primary btn-lg px-5 py-3">
                    <i class="fas fa-list me-2"></i> Semua Layanan
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- Contact Section -->
    <section id="kontak-section" class="py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
                    <h2 class="display-6 fw-bold text-primary mb-4">Hubungi Kami</h2>
                    <p class="lead mb-4">Ada pertanyaan tentang produk atau layanan kami? Jangan ragu untuk menghubungi kami.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="d-flex align-items-start p-3 bg-white rounded-3 shadow-sm h-100 contact-info-card">
                                <div class="bg-primary rounded-circle p-3 me-3 flex-shrink-0">
                                    <i class="fas fa-map-marker-alt text-white fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Alamat</h6>
                                    <p class="mb-0 small text-muted">Jl. Raya Ciamis No.123, Jawa Barat</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="150">
                            <div class="d-flex align-items-start p-3 bg-white rounded-3 shadow-sm h-100 contact-info-card">
                                <div class="bg-primary rounded-circle p-3 me-3 flex-shrink-0">
                                    <i class="fas fa-phone text-white fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Telepon</h6>
                                    <p class="mb-0 small text-muted">(0265) 123456</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="d-flex align-items-start p-3 bg-white rounded-3 shadow-sm h-100 contact-info-card">
                                <div class="bg-primary rounded-circle p-3 me-3 flex-shrink-0">
                                    <i class="fas fa-envelope text-white fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">Email</h6>
                                    <p class="mb-0 small text-muted">blud@smkn1ciamis.sch.id</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6" data-aos="fade-up" data-aos-delay="250">
                            <div class="d-flex align-items-start p-3 bg-white rounded-3 shadow-sm h-100 contact-info-card">
                                <div class="bg-primary rounded-circle p-3 me-3 flex-shrink-0">
                                    <i class="fab fa-whatsapp text-white fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">WhatsApp</h6>
                                    <p class="mb-0 small text-muted">+62 812 3456 7890</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Jam Operasional -->
                    <div class="mt-4" data-aos="fade-up" data-aos-delay="300">
                        <h6 class="fw-bold mb-3"><i class="fas fa-clock me-2 text-primary"></i> Jam Operasional</h6>
                        <div class="bg-white rounded-3 shadow-sm p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Senin - Jumat</span>
                                <span class="fw-bold">08:00 - 16:00</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Sabtu</span>
                                <span class="fw-bold">08:00 - 14:00</span>
                            </div>
                            <small class="text-muted d-block mt-2">Minggu & Hari Libur Nasional: Tutup</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="card border-0 shadow contact-form-card">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-4">Kirim Pesan</h4>
                            <form id="contactForm">
                                <?php echo csrf_field(); ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="phone" class="form-label">No. WhatsApp</label>
                                        <input type="tel" class="form-control" id="phone" placeholder="Contoh: 081234567890">
                                    </div>
                                    <div class="col-12">
                                        <label for="subject" class="form-label">Subjek</label>
                                        <input type="text" class="form-control" id="subject" placeholder="Contoh: Pesan Produk" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label">Pesan</label>
                                        <textarea class="form-control" id="message" rows="4" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary px-4 w-100 py-3">
                                            <i class="fas fa-paper-plane me-2"></i> Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </form>
                            
                            <div id="contactMessage" class="mt-3" style="display: none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Additional styles for home page */
    .stat-card {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12) !important;
    }
    
    .stat-icon {
        transition: all 0.4s ease;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.2) rotate(5deg);
    }
    
    .service-card {
        transition: all 0.5s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    
    .service-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    
    .service-icon {
        transition: all 0.5s ease;
    }
    
    .service-card:hover .service-icon {
        transform: scale(1.2) rotate(5deg);
        color: var(--dark-blue) !important;
    }
    
    .contact-info-card {
        transition: all 0.4s ease;
    }
    
    .contact-info-card:hover {
        transform: translateX(5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08) !important;
    }
    
    .contact-form-card {
        transition: all 0.5s ease;
    }
    
    .contact-form-card:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.12) !important;
    }
    
    /* === TAMBAHKAN KODE INI UNTUK PERBAIKI IKON GEPENG === */
    .contact-info-card .bg-primary {
        width: 50px !important;
        height: 50px !important;
        min-width: 50px !important;
        min-height: 50px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }
    
    /* Perbaikan khusus untuk ikon FontAwesome agar tidak gepeng */
    .contact-info-card i.fa-lg,
    .contact-info-card .fa-map-marker-alt,
    .contact-info-card .fa-phone,
    .contact-info-card .fa-envelope,
    .contact-info-card .fa-whatsapp {
        font-size: 1.4rem !important;
        line-height: 1 !important;
        display: inline-block !important;
        vertical-align: middle !important;
    }
    
    /* Efek hover untuk ikon */
    .contact-info-card:hover .bg-primary {
        transform: scale(1.1) rotate(10deg) !important;
        background: linear-gradient(135deg, var(--dark-blue), var(--primary-blue)) !important;
    }
    
    /* Pastikan teks ikon tetap terlihat */
    .contact-info-card .text-white {
        font-size: 1.4rem !important;
    }
    
    /* Untuk ikon jam operasional */
    .fa-clock {
        color: var(--primary-blue) !important;
        font-size: 1.1rem !important;
        vertical-align: middle !important;
    }
    /* === END PERBAIKAN IKON === */
    
    .form-control {
        transition: all 0.3s ease;
        border: 1px solid #dee2e6;
    }
    
    .form-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 0.25rem rgba(74, 144, 226, 0.25);
        transform: translateY(-2px);
    }
    
    /* === PERBAIKAN CAROUSEL === */
    .carousel-caption {
        bottom: 5% !important; /* Turunkan posisi caption */
        background: rgba(0, 0, 0, 0.3);
        border-radius: 15px;
        padding: 15px 20px;
        left: 10%;
        right: 10%;
        transform: translateY(20px);
    }
    
    .carousel-caption h2 {
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .carousel-caption p {
        font-size: 0.9rem !important;
        line-height: 1.4;
        margin-bottom: 1rem !important;
    }
    
    .carousel-caption .btn {
        font-size: 0.85rem;
        padding: 0.4rem 1rem;
    }
    
    /* Untuk layar kecil */
    @media (max-width: 768px) {
        .carousel-caption {
            bottom: 15% !important;
            padding: 10px 15px;
        }
        
        .carousel-caption h2 {
            font-size: 1.2rem !important;
        }
        
        .carousel-caption p {
            font-size: 0.8rem !important;
            display: none; /* Sembunyikan deskripsi di mobile */
        }
    }
    
    /* Rasio carousel 16:9 */
    #heroCarousel .carousel-item {
        height: 60vh;
        min-height: 400px;
    }
    
    #heroCarousel .carousel-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    /* === PERBAIKAN SERVICE CARD === */
    .service-card {
        height: 100%;
        transition: transform 0.3s ease;
    }
    
    .service-card:hover {
        transform: translateY(-5px);
    }
    
    .service-icon-wrapper {
        width: 70px;
        height: 70px;
        margin: 0 auto 1rem;
        background: linear-gradient(135deg, var(--primary-blue), var(--light-blue));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .service-icon {
        font-size: 2rem !important;
        color: white !important;
    }
    
    /* Highlight untuk layanan Air Minum */
    .service-card:first-child {
        border: 2px solid #4A90E2;
        position: relative;
    }
    
    .service-card:first-child::before {
        content: "BARU";
        position: absolute;
        top: -10px;
        right: -10px;
        background: #FF6B6B;
        color: white;
        font-size: 0.7rem;
        font-weight: bold;
        padding: 3px 8px;
        border-radius: 10px;
        z-index: 1;
    }
    
    /* === PERBAIKAN RESPONSIVE === */
    @media (max-width: 992px) {
        #heroCarousel .carousel-item {
            height: 50vh;
            min-height: 350px;
        }
        
        .service-card:first-child::before {
            top: -8px;
            right: -8px;
            font-size: 0.6rem;
            padding: 2px 6px;
        }
    }
    
    @media (max-width: 768px) {
        #heroCarousel .carousel-item {
            height: 40vh;
            min-height: 300px;
        }
        
        .carousel-indicators {
            bottom: 10px !important;
        }
        
        .service-card {
            margin-bottom: 20px;
        }
    }
    
    /* === STYLE UNTUK BADGE RASIO === */
    .carousel-info-badge {
        font-size: 0.7rem;
        background: rgba(0, 0, 0, 0.5);
        color: white;
        padding: 3px 8px;
        border-radius: 10px;
        position: absolute;
        bottom: 15px;
        right: 15px;
        z-index: 10;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // ===== CONTACT FORM =====
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                _token: $('input[name="_token"]').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                subject: $('#subject').val(),
                message: $('#message').val()
            };
            
            $.ajax({
                url: '<?php echo e(route("contact.submit")); ?>',
                method: 'POST',
                data: formData,
                beforeSend: function() {
                    const submitBtn = $('#contactForm button[type="submit"]');
                    const originalText = submitBtn.html();
                    submitBtn.html('<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...');
                    submitBtn.prop('disabled', true);
                    
                    $('#contactMessage').hide().removeClass('alert-success alert-danger')
                        .html('');
                },
                success: function(response) {
                    const submitBtn = $('#contactForm button[type="submit"]');
                    submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Kirim Pesan');
                    submitBtn.prop('disabled', false);
                    
                    $('#contactMessage').show().addClass('alert alert-success')
                        .html('<i class="fas fa-check-circle me-2"></i> ' + response.message);
                    $('#contactForm')[0].reset();
                    
                    setTimeout(function() {
                        $('#contactMessage').fadeOut();
                    }, 5000);
                },
                error: function(xhr) {
                    const submitBtn = $('#contactForm button[type="submit"]');
                    submitBtn.html('<i class="fas fa-paper-plane me-2"></i> Kirim Pesan');
                    submitBtn.prop('disabled', false);
                    
                    let message = 'Terjadi kesalahan. Silakan coba lagi.';
                    if (xhr.responseJSON?.message) message = xhr.responseJSON.message;
                    
                    $('#contactMessage').show().addClass('alert alert-danger')
                        .html('<i class="fas fa-exclamation-circle me-2"></i> ' + message);
                }
            });
        });
        
        // ===== SMOOTH COUNTER ANIMATION =====
        // Tunggu 1 detik setelah page load
        setTimeout(function() {
            $('.stat-card').each(function(index) {
                var card = $(this);
                var numberElement = card.find('h3');
                var originalText = numberElement.text();
                var hasPlus = originalText.includes('+');
                var targetNumber = parseInt(originalText.replace('+', '')) || 0;
                
                // Simpan nilai asli sebagai data attribute
                numberElement.data('original', originalText);
                numberElement.data('target', targetNumber);
                numberElement.data('hasPlus', hasPlus);
                
                // Reset ke 0
                numberElement.text('0' + (hasPlus ? '+' : ''));
                
                // Animate dengan delay bertahap
                setTimeout(function() {
                    smoothCounter(numberElement, index);
                }, index * 400); // 400ms delay antar card
            });
        }, 1000);
        
        // Fungsi smooth counter dengan requestAnimationFrame
        function smoothCounter($element, cardIndex) {
            var startTime = null;
            var duration = 2000; // 2 detik
            var target = $element.data('target');
            var hasPlus = $element.data('hasPlus');
            var startValue = 0;
            
            function animate(currentTime) {
                if (!startTime) startTime = currentTime;
                var elapsed = currentTime - startTime;
                var progress = Math.min(elapsed / duration, 1);
                
                // Easing function untuk smooth animation
                var easedProgress = easeOutCubic(progress);
                var currentValue = Math.floor(startValue + (target - startValue) * easedProgress);
                
                // Update teks
                $element.text(currentValue + (hasPlus ? '+' : ''));
                
                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    // Final value
                    $element.text(target + (hasPlus ? '+' : ''));
                    $element.addClass('animated');
                    
                    // Tambahkan efek setelah selesai
                    setTimeout(function() {
                        $element.parent().addClass('counter-completed');
                    }, 300);
                }
            }
            
            requestAnimationFrame(animate);
        }
        
        // Easing function
        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }
        
        // Fallback untuk browser lama
        if (!window.requestAnimationFrame) {
            window.requestAnimationFrame = function(callback) {
                return setTimeout(callback, 1000 / 60);
            };
        }
        
        // ===== CAROUSEL INFO =====
        // Update badge dengan info slide aktif
        $('#heroCarousel').on('slid.bs.carousel', function () {
            var activeIndex = $(this).find('.carousel-item.active').index();
            var totalItems = $(this).find('.carousel-item').length;
            $('.carousel-info-badge').text(`Slide ${activeIndex + 1}/${totalItems} | 16:9`);
        });
        
        // Inisialisasi tooltip untuk badge rasio
        var tooltip = new bootstrap.Tooltip(document.querySelector('.carousel-info-badge'), {
            title: 'Rasio carousel: 16:9 (Lebar:Tinggi) - Rekomendasi ukuran gambar: 1920x1080px',
            placement: 'top'
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', [
    'socialMedia' => $socialMedia,
    'contactInfo' => $contactInfo
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/home.blade.php ENDPATH**/ ?>