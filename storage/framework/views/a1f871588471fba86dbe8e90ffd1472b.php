<?php $__env->startSection('title', 'Semua Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4">Semua Produk TEFA</h1>
    
    <!-- Filter Form -->
    <form method="GET" action="<?php echo e(route('products.all')); ?>" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="tefa" class="form-label">Filter TEFA</label>
            <select name="tefa" id="tefa" class="form-select">
                <option value="all">Semua TEFA</option>
                <?php $__currentLoopData = $tefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($tefa->slug); ?>" <?php echo e(request('tefa') == $tefa->slug ? 'selected' : ''); ?>>
                        <?php echo e($tefa->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="category" class="form-label">Filter Kategori</label>
            <select name="category" id="category" class="form-select">
                <option value="all">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                        <?php echo e($category); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-4">
            <label for="search" class="form-label">Cari Produk</label>
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Cari produk..." value="<?php echo e(request('search')); ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>
    
    <?php if($products->isEmpty()): ?>
        <div class="alert alert-info">
            Tidak ditemukan produk.
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if($product->image): ?>
                            <img src="<?php echo e(asset('storage/' . $product->image)); ?>" 
                                 class="card-img-top" alt="<?php echo e($product->name); ?>" style="height: 200px; object-fit: cover;">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($product->name); ?></h5>
                            <p class="card-text"><?php echo e(Str::limit($product->description, 100)); ?></p>
                            <div class="mb-2">
                                <span class="badge bg-primary"><?php echo e($product->tefa->name); ?></span>
                                <span class="badge bg-secondary"><?php echo e($product->category); ?></span>
                                <?php if($product->is_featured): ?>
                                    <span class="badge bg-warning">Unggulan</span>
                                <?php endif; ?>
                            </div>
                            <h5 class="text-primary"><?php echo e('Rp ' . number_format($product->price, 0, ',', '.')); ?></h5>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo e(route('products.show', $product->slug)); ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <?php echo e($products->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/product/all.blade.php ENDPATH**/ ?>