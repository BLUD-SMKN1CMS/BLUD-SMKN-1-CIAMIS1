 
 
<?php $__env->startSection('content'); ?> 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <div class="card-header"> 
                    <h3 class="card-title"> 
                        <i class="fas fa-cog"></i> Pengaturan Website 
                    </h3> 
                </div> 
                <div class="card-body">
    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>
    
    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card card-primary mb-3">
            <div class="card-header">
                <h4 class="mb-0">
                    <?php if($group == 'contact'): ?>
                        <i class="fas fa-address-book"></i> Kontak & Informasi
                    <?php elseif($group == 'social'): ?>
                        <i class="fas fa-share-alt"></i> Media Sosial
                    <?php elseif($group == 'hours'): ?>
                        <i class="fas fa-clock"></i> Jam Operasional
                    <?php else: ?>
                        <i class="fas fa-cog"></i> Pengaturan <?php echo e(ucfirst($group)); ?>

                    <?php endif; ?>
                </h4>
            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label"><?php echo e($setting->description); ?></label>
                                        
                                        <?php if($setting->type == 'textarea'): ?>
                                            <textarea name="<?php echo e($setting->key); ?>" class="form-control" rows="3"><?php echo e($setting->value); ?></textarea>
                                        <?php elseif($setting->type == 'email'): ?>
                                            <input type="email" name="<?php echo e($setting->key); ?>" class="form-control" value="<?php echo e($setting->value); ?>">
                                        <?php elseif($setting->type == 'url'): ?>
                                            <input type="url" name="<?php echo e($setting->key); ?>" class="form-control" value="<?php echo e($setting->value); ?>" placeholder="https://">
                                        <?php else: ?>
                                            <input type="text" name="<?php echo e($setting->key); ?>" class="form-control" value="<?php echo e($setting->value); ?>">
                                        <?php endif; ?>
                                        
                                        <?php if($setting->group == 'hours'): ?>
                                            <small class="text-muted">Contoh: Senin - Jumat: 08:00 - 16:00</small>
                                        <?php endif; ?>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Semua Perubahan
                            </button>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div> 
        </div> 
    </div> 
</div> 
<?php $__env->stopSection(); ?> 

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>