<?php $__env->startSection('title', 'Tambah Carousel Baru'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Carousel Baru</h1>
        <a href="<?php echo e(route('admin.carousels.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Carousel</h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.carousels.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Carousel <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="title" name="title" value="<?php echo e(old('title')); ?>" 
                                   placeholder="Contoh: Selamat Datang di TEFA SMKN 1 Ciamis" required>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="description" name="description" rows="3" 
                                      placeholder="Deskripsi singkat carousel"><?php echo e(old('description')); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="text-muted">Maksimal 200 karakter (akan dipotong di tampilan)</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">Teks Tombol</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="button_text" name="button_text" value="<?php echo e(old('button_text')); ?>" 
                                           placeholder="Contoh: Lihat Produk">
                                    <?php $__errorArgs = ['button_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_url" class="form-label">URL Tombol</label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['button_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="button_url" name="button_url" value="<?php echo e(old('button_url')); ?>" 
                                           placeholder="Contoh: #produk-section">
                                    <?php $__errorArgs = ['button_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="status" name="status" required>
                                        <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>>Aktif</option>
                                        <option value="inactive" <?php echo e(old('status') == 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Urutan</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="order" name="order" value="<?php echo e(old('order')); ?>" 
                                           min="1" placeholder="Kosongkan untuk urutan terakhir">
                                    <?php $__errorArgs = ['order'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <small class="text-muted">Angka kecil = muncul lebih awal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-image me-2"></i>Upload Gambar</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Carousel <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="image" name="image" accept="image/*" required
                                           onchange="previewImage(this)">
                                    <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                        <img id="preview" class="img-fluid rounded border" 
                                             style="max-height: 200px;" alt="Preview">
                                    </div>
                                    
                                    <!-- Ratio Info -->
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Rasio 16:9</strong><br>
                                        Ukuran disarankan: <strong>1920×1080px</strong><br>
                                        Format: JPG, PNG, GIF (max 5MB)
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Image Preview Placeholder -->
                        <div class="text-center mt-4">
                            <div class="ratio ratio-16x9 border rounded bg-light">
                                <div class="d-flex flex-column justify-content-center align-items-center">
                                    <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">Preview akan muncul di sini</p>
                                </div>
                            </div>
                            <small class="text-muted mt-2 d-block">Preview rasio 16:9</small>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Carousel
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
                
                // Check image dimensions
                const img = new Image();
                img.onload = function() {
                    const ratio = img.width / img.height;
                    const targetRatio = 16/9;
                    const tolerance = 0.1;
                    
                    if (Math.abs(ratio - targetRatio) > tolerance) {
                        alert('⚠️ Peringatan: Rasio gambar bukan 16:9! Disarankan: 1920×1080px');
                    }
                };
                img.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
            preview.src = '';
        }
    }

    // Live character counter for description
    document.getElementById('description').addEventListener('input', function() {
        const maxLength = 200;
        const currentLength = this.value.length;
        const counter = document.getElementById('charCounter') || (function() {
            const counter = document.createElement('div');
            counter.id = 'charCounter';
            counter.className = 'form-text';
            this.parentNode.appendChild(counter);
            return counter;
        }.bind(this)());

        counter.textContent = `${currentLength}/${maxLength} karakter`;
        
        if (currentLength > maxLength) {
            counter.classList.add('text-danger');
        } else {
            counter.classList.remove('text-danger');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\xampp_new\htdocs\tefa_smkn1_ciamis\resources\views/admin/carousels/create.blade.php ENDPATH**/ ?>