<?php $__env->startSection('title', 'Detail Produk: ' . $product->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Produk</h1>
        <div class="btn-group" role="group">
            <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
            <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="btn btn-warning">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <button type="button" class="btn btn-primary" onclick="window.print()">
                <i class="fas fa-print mr-1"></i> Cetak
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle mr-2"></i> <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Kolom Kiri: Informasi Produk -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box mr-2"></i> <?php echo e($product->name); ?>

                    </h6>
                    <div>
                        <span class="badge badge-secondary">
                            ID: <?php echo e($product->id); ?>

                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Gambar Produk -->
                        <div class="col-md-5 mb-4 mb-md-0">
                            <?php
                                $imagePath = $product->image;
                                $hasImage = $imagePath && file_exists(public_path($imagePath));
                                $placeholder = 'https://via.placeholder.com/400x300/4A90E2/FFFFFF?text=' . urlencode(substr($product->name, 0, 30));
                            ?>
                            
                            <div class="text-center">
                                <div class="product-image-container mb-3">
                                    <?php if($hasImage): ?>
                                        <img src="<?php echo e(asset($imagePath)); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             class="img-fluid rounded shadow-lg"
                                             style="max-height: 300px; object-fit: contain;"
                                             onerror="this.src='<?php echo e($placeholder); ?>'"
                                             id="productMainImage">
                                    <?php else: ?>
                                        <div class="bg-light rounded shadow-lg d-flex flex-column align-items-center justify-content-center py-5"
                                             style="height: 300px;">
                                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                            <p class="text-muted mb-1">Tidak ada gambar</p>
                                            <?php if($imagePath): ?>
                                                <small class="text-danger">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                                    File: <?php echo e(basename($imagePath)); ?>

                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if($hasImage): ?>
                                <div class="mt-3">
                                    <a href="<?php echo e(asset($imagePath)); ?>" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt mr-1"></i> Buka Gambar
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary" 
                                            onclick="copyToClipboard('<?php echo e(asset($imagePath)); ?>')">
                                        <i class="fas fa-copy mr-1"></i> Salin URL
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Detail Produk -->
                        <div class="col-md-7">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th width="35%" class="bg-light">Nama Produk</th>
                                        <td>
                                            <strong><?php echo e($product->name); ?></strong>
                                            <?php if($product->is_featured): ?>
                                                <span class="badge badge-warning ml-2">
                                                    <i class="fas fa-star mr-1"></i> UNGGULAN
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">TEFA</th>
                                        <td>
                                            <?php if($product->tefa): ?>
                                                <span class="badge badge-primary">
                                                    <i class="fas <?php echo e($product->tefa->icon ?? 'fa-school'); ?> mr-1"></i>
                                                    <?php echo e($product->tefa->code); ?>

                                                </span>
                                                <?php echo e($product->tefa->name); ?>

                                                <a href="<?php echo e(route('admin.tefas.show', $product->tefa->id)); ?>" 
                                                   class="btn btn-sm btn-outline-primary ml-2">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-danger">
                                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                                    Belum memiliki TEFA
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Harga</th>
                                        <td>
                                            <h4 class="text-primary mb-0">
                                                Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                            </h4>
                                            <small class="text-muted">Harga per unit</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kategori</th>
                                        <td>
                                            <span class="badge badge-info"><?php echo e($product->category); ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            <span class="badge 
                                                <?php if($product->status == 'active'): ?> badge-success
                                                <?php elseif($product->status == 'inactive'): ?> badge-secondary
                                                <?php else: ?> badge-warning <?php endif; ?>"
                                                style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                                <?php if($product->status == 'active'): ?>
                                                    <i class="fas fa-check-circle mr-1"></i> AKTIF
                                                <?php elseif($product->status == 'inactive'): ?>
                                                    <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                                <?php else: ?>
                                                    <i class="fas fa-pencil-alt mr-1"></i> DRAFT
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Urutan Tampilan</th>
                                        <td>
                                            <span class="badge badge-secondary"><?php echo e($product->order); ?></span>
                                            <small class="text-muted ml-2">(Angka kecil = tampil lebih awal)</small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Slug URL</th>
                                        <td>
                                            <code style="background: #f8f9fa; padding: 2px 6px; border-radius: 3px;">
                                                /produk/<?php echo e($product->slug); ?>

                                            </code>
                                            <button class="btn btn-sm btn-outline-secondary ml-2" 
                                                    onclick="copyToClipboard('/produk/<?php echo e($product->slug); ?>')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Dibuat</th>
                                        <td>
                                            <i class="far fa-calendar-alt mr-1 text-muted"></i>
                                            <?php echo e($product->created_at->format('d F Y')); ?>

                                            <small class="text-muted ml-2">
                                                (<?php echo e($product->created_at->diffForHumans()); ?>)
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Terakhir Diupdate</th>
                                        <td>
                                            <i class="far fa-clock mr-1 text-muted"></i>
                                            <?php echo e($product->updated_at->format('d F Y H:i')); ?>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Deskripsi Produk -->
                    <div class="mt-4">
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-align-left mr-2 text-primary"></i>Deskripsi Produk
                        </h5>
                        <div class="p-4 rounded bg-light border">
                            <?php if($product->description): ?>
                                <?php echo e($product->description); ?>

                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                                    <p class="mb-0">Belum ada deskripsi produk</p>
                                    <small>Tambahkan deskripsi di halaman edit</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Aksi & Informasi -->
        <div class="col-lg-4">
            <!-- Aksi Cepat -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-bolt mr-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <!-- Toggle Status -->
                        <?php if($product->status == 'active'): ?>
                        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" 
                              class="list-group-item p-0 border-0 mb-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="status" value="inactive">
                            <button type="submit" class="btn btn-warning btn-block text-left py-3">
                                <i class="fas fa-ban mr-2"></i> Nonaktifkan Produk
                            </button>
                        </form>
                        <?php else: ?>
                        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST"
                              class="list-group-item p-0 border-0 mb-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="status" value="active">
                            <button type="submit" class="btn btn-success btn-block text-left py-3">
                                <i class="fas fa-check mr-2"></i> Aktifkan Produk
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <!-- Toggle Unggulan -->
                        <?php if($product->is_featured): ?>
                        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST"
                              class="list-group-item p-0 border-0 mb-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="is_featured" value="0">
                            <button type="submit" class="btn btn-info btn-block text-left py-3">
                                <i class="fas fa-star-half-alt mr-2"></i> Hapus Status Unggulan
                            </button>
                        </form>
                        <?php else: ?>
                        <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST"
                              class="list-group-item p-0 border-0 mb-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="is_featured" value="1">
                            <button type="submit" class="btn btn-info btn-block text-left py-3">
                                <i class="fas fa-star mr-2"></i> Jadikan Produk Unggulan
                            </button>
                        </form>
                        <?php endif; ?>
                        
                        <!-- Hapus Produk -->
                        <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST"
                              onsubmit="return confirmDelete()"
                              class="list-group-item p-0 border-0 mb-2">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger btn-block text-left py-3">
                                <i class="fas fa-trash mr-2"></i> Hapus Produk
                            </button>
                        </form>
                        
                        <!-- Edit Produk -->
                        <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" 
                           class="list-group-item list-group-item-action border-0 mb-2">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning rounded-circle p-2 mr-3">
                                    <i class="fas fa-edit text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Edit Produk</h6>
                                    <small class="text-muted">Ubah informasi produk</small>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Lihat di Frontend -->
                        <a href="<?php echo e(route('products.show', $product->slug)); ?>" 
                           target="_blank"
                           class="list-group-item list-group-item-action border-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-2 mr-3">
                                    <i class="fas fa-external-link-alt text-white"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">Lihat di Website</h6>
                                    <small class="text-muted">Pratinjau di frontend</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Informasi TEFA -->
            <div class="card shadow">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-school mr-2"></i>Informasi TEFA
                    </h6>
                </div>
                <div class="card-body">
                    <?php if($product->tefa): ?>
                        <div class="text-center mb-3">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2"
                                 style="width: 60px; height: 60px;">
                                <i class="fas <?php echo e($product->tefa->icon ?? 'fa-school'); ?> fa-2x text-white"></i>
                            </div>
                            <h5 class="mb-1"><?php echo e($product->tefa->name); ?></h5>
                            <p class="text-muted mb-2">(<?php echo e($product->tefa->code); ?>)</p>
                        </div>
                        
                        <table class="table table-sm">
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    <span class="badge <?php echo e($product->tefa->is_active ? 'badge-success' : 'badge-secondary'); ?>">
                                        <?php echo e($product->tefa->is_active ? 'Aktif' : 'Nonaktif'); ?>

                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Urutan:</strong></td>
                                <td><?php echo e($product->tefa->order); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Produk:</strong></td>
                                <td><?php echo e($product->tefa->products_count ?? 0); ?> produk</td>
                            </tr>
                        </table>
                        
                        <div class="mt-3 text-center">
                            <a href="<?php echo e(route('admin.tefas.show', $product->tefa->id)); ?>" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Detail TEFA
                            </a>
                            <a href="<?php echo e(route('admin.tefas.edit', $product->tefa->id)); ?>" 
                               class="btn btn-outline-warning btn-sm ml-2">
                                <i class="fas fa-edit mr-1"></i> Edit TEFA
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                            <p class="text-muted mb-0">Produk ini belum memiliki TEFA</p>
                            <small class="text-muted">Tambahkan TEFA di halaman edit produk</small>
                            <div class="mt-3">
                                <a href="<?php echo e(route('admin.tefas.create')); ?>" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-plus mr-1"></i> Buat TEFA Baru
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Statistik -->
            <div class="card shadow mt-4">
                <div class="card-header py-3 bg-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-primary"><?php echo e($product->order); ?></div>
                                <small class="text-muted">Urutan</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-success">
                                    <?php echo e($product->status == 'active' ? '✓' : '✗'); ?>

                                </div>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-warning">
                                    <?php echo e($product->is_featured ? '★' : '☆'); ?>

                                </div>
                                <small class="text-muted">Unggulan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-info">
                                    <?php echo e($product->tefa ? '✓' : '✗'); ?>

                                </div>
                                <small class="text-muted">TEFA</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }
    
    .product-image-container img {
        transition: transform 0.3s;
    }
    
    .product-image-container:hover img {
        transform: scale(1.05);
    }
    
    .list-group-item-action:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.3s;
    }
    
    .card-header.bg-primary,
    .card-header.bg-info,
    .card-header.bg-secondary {
        border-radius: 0.35rem 0.35rem 0 0 !important;
    }
    
    @media print {
        .btn, .card-header.bg-primary, .card-header.bg-info, .card-header.bg-secondary {
            display: none !important;
        }
        
        .col-lg-4 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function confirmDelete() {
    return confirm('Hapus produk "<?php echo e($product->name); ?>"?\n\nTindakan ini tidak dapat dibatalkan!');
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('URL berhasil disalin ke clipboard: ' + text);
    }, function(err) {
        console.error('Gagal menyalin: ', err);
        // Fallback untuk browser lama
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('URL berhasil disalin!');
    });
}

// Tooltip initialization
$(document).ready(function() {
    $('[title]').tooltip();
    
    // Print button
    $('.print-btn').click(function() {
        window.print();
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/products/show.blade.php ENDPATH**/ ?>