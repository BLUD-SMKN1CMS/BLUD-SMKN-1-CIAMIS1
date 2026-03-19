@extends('admin.layouts.app')

@section('title', 'Kelola Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Layanan</h1>
        <a href="{{ route($routePrefix . '.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Layanan
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Layanan</h6>
            @php
                $hasActiveFilters = request()->filled('status') || request()->filled('is_featured') || request()->filled('tefa_id');
            @endphp
            <div class="d-flex align-items-center gap-2">
                <span class="badge badge-success">
                    Total: {{ $products->total() }}
                </span>
                <div class="dropdown d-inline-block" data-bs-auto-close="outside">
                    <button class="btn btn-sm {{ $hasActiveFilters ? 'btn-primary' : 'btn-outline-primary' }}" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Filter data">
                        <i class="fas fa-filter"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-end p-3 product-filter-dropdown">
                        <h6 class="mb-3 fw-bold text-primary">
                            <i class="fas fa-sliders-h me-2"></i>Filter Layanan
                        </h6>

                        <form method="GET" action="{{ route($routePrefix . '.products.index') }}">
                            <div class="mb-3">
                                <label for="status" class="form-label fw-semibold">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Semua Status</option>
                                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="is_featured" class="form-label fw-semibold">Unggulan</label>
                                <select name="is_featured" id="is_featured" class="form-control">
                                    <option value="">Semua</option>
                                    <option value="1" {{ request('is_featured') === '1' ? 'selected' : '' }}>Unggulan</option>
                                    <option value="0" {{ request('is_featured') === '0' ? 'selected' : '' }}>Bukan Unggulan</option>
                                </select>
                            </div>

                            @if(!auth('admin')->user()?->isAdminTefa())
                            <div class="mb-3">
                                <label for="tefa_id" class="form-label fw-semibold">TEFA</label>
                                <select name="tefa_id" id="tefa_id" class="form-control">
                                    <option value="">Semua TEFA</option>
                                    @foreach($tefas as $tefa)
                                        <option value="{{ $tefa->id }}" {{ (string) request('tefa_id') === (string) $tefa->id ? 'selected' : '' }}>{{ $tefa->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm flex-fill">
                                    <i class="fas fa-check me-1"></i>Terapkan
                                </button>
                                <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                                    <i class="fas fa-rotate-left me-1"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="productsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="40">#</th>
                            <th width="80">Gambar</th>
                            <th>Nama Layanan</th>
                            <th>TEFA</th>
                            <th width="100">Status</th>
                            <th width="90">Unggulan</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                            <td>
                                @if($product->image)
                                <img src="{{ $product->image_url }}"
                                    alt="{{ $product->name }}"
                                    style="width: 50px; height: 50px; object-fit: cover;"
                                    class="rounded border"
                                    onerror="this.onerror=null; this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2250%22%20height%3D%2250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22Arial%22%20font-size%3D%2210%22%20fill%3D%22%236c757d%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3ENo%20Image%3C%2Ftext%3E%3C%2Fsvg%3E';"
                                    title="{{ $product->name }}">
                                @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center border"
                                    style="width: 50px; height: 50px;"
                                    title="Tidak ada gambar">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if ($product->category)
                                <br>
                                <small class="text-muted">{{ $product->category }}</small>
                                @endif
                            </td>
                            <td>
                                @if ($product->tefa)
                                <span class="badge badge-primary">
                                    <i class="fas {{ $product->tefa->icon ?? 'fa-school' }} mr-1"></i>
                                    {{ $product->tefa->code }}
                                </span>
                                <small
                                    class="d-block text-muted">{{ Str::limit($product->tefa->name, 15) }}</small>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span
                                    class="badge
                                    @if ($product->status == 'active') badge-success
                                    @elseif($product->status == 'inactive') badge-secondary
                                    @else badge-warning @endif">
                                    @if ($product->status == 'active')
                                    <i class="fas fa-check-circle mr-1"></i> AKTIF
                                    @elseif($product->status == 'inactive')
                                    <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                    @else
                                    <i class="fas fa-pencil-alt mr-1"></i> DRAFT
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($product->is_featured)
                                <span class="badge bg-warning text-dark" title="Layanan Unggulan">
                                    <i class="fas fa-star mr-1"></i> Unggulan
                                </span>
                                @else
                                <span class="badge bg-light border text-muted" title="Bukan Layanan Unggulan">
                                    <i class="fas fa-star-half-alt mr-1"></i> Biasa
                                </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- DROPDOWN 3 TITIK -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-link text-dark dropdown-toggle p-0" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none;">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route($routePrefix . '.products.show', $product->id) }}">
                                                <i class="fas fa-eye me-2 text-info"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route($routePrefix . '.products.edit', $product->id) }}">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        @if($product->status == 'active')
                                        <li>
                                            <form action="{{ route($routePrefix . '.products.update', $product->id) }}" method="POST" id="toggle-status-inactive-{{ $product->id }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="inactive">
                                            </form>
                                            <button type="submit" form="toggle-status-inactive-{{ $product->id }}" class="dropdown-item text-warning">
                                                <i class="fas fa-ban me-2"></i> Nonaktifkan
                                            </button>
                                        </li>
                                        @else
                                        <li>
                                            <form action="{{ route($routePrefix . '.products.update', $product->id) }}" method="POST" id="toggle-status-active-{{ $product->id }}">
                                                @csrf @method('PUT')
                                                <input type="hidden" name="status" value="active">
                                            </form>
                                            <button type="submit" form="toggle-status-active-{{ $product->id }}" class="dropdown-item text-success">
                                                <i class="fas fa-check me-2"></i> Aktifkan
                                            </button>
                                        </li>
                                        @endif
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <!-- FIXED: Form Delete yang benar -->
                                            <form action="{{ route($routePrefix . '.products.destroy', $product->id) }}"
                                                method="POST" id="delete-form-{{ $product->id }}"
                                                onsubmit="return confirm('Hapus layanan {{ $product->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                            <button type="submit" form="delete-form-{{ $product->id }}"
                                                class="dropdown-item text-danger text-decoration-none w-100 text-start">
                                                <i class="fas fa-trash me-2"></i> Hapus
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-3x mb-4" style="opacity: 0.5;"></i>
                                    <p class="mb-4">Belum ada data layanan</p>
                                    <a href="{{ route($routePrefix . '.products.create') }}" class="btn btn-primary rounded-circle" style="width: 60px; height: 60px; display: inline-flex; align-items: center; justify-content: center; font-size: 24px;">
                                        <i class="fas fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
            <div class="mt-3 d-flex justify-content-center">
                {{ $products->links('vendor.pagination.admin-pill') }}
            </div>
            @endif


        </div>
    </div>
</div>
@endsection

@push('styles')
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

    .product-filter-dropdown {
        min-width: 320px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 12px 24px rgba(15, 23, 42, 0.16);
    }

    .product-filter-dropdown .form-label {
        font-size: 0.82rem;
        margin-bottom: 0.35rem;
        color: #374151;
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
@endpush

@push('scripts')
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
                    `Ubah status layanan menjadi ${newStatus === 'active' ? 'AKTIF' : 'NONAKTIF'}?`)) {
                $.ajax({
                    url: `/admin/products/${productId}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: newStatus
                    },
                    success: function(response) {
                        showToast('Status layanan berhasil diubah!', 'success');
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

            if (confirm(`${newFeatured ? 'Jadikan' : 'Hapus dari'} layanan unggulan?`)) {
                $.ajax({
                    url: `/admin/products/${productId}/toggle-featured`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
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
@endpush

