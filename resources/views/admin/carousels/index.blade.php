@extends('admin.layouts.app')

@section('title', 'Kelola Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Carousel</h1>
        <a href="{{ route($routePrefix . '.carousels.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Carousel Baru
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Carousel</h6>
        </div>
        <div class="card-body">
            @if ($carousels->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">Belum ada carousel. Tambahkan carousel pertama Anda!</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover" id="dataTable">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th width="100">Preview</th>
                            <th>Status</th>
                            <th>Urutan</th>
                            <th>Tanggal</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @foreach ($carousels as $carousel)
                        <tr data-id="{{ $carousel->id }}">
                            <td>{{ ($carousels->currentPage() - 1) * $carousels->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                @if ($carousel->image)
                                <img src="{{ $carousel->image_url }}"
                                    alt="Carousel {{ $carousel->id }}" class="img-thumbnail"
                                    style="width: 80px; height: 45px; object-fit: cover; border-radius: 4px;"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-light text-center d-none align-items-center justify-content-center"
                                    style="width: 80px; height: 45px; border: 1px dashed #ddd; border-radius: 4px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @else
                                <div class="bg-light text-center d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 45px; border: 1px dashed #ddd; border-radius: 4px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge bg-{{ $carousel->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ $carousel->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $carousel->order }}</span>
                            </td>
                            <td>{{ $carousel->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="action-kebab dropdown-toggle"
                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route($routePrefix . '.carousels.edit', $carousel->id) }}">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route($routePrefix . '.carousels.toggle-status', $carousel->id) }}"
                                                method="POST" class="dropdown-item p-0">
                                                @csrf
                                                <button type="submit"
                                                    class="dropdown-item text-decoration-none w-100 text-start">
                                                    <i
                                                        class="fas fa-{{ $carousel->status === 'active' ? 'eye-slash' : 'eye' }} me-2 text-{{ $carousel->status === 'active' ? 'secondary' : 'success' }}"></i>
                                                    {{ $carousel->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route($routePrefix . '.carousels.destroy', $carousel->id) }}"
                                                method="POST" class="dropdown-item p-0">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="dropdown-item text-danger text-decoration-none w-100 text-start"
                                                    onclick="confirmDelete(event, 'Carousel yang dihapus tidak bisa dikembalikan. Lanjut hapus?')">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Menampilkan <strong>{{ $carousels->firstItem() }}</strong> -
                    <strong>{{ $carousels->lastItem() }}</strong> dari <strong>{{ $carousels->total() }}</strong>
                    carousel
                </div>
                <nav aria-label="Pagination">
                    {{ $carousels->links('vendor.pagination.admin-pill') }}
                </nav>
            </div>

            <!-- Sorting Info -->
            <div class="alert alert-info border-0 shadow-sm">
                <i class="fas fa-arrows-alt me-2"></i>
                <strong>Tips:</strong> Drag & drop baris tabel untuk mengubah urutan carousel
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
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

    .action-kebab {
        border: 0;
        background: transparent;
        color: #6b7280;
        padding: 0.25rem 0.4rem;
        line-height: 1;
        border-radius: 6px;
    }

    .action-kebab:hover {
        color: #374151;
        background: transparent;
    }

    .action-kebab:focus,
    .action-kebab:focus-visible {
        outline: none;
        box-shadow: none;
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
@endpush

@push('scripts')
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
                url: "{{ route($routePrefix . '.carousels.update-order') }}",
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
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
@endpush