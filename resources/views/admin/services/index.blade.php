@extends('admin.layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Layanan</h1>
        <a href="{{ route($routePrefix . '.services.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Layanan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Layanan</h6>
            <span class="badge badge-success">
                Total: {{ $services->total() }}
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Icon</th>
                            <th>Nama Layanan</th>
                            <th>Status</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($services as $service)
                        <tr>
                            <td>{{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}</td>
                            <td class="text-center">
                                <i class="{{ $service->icon ?? 'fas fa-concierge-bell' }} fa-lg text-primary"></i>
                            </td>
                            <td>{{ $service->name }}</td>
                            <td>
                                <span
                                    class="badge {{ $service->status == 'available' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ strtoupper($service->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-dark dropdown-toggle p-0" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route($routePrefix . '.services.edit', $service->id) }}">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <button type="button" class="dropdown-item btn-view-service"
                                                data-name="{{ $service->name }}"
                                                data-slug="{{ $service->slug }}"
                                                data-status="{{ strtoupper($service->status) }}"
                                                data-created="{{ $service->created_at->format('d M Y H:i') }}">
                                                <i class="fas fa-eye me-2 text-info"></i> Lihat
                                            </button>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form action="{{ route($routePrefix . '.services.destroy', $service->id) }}"
                                                method="POST" class="dropdown-item p-0">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="dropdown-item text-danger text-decoration-none w-100 text-start"
                                                    onclick="return confirm('Hapus layanan ini?')">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-handshake fa-3x mb-4" style="opacity: 0.5;"></i>
                                    <p class="mb-4">Belum ada data layanan</p>
                                    <a href="{{ route($routePrefix . '.services.create') }}" class="btn btn-primary rounded-circle" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px;">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($services->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $services->links('vendor.pagination.admin-pill') }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Detail Layanan -->
<div class="modal fade" id="detailServiceModal" tabindex="-1" aria-labelledby="detailServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailServiceModalLabel">
                    <i class="fas fa-eye me-2"></i>Detail Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <tbody>
                            <tr>
                                <th width="30%">Nama Layanan</th>
                                <td id="detail_name">-</td>
                            </tr>
                            <tr>
                                <th>Slug URL</th>
                                <td id="detail_slug">-</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td id="detail_status">-</td>
                            </tr>
                            <tr>
                                <th>Dibuat</th>
                                <td id="detail_created">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Layanan -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editServiceModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Layanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editServiceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_service_id">

                    <div class="form-group mb-3">
                        <label>Nama Layanan *</label>
                        <input type="text" name="name" id="edit_name" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" id="edit_description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label>Pilih Icon</label>
                        <div class="input-group">
                            <input type="text" name="icon" class="form-control" id="edit_icon" readonly>
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#iconModalEdit">
                                <i class="fas fa-icons"></i> Pilih Icon
                            </button>
                        </div>
                        <div class="mt-2" id="edit_iconPreview">
                            <div class="border rounded p-3 text-center">
                                <i id="edit_icon_preview" class="fas fa-concierge-bell fa-2x mb-2 text-primary"></i>
                                <p class="mb-0 small text-muted" id="edit_icon_name">fas fa-concierge-bell</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>Status *</label>
                        <select name="status" id="edit_status" class="form-control">
                            <option value="available">Tersedia</option>
                            <option value="unavailable">Tidak Tersedia</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Layanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Pilih Icon (Edit) -->
<div class="modal fade" id="iconModalEdit" tabindex="-1" aria-labelledby="iconModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="iconModalEditLabel">
                    <i class="fas fa-icons me-2"></i>Pilih Icon FontAwesome
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control" id="iconSearchEdit" placeholder="Cari icon...">
                    </div>
                </div>

                <div class="icon-grid" id="iconGridEdit" style="max-height: 400px; overflow-y: auto;">
                    <!-- Icon akan diisi oleh JavaScript -->
                </div>

                <div class="mt-3 alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Klik icon untuk memilih. Icon yang dipilih:
                    <strong id="currentSelectedIconEdit">fas fa-concierge-bell</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="selectIconBtnEdit">
                    <i class="fas fa-check me-1"></i> Pilih Icon
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
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

    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 12px;
        padding: 10px;
    }

    .icon-item {
        padding: 15px;
        text-align: center;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .icon-item:hover {
        background-color: #f8f9fa;
        border-color: #4A90E2;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .icon-item.selected {
        background-color: #e3f2fd;
        border-color: #4A90E2;
        border-width: 3px;
    }

    .icon-item i {
        font-size: 28px;
        margin-bottom: 8px;
        color: #4A90E2;
    }

    .icon-name {
        font-size: 11px;
        word-break: break-word;
        color: #495057;
        font-weight: 500;
    }

    #edit_icon[readonly] {
        background-color: #f8f9fa;
        cursor: pointer;
    }
</style>
@endpush
@push('scripts')
<script>
    $(document).ready(function() {
        // Reinitialize dropdowns for dynamically loaded content
        document.querySelectorAll('[data-bs-toggle="dropdown"]').forEach(function(el) {
            new bootstrap.Dropdown(el);
        });

        // Icon list
        const popularIcons = [
            'fas fa-concierge-bell', 'fas fa-utensils', 'fas fa-bed',
            'fas fa-wifi', 'fas fa-tv', 'fas fa-shower',
            'fas fa-swimming-pool', 'fas fa-dumbbell', 'fas fa-spa',
            'fas fa-parking', 'fas fa-bus', 'fas fa-taxi',
            'fas fa-coffee', 'fas fa-cocktail', 'fas fa-birthday-cake',
            'fas fa-camera', 'fas fa-music', 'fas fa-gamepad',
            'fas fa-store', 'fas fa-shopping-cart', 'fas fa-credit-card',
            'fas fa-money-bill', 'fas fa-clock', 'fas fa-calendar-alt',
            'fas fa-map-marker-alt', 'fas fa-phone', 'fas fa-envelope',
            'fas fa-user', 'fas fa-users', 'fas fa-child',
            'fas fa-wheelchair', 'fas fa-paw', 'fas fa-smoking-ban',
            'fas fa-building', 'fas fa-home', 'fas fa-door-open',
            'fas fa-warehouse', 'fas fa-store-alt', 'fas fa-hotel',
            'fas fa-archway', 'fas fa-dungeon', 'fas fa-place-of-worship',
            'fas fa-restroom', 'fas fa-person-booth', 'fas fa-hospital',
            'fas fa-school', 'fas fa-city', 'fas fa-landmark',
            'fas fa-campground', 'fas fa-industry'
        ];

        let selectedIconEdit = 'fas fa-concierge-bell';

        // Load icons for edit modal
        function loadIconsEdit(search = '') {
            $('#iconGridEdit').empty();

            const filteredIcons = popularIcons.filter(icon =>
                icon.toLowerCase().includes(search.toLowerCase())
            );

            filteredIcons.forEach(icon => {
                const iconName = icon.replace('fas fa-', '');
                const isSelected = icon === selectedIconEdit;

                $('#iconGridEdit').append(`
                <div class="icon-item ${isSelected ? 'selected' : ''}" data-icon="${icon}">
                    <i class="${icon}"></i>
                    <div class="icon-name">${iconName}</div>
                </div>
            `);
            });

            $('#currentSelectedIconEdit').text(selectedIconEdit);
        }

        // Icon search for edit
        $('#iconSearchEdit').on('input', function() {
            loadIconsEdit($(this).val());
        });

        // Icon selection for edit
        $(document).on('click', '#iconGridEdit .icon-item', function() {
            $('#iconGridEdit .icon-item').removeClass('selected');
            $(this).addClass('selected');
            selectedIconEdit = $(this).data('icon');
            $('#currentSelectedIconEdit').text(selectedIconEdit);
        });

        // Select icon button for edit
        $('#selectIconBtnEdit').click(function() {
            if (selectedIconEdit) {
                $('#edit_icon').val(selectedIconEdit);
                $('#edit_icon_preview').attr('class', selectedIconEdit + ' fa-2x mb-2 text-primary');
                $('#edit_icon_name').text(selectedIconEdit);

                const iconModal = bootstrap.Modal.getInstance(document.getElementById('iconModalEdit'));
                if (iconModal) {
                    iconModal.hide();
                }
            }
        });

        // Make readonly input clickable
        $('#edit_icon').click(function() {
            const iconModal = new bootstrap.Modal(document.getElementById('iconModalEdit'));
            loadIconsEdit();
            iconModal.show();
        });

        // Open edit modal
        $('.btn-edit-service').click(function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');
            const icon = $(this).data('icon');
            const status = $(this).data('status');

            // Fill form
            $('#edit_service_id').val(id);
            $('#edit_name').val(name);
            $('#edit_description').val(description);
            $('#edit_icon').val(icon);
            $('#edit_status').val(status);

            // Update icon preview
            selectedIconEdit = icon;
            $('#edit_icon_preview').attr('class', icon + ' fa-2x mb-2 text-primary');
            $('#edit_icon_name').text(icon);

            // Set form action
            $('#editServiceForm').attr('action', '/admin/services/' + id);

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editServiceModal'));
            editModal.show();
        });

        // Open detail modal
        $('.btn-view-service').click(function() {
            const name = $(this).data('name');
            const slug = $(this).data('slug');
            const status = $(this).data('status');
            const created = $(this).data('created');

            $('#detail_name').text(name || '-');
            $('#detail_slug').text(`/layanan/${slug}`);
            $('#detail_status').text(status || '-');
            $('#detail_created').text(created || '-');

            const detailModal = new bootstrap.Modal(document.getElementById('detailServiceModal'));
            detailModal.show();
        });

        // Submit edit form
        $('#editServiceForm').submit(function(e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const actionUrl = $(this).attr('action');

            $.ajax({
                url: actionUrl,
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Close modal
                    const editModal = bootstrap.Modal.getInstance(document.getElementById('editServiceModal'));
                    if (editModal) {
                        editModal.hide();
                    }

                    // Show success message and reload
                    alert('Layanan berhasil diperbarui!');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan: ' + (xhr.responseJSON?.message || 'Silakan coba lagi'));
                }
            });
        });
    });
</script>
@endpush
