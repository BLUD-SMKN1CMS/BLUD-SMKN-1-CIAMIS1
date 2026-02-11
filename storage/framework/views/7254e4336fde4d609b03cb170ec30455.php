<?php $__env->startSection('title', 'Semua TEFA'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h1 class="mb-4">Semua Jurusan TEFA SMKN 1 Ciamis</h1>
    
    <?php if($tefas->isEmpty()): ?>
        <div class="alert alert-info">
            Belum ada data TEFA.
        </div>
    <?php else: ?>
        <div class="row">
            <?php $__currentLoopData = $tefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($tefa->name); ?></h5>
                            <p class="card-text"><?php echo e(Str::limit($tefa->description, 150)); ?></p>
                            <div class="mb-2">
                                <span class="badge bg-primary"><?php echo e($tefa->code); ?></span>
                                <span class="badge bg-success"><?php echo e($tefa->products_count); ?> Produk</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="<?php echo e(route('tefa.show', $tefa->slug)); ?>" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\RISWAN\BLUD-SMKN-1-CIAMIS1\resources\views/tefa/all.blade.php ENDPATH**/ ?>