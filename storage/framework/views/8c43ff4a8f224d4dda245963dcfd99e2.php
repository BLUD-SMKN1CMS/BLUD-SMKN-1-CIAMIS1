<?php $__env->startSection('title', 'Kelola Carousel'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Carousel</h1>
            <a href="<?php echo e(route('admin.carousels.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Carousel Baru
            </a>
        </div>

        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i><?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Carousel</h6>
            </div>
            <div class="card-body">
                <?php if($carousels->isEmpty()): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                        <p class="text-muted">Belum ada carousel. Tambahkan carousel pertama Anda!</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th width="100">Preview</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Urutan</th>
                                    <th>Tanggal</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                <?php $__currentLoopData = $carousels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $carousel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr data-id="<?php echo e($carousel->id); ?>">
                                        <td><?php echo e(($carousels->currentPage() - 1) * $carousels->perPage() + $loop->iteration); ?>

                                        </td>
                                        <td>
                                            <?php if($carousel->image): ?>
                                                <img src="<?php echo e(asset('storage/' . $carousel->image)); ?>"
                                                    alt="<?php echo e($carousel->title); ?>" class="img-thumbnail"
                                                    style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;"
                                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                <div class="bg-light text-center d-none align-items-center justify-content-center"
                                                    style="width: 80px; height: 45px; border: 1px dashed #ddd; border-radius: 4px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php else: ?>
                                                <div class="bg-light text-center d-flex align-items-center justify-content-center"
                                                    style="width: 80px; height: 45px; border: 1px dashed #ddd; border-radius: 4px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo e($carousel->title); ?></strong><br>
                                            <small class="text-muted"><?php echo e(Str::limit($carousel->description, 50)); ?></small>
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-<?php echo e($carousel->status === 'active' ? 'success' : 'secondary'); ?>">
                                                <?php echo e($carousel->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-info"><?php echo e($carousel->order); ?></span>
                                        </td>
                                        <td><?php echo e($carousel->created_at->format('d/m/Y')); ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="<?php echo e(route('admin.carousels.edit', $carousel->id)); ?>">
                                                            <i class="fas fa-edit me-2 text-warning"></i> Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="<?php echo e(route('admin.carousels.toggle-status', $carousel->id)); ?>"
                                                            method="POST" class="dropdown-item p-0">
                                                            <?php echo csrf_field(); ?>
                                                            <button type="submit"
                                                                class="dropdown-item text-decoration-none w-100 text-start">
                                                                <i
                                                                    class="fas fa-<?php echo e($carousel->status === 'active' ? 'eye-slash' : 'eye'); ?> me-2 text-<?php echo e($carousel->status === 'active' ? 'secondary' : 'success'); ?>"></i>
                                                                <?php echo e($carousel->status === 'active' ? 'Nonaktifkan' : 'Aktifkan'); ?>

                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form
                                                            action="<?php echo e(route('admin.carousels.destroy', $carousel->id)); ?>"
                                                            method="POST" class="dropdown-item p-0">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                            <button type="submit"
                                                                class="dropdown-item text-danger text-decoration-none w-100 text-start"
                                                                onclick="return confirm('Hapus carousel ini?')">
                                                                <i class="fas fa-trash me-2"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1"></i>
                            Menampilkan <strong><?php echo e($carousels->firstItem()); ?></strong> -
                            <strong><?php echo e($carousels->lastItem()); ?></strong> dari <strong><?php echo e($carousels->total()); ?></strong>
                            carousel
                        </div>
                        <nav aria-label="Pagination">
                            <?php echo e($carousels->links('pagination::bootstrap-5')); ?>

                        </nav>
                    </div>

                    <!-- Sorting Info -->
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="fas fa-arrows-alt me-2"></i>
                        <strong>Tips:</strong> Drag & drop baris tabel untuk mengubah urutan carousel
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        .table tbody tr {
            cursor: move;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .img-thumbnail {
            border-radius: 4px;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .dropdown-menu {
            min-width: 180px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            border: 1px solid #eee;
        }

        .dropdown-item {
            padding: 8px 15px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(3px);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
        }

        /* Pagination Styling */
        .pagination {
            margin-bottom: 0;
            gap: 5px;
        }

        .pagination .page-link {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            color: #4e73df;
            padding: 8px 14px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .pagination .page-link:hover {
            background-color: #4e73df;
            border-color: #4e73df;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
        }

        .pagination .page-item.active .page-link {
            background-color: #4e73df;
            border-color: #4e73df;
            box-shadow: 0 2px 8px rgba(78, 115, 223, 0.3);
        }

        .pagination .page-item.disabled .page-link {
            cursor: not-allowed;
            opacity: 0.5;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <!-- Sortable JS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize dropdowns
            document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el) {
                new bootstrap.Dropdown(el);
            });

            // Initialize sortable
            const sortable = new Sortable(document.getElementById('sortable'), {
                animation: 150,
                ghostClass: 'bg-light',
                onEnd: function(evt) {
                    updateOrder();
                }
            });

            // Update order via AJAX
            function updateOrder() {
                const order = [];
                $('#sortable tr').each(function(index) {
                    order.push($(this).data('id'));
                });

                $.ajax({
                    url: '<?php echo e(route('admin.carousels.update-order')); ?>',
                    method: 'POST',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>',
                        order: order
                    },
                    success: function(response) {
                        // Update row numbers
                        $('#sortable tr').each(function(index) {
                            $(this).find('td:first').text(index + 1);
                        });

                        // Show success message
                        showToast('Urutan carousel berhasil diperbarui!', 'success');
                    },
                    error: function(xhr) {
                        showToast('Gagal memperbarui urutan!', 'error');
                    }
                });
            }

            function showToast(message, type) {
                const toast = $(`
                <div class="toast align-items-center text-bg-${type === 'success' ? 'success' : 'danger'} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}-circle me-2"></i>
                            ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `);

                $('#toastContainer').append(toast);
                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();

                // Remove after hide
                toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/carousels/index.blade.php ENDPATH**/ ?>