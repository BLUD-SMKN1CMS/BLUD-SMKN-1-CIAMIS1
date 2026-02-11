<?php $__env->startSection('title', 'Kelola Pesan Kontak'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pesan Kontak</h1>
        <div>
            <button type="button" class="btn btn-danger" id="bulkDeleteBtn" style="display:none;">
                <i class="fas fa-trash"></i> Hapus Terpilih
            </button>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo e(session('error')); ?>

            <button type="button" class="close" data-dismiss="alert">×</button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pesan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form id="bulkDeleteForm" action="<?php echo e(route('admin.contacts.bulkDelete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="ids" id="bulkDeleteIds">
                    
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="30">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Subjek</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th width="100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="<?php echo e($contact->status == 'unread' ? 'table-warning' : ''); ?>">
                                <td>
                                    <input type="checkbox" class="contact-checkbox" value="<?php echo e($contact->id); ?>">
                                </td>
                                <td><?php echo e($loop->iteration); ?></td>
                                <td><?php echo e($contact->name); ?></td>
                                <td><?php echo e($contact->email); ?></td>
                                <td><?php echo e(Str::limit($contact->subject, 30)); ?></td>
                                <td>
                                    <span class="badge 
                                        <?php if($contact->status == 'unread'): ?> badge-danger
                                        <?php elseif($contact->status == 'read'): ?> badge-warning
                                        <?php elseif($contact->status == 'replied'): ?> badge-success
                                        <?php else: ?> badge-secondary <?php endif; ?>">
                                        <?php echo e(strtoupper($contact->status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($contact->created_at->format('d M Y')); ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                type="button" 
                                                data-bs-toggle="dropdown" 
                                                aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.contacts.show', $contact->id)); ?>">
                                                    <i class="fas fa-eye me-2 text-info"></i> Lihat
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="<?php echo e(route('admin.contacts.edit', $contact->id)); ?>">
                                                    <i class="fas fa-edit me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="<?php echo e(route('admin.contacts.destroy', $contact->id)); ?>" method="POST" class="dropdown-item p-0">
                                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="dropdown-item text-danger text-decoration-none w-100 text-start" 
                                                            onclick="return confirm('Hapus pesan ini?')">
                                                        <i class="fas fa-trash me-2"></i> Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-envelope fa-2x text-muted mb-2"></i>
                                    <p>Belum ada pesan kontak</p>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </form>
                
                <?php if($contacts->hasPages()): ?>
                <div class="d-flex justify-content-center mt-3">
                    <?php echo e($contacts->links()); ?>

                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .dropdown-toggle::after {
        display: none !important;
    }
    .dropdown-menu {
        min-width: 180px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
    .table-warning {
        background-color: #fff3cd !important;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Select all checkbox
    $('#selectAll').change(function() {
        $('.contact-checkbox').prop('checked', this.checked);
        toggleBulkDeleteBtn();
    });
    
    // Individual checkbox
    $('.contact-checkbox').change(function() {
        if (!this.checked) {
            $('#selectAll').prop('checked', false);
        }
        toggleBulkDeleteBtn();
    });
    
    function toggleBulkDeleteBtn() {
        var checkedCount = $('.contact-checkbox:checked').length;
        if (checkedCount > 0) {
            $('#bulkDeleteBtn').show().text('Hapus ' + checkedCount + ' Pesan');
        } else {
            $('#bulkDeleteBtn').hide();
        }
    }
    
    // Bulk delete
    $('#bulkDeleteBtn').click(function() {
        var ids = [];
        $('.contact-checkbox:checked').each(function() {
            ids.push($(this).val());
        });
        
        if (ids.length > 0 && confirm('Hapus ' + ids.length + ' pesan terpilih?')) {
            $('#bulkDeleteIds').val(JSON.stringify(ids));
            $('#bulkDeleteForm').submit();
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\BLUD-SMKN-1-CIAMIS\resources\views/admin/contacts/index.blade.php ENDPATH**/ ?>