<?php $__env->startSection('title', 'Kelola Produk'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>
            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Produk
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
                <div>
                    <span class="badge badge-success mr-2">
                        Total: <?php echo e($products->count()); ?>

                    </span>
                    <span class="badge badge-info">
                        Unggulan: <?php echo e($products->where('is_featured', true)->count()); ?>

                    </span>
                    <span class="badge badge-warning ml-2">
                        Aktif: <?php echo e($products->where('status', 'active')->count()); ?>

                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="40">#</th>
                                <th width="80">Gambar</th>
                                <th>Nama Produk</th>
                                <th>TEFA</th>
                                <th width="120">Harga</th>
                                <th width="100">Status</th>
                                <th width="90">Unggulan</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td>
                                        <?php if($product->image): ?>
                                            <img src="<?php echo e($product->image_url); ?>" 
                                                 alt="<?php echo e($product->name); ?>"
                                                 style="width: 50px; height: 50px; object-fit: cover;" 
                                                 class="rounded border"
                                                 onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2250%22%20height%3D%2250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22Arial%22%20font-size%3D%2210%22%20fill%3D%22%236c757d%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3ENo%20Image%3C%2Ftext%3E%3C%2Fsvg%3E';"
                                                 title="<?php echo e($product->name); ?>">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                                                 style="width: 50px; height: 50px;"
                                                 title="Tidak ada gambar">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?php echo e($product->name); ?></strong>
                                        <?php if($product->category): ?>
                                            <br>
                                            <small class="text-muted"><?php echo e($product->category); ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product->tefa): ?>
                                            <span class="badge badge-primary">
                                                <i class="fas <?php echo e($product->tefa->icon ?? 'fa-school'); ?> mr-1"></i>
                                                <?php echo e($product->tefa->code); ?>

                                            </span>
                                            <small
                                                class="d-block text-muted"><?php echo e(Str::limit($product->tefa->name, 15)); ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp
                                            <?php echo e(number_format($product->price, 0, ',', '.')); ?></strong>
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
                                    <?php if($product->status == 'active'): ?> badge-success
                                    <?php elseif($product->status == 'inactive'): ?> badge-secondary
                                    <?php else: ?> badge-warning <?php endif; ?>">
                                            <?php if($product->status == 'active'): ?>
                                                <i class="fas fa-check-circle mr-1"></i> AKTIF
                                            <?php elseif($product->status == 'inactive'): ?>
                                                <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                            <?php else: ?>
                                                <i class="fas fa-pencil-alt mr-1"></i> DRAFT
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if($product->is_featured): ?>
                                            <span class="badge badge-warning" title="Produk Unggulan">
                                                <i class="fas fa-star"></i>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <!-- DROPDOWN 3 TITIK -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.products.show', $product->id)); ?>">
                                                        <i class="fas fa-eye me-2 text-info"></i> Lihat Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="<?php echo e(route('admin.products.edit', $product->id)); ?>">
                                                        <i class="fas fa-edit me-2 text-warning"></i> Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <!-- FIXED: Form Delete yang benar -->
                                                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>"
                                                        method="POST" id="delete-form-<?php echo e($product->id); ?>"
                                                        onsubmit="return confirm('Hapus produk <?php echo e($product->name); ?>?')">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                    </form>
                                                    <button type="submit" form="delete-form-<?php echo e($product->id); ?>"
                                                        class="dropdown-item text-danger text-decoration-none w-100 text-start">
                                                        <i class="fas fa-trash me-2"></i> Hapus
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-box-open fa-2x mb-3"></i>
                                            <p>Belum ada data produk</p>
                                            <a href="<?php echo e(route('admin.products.create')); ?>" class="btn btn-primary btn-sm">
                                                <i class="fas fa-plus mr-1"></i> Tambah Produk Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <?php if($products->count() > 0): ?>
                    <div class="mt-3">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">
                                    Menampilkan <?php echo e($products->count()); ?> produk
                                </small>
                            </div>
                            <div class="col-md-6 text-right">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Klik 3 titik untuk menu aksi
                                </small>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        #productsTable tbody tr:hover {
            background-color: rgba(74, 144, 226, 0.05);
            transition: background-color 0.3s;
        }

        #productsTable img {
            transition: transform 0.3s;
        }

        #productsTable img:hover {
            transform: scale(1.1);
        }

        /* CSS DROPDOWN */
        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            min-width: 180px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #eee;
            z-index: 1050 !important;
        }

        .dropdown-item {
            padding: 8px 15px;
            font-size: 0.9rem;
            transition: all 0.2s;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(3px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Alert close button */
        .btn-close {
            padding: 1rem 1rem;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            #productsTable {
                font-size: 0.85rem;
            }

            #productsTable td,
            #productsTable th {
                padding: 0.5rem;
            }

            .dropdown-menu {
                min-width: 150px;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {
            // Initialize dropdowns
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el) {
                new bootstrap.Dropdown(el);
            });

            // Tooltip untuk semua tombol
            $('[title]').tooltip();

            // Toast notification function
            function showToast(message, type = 'info') {
                const toastId = 'toast-' + Date.now();
                const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}-circle me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;

                // Add toast container if not exists
                if ($('#toastContainer').length === 0) {
                    $('body').append(
                        '<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>'
                        );
                }

                $('#toastContainer').append(toastHtml);
                const toastElement = document.getElementById(toastId);
                const toast = new bootstrap.Toast(toastElement, {
                    delay: 3000
                });
                toast.show();

                // Remove after hide
                toastElement.addEventListener('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }

            // Quick status toggle
            $('.status-badge').click(function() {
                const productId = $(this).data('id');
                const currentStatus = $(this).data('status');
                const newStatus = currentStatus === 'active' ? 'inactive' : 'active';

                if (confirm(
                    `Ubah status produk menjadi ${newStatus === 'active' ? 'AKTIF' : 'NONAKTIF'}?`)) {
                    $.ajax({
                        url: `/admin/products/${productId}/toggle-status`,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            status: newStatus
                        },
                        success: function(response) {
                            showToast('Status produk berhasil diubah!', 'success');
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            showToast('Gagal mengubah status!', 'error');
                        }
                    });
                }
            });

            // Featured toggle
            $('.featured-toggle').click(function() {
                const productId = $(this).data('id');
                const isFeatured = $(this).data('featured');
                const newFeatured = isFeatured ? 0 : 1;

                if (confirm(`${newFeatured ? 'Jadikan' : 'Hapus dari'} produk unggulan?`)) {
                    $.ajax({
                        url: `/admin/products/${productId}/toggle-featured`,
                        method: 'POST',
                        data: {
                            _token: '<?php echo e(csrf_token()); ?>',
                            is_featured: newFeatured
                        },
                        success: function(response) {
                            showToast('Status unggulan berhasil diubah!', 'success');
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function(xhr) {
                            showToast('Gagal mengubah status unggulan!', 'error');
                        }
                    });
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/products/index.blade.php ENDPATH**/ ?>