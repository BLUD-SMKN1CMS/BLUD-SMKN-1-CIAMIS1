<?php $__env->startSection('title', 'Edit Produk'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
        <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Produk: <?php echo e($product->name); ?></h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                value="<?php echo e(old('name', $product->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
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
                        <div class="form-group">
                            <label>TEFA *</label>
                            <select name="tefa_id" class="form-control <?php $__errorArgs = ['tefa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                <option value="">Pilih TEFA</option>
                                <?php $__currentLoopData = $tefas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tefa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($tefa->id); ?>" 
                                        <?php echo e(old('tefa_id', $product->tefa_id) == $tefa->id ? 'selected' : ''); ?>>
                                        <?php echo e($tefa->name); ?> (<?php echo e($tefa->code); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['tefa_id'];
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="price" class="form-control <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    value="<?php echo e(old('price', $product->price)); ?>" required>
                                <?php $__errorArgs = ['price'];
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Stok *</label>
                            <input type="number" name="stock" class="form-control <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('stock', $product->stock)); ?>" required min="0">
                            <?php $__errorArgs = ['stock'];
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori *</label>
                            <input type="text" name="category" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                value="<?php echo e(old('category', $product->category)); ?>" required>
                            <?php $__errorArgs = ['category'];
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

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo e(old('description', $product->description)); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="font-weight-bold">Gambar Produk (Maks. 4)</label>
                        <div class="row">
                            <!-- Image 1 (Utama) -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar Utama</label>
                                    <div id="preview-container-1" class="mb-2 text-center" style="min-height: 120px;">
                                        <?php if($product->image): ?>
                                            <img src="<?php echo e(Str::startsWith($product->image, 'http') ? $product->image : asset($product->image)); ?>" 
                                                alt="Main Image" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="image" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-1')">
                                </div>
                            </div>
                            
                            <!-- Image 2 -->
                            <!-- Image 2 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 2</label>
                                    <div id="preview-container-2" class="mb-2 text-center" style="min-height: 120px;">
                                        <?php if($product->image_2): ?>
                                            <img src="<?php echo e(Str::startsWith($product->image_2, 'http') ? $product->image_2 : asset($product->image_2)); ?>" 
                                                alt="Image 2" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="image_2" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-2')">
                                </div>
                            </div>

                            <!-- Image 3 -->
                            <!-- Image 3 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 3</label>
                                    <div id="preview-container-3" class="mb-2 text-center" style="min-height: 120px;">
                                        <?php if($product->image_3): ?>
                                            <img src="<?php echo e(Str::startsWith($product->image_3, 'http') ? $product->image_3 : asset($product->image_3)); ?>" 
                                                alt="Image 3" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="image_3" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-3')">
                                </div>
                            </div>

                            <!-- Image 4 -->
                            <!-- Image 4 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 4</label>
                                    <div id="preview-container-4" class="mb-2 text-center" style="min-height: 120px;">
                                        <?php if($product->image_4): ?>
                                            <img src="<?php echo e(Str::startsWith($product->image_4, 'http') ? $product->image_4 : asset($product->image_4)); ?>" 
                                                alt="Image 4" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <input type="file" name="image_4" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-4')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="draft" <?php echo e($product->status == 'draft' ? 'selected' : ''); ?>>Draft</option>
                                <option value="active" <?php echo e($product->status == 'active' ? 'selected' : ''); ?>>Aktif</option>
                                <option value="inactive" <?php echo e($product->status == 'inactive' ? 'selected' : ''); ?>>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" class="form-control" value="<?php echo e(old('order', $product->order)); ?>">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                        value="1" <?php echo e(old('is_featured', $product->is_featured) ? 'checked' : ''); ?>>
                    <label class="form-check-label" for="is_featured">
                        Tampilkan sebagai produk unggulan
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Produk
                    </button>
                    <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function previewProductImage(input, containerId) {
        const container = document.getElementById(containerId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Check if there is already an img tag
                let img = container.querySelector('img');
                
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                } else {
                    // Remove the "Tidak ada gambar" placeholder if it exists
                    container.innerHTML = '';
                    img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'img-fluid img-thumbnail';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    container.appendChild(img);
                }
            }

            reader.readAsDataURL(file);
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>