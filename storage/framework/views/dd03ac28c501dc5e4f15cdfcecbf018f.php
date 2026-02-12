

<?php $__env->startSection('title', 'Tentang Kami'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="about-hero py-5 mb-5" style="background: linear-gradient(135deg, #4A90E2 0%, #2a5298 100%); color: white; position: relative; overflow: hidden;">
    <div class="container position-relative z-1 text-center py-5">
        <h1 class="display-4 fw-bold mb-3" data-aos="fade-up">Tentang BLUD SMKN 1 Ciamis</h1>
        <p class="lead mb-0" data-aos="fade-up" data-aos-delay="100">Pusat Keunggulan Pendidikan Vokasi dan Layanan Profesional</p>
    </div>
    <!-- Decorative Circle -->
    <div style="position: absolute; top: -50px; right: -50px; width: 300px; height: 300px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
    <div style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
</section>

<!-- Main Content -->
<div class="container mb-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
            <img src="<?php echo e(asset('assets/iconsmea.png')); ?>" alt="BLUD SMKN 1 Ciamis" class="img-fluid rounded-3 shadow-lg" style="max-height: 400px; width: 100%; object-fit: contain; background: #f8f9fa; padding: 20px;">
        </div>
        <div class="col-lg-6" data-aos="fade-left">
            <h2 class="fw-bold mb-4 text-primary">Siapa Kami?</h2>
            <p class="lead text-muted">Badan Layanan Umum Daerah (BLUD) SMKN 1 Ciamis adalah unit usaha profesional yang dikelola oleh sekolah untuk memberikan layanan dan produk berkualitas kepada masyarakat.</p>
            <p>Berdiri dengan semangat Teaching Factory (TEFA), kami mengintegrasikan pembelajaran praktik siswa dengan standar industri yang sesungguhnya. Setiap produk dan layanan yang kami tawarkan dikerjakan oleh siswa-siswa kompeten di bawah bimbingan guru ahli dan praktisi industri.</p>
            <div class="row mt-4 g-3">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                        <span class="fw-bold">Standar Industri</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                        <span class="fw-bold">Harga Kompetitif</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                        <span class="fw-bold">Pelayanan Profesional</span>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-check-circle text-success fs-4 me-3"></i>
                        <span class="fw-bold">Inovasi Berkelanjutan</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visi Misi -->
    <div class="row mb-5" data-aos="fade-up">
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm custom-card">
                <div class="card-body p-4 text-center">
                    <div class="icon-wrapper mb-3 mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="fas fa-eye fs-2"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Visi</h3>
                    <p class="text-muted">Menjadi pusat pengembangan kompetensi keahlian dan unit produksi yang unggul, mandiri, dan berdaya saing global melalui implementasi BLUD.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100 border-0 shadow-sm custom-card">
                <div class="card-body p-4">
                    <div class="text-center">
                        <div class="icon-wrapper mb-3 mx-auto bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="fas fa-rocket fs-2"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Misi</h3>
                    </div>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2"><i class="fas fa-arrow-right text-success me-2"></i> Mengembangkan unit produksi berbasis kompetensi keahlian.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-success me-2"></i> Meningkatkan kualitas layanan dan produk sesuai standar pasar.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-success me-2"></i> Membangun kemitraan strategis dengan DU/DI.</li>
                        <li class="mb-2"><i class="fas fa-arrow-right text-success me-2"></i> Menumbuhkan jiwa wirausaha bagi warga sekolah.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Singkat -->
    <div class="bg-light rounded-3 p-5 mb-5" data-aos="fade-up">
        <div class="row text-center">
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary display-4"><?php echo e($stats['total_tefas'] ?? 7); ?></h2>
                <p class="text-muted fw-bold">Unit Usaha (TEFA)</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary display-4"><?php echo e($stats['total_products'] ?? 50); ?>+</h2>
                <p class="text-muted fw-bold">Produk Unggulan</p>
            </div>
            <div class="col-md-3 mb-4 mb-md-0">
                <h2 class="fw-bold text-primary display-4"><?php echo e($stats['total_services'] ?? 20); ?>+</h2>
                <p class="text-muted fw-bold">Layanan Jasa</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary display-4"><?php echo e($stats['years_exp'] ?? 10); ?>+</h2>
                <p class="text-muted fw-bold">Tahun Pengalaman</p>
            </div>
        </div>
    </div>

    <!-- Quote -->
    <div class="text-center py-5" data-aos="zoom-in">
        <blockquote class="blockquote">
            <p class="mb-4 h3 fst-italic">"SMK Bisa! SMK Hebat! Siap Kerja, Santun, Mandiri, Kreatif!"</p>
            <footer class="blockquote-footer">Motto SMKN 1 Ciamis</footer>
        </blockquote>
    </div>
</div>

<style>
    .custom-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/about.blade.php ENDPATH**/ ?>