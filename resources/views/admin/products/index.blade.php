@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kelola Produk</h1>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Produk</h6>
            <div>
                <span class="badge badge-success mr-2">
                    Total: {{ $products->count() }}
                </span>
                <span class="badge badge-info">
                    Unggulan: {{ $products->where('is_featured', true)->count() }}
                </span>
                <span class="badge badge-warning ml-2">
                    Aktif: {{ $products->where('status', 'active')->count() }}
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
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @php
                                    // Cek apakah gambar ada di storage
                                    $imagePath = $product->image;
                                    $hasImage = $imagePath && file_exists(public_path($imagePath));
                                    
                                    // Buat placeholder jika tidak ada gambar
                                    $placeholder = 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%2250%22%20height%3D%2250%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Crect%20width%3D%22100%25%22%20height%3D%22100%25%22%20fill%3D%22%23f8f9fa%22%2F%3E%3Ctext%20x%3D%2250%25%22%20y%3D%2250%25%22%20font-family%3D%22Arial%22%20font-size%3D%228%22%20fill%3D%22%236c757d%22%20text-anchor%3D%22middle%22%20dy%3D%22.3em%22%3E' . urlencode(substr($product->name, 0, 10)) . '%3C%2Ftext%3E%3C%2Fsvg%3E';
                                @endphp
                                
                                @if($hasImage)
                                    <img src="{{ asset($imagePath) }}" 
                                         alt="{{ $product->name }}" 
                                         style="width: 50px; height: 50px; object-fit: cover;" 
                                         class="rounded border"
                                         onerror="this.src='{{ $placeholder }}'"
                                         title="{{ $product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" 
                                         style="width: 50px; height: 50px;"
                                         title="Gambar tidak tersedia: {{ basename($imagePath ?? 'Tidak ada') }}">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->category)
                                    <br>
                                    <small class="text-muted">{{ $product->category }}</small>
                                @endif
                            </td>
                            <td>
                                @if($product->tefa)
                                    <span class="badge badge-primary">
                                        <i class="fas {{ $product->tefa->icon ?? 'fa-school' }} mr-1"></i>
                                        {{ $product->tefa->code }}
                                    </span>
                                    <small class="d-block text-muted">{{ Str::limit($product->tefa->name, 15) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <strong class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($product->status == 'active') badge-success
                                    @elseif($product->status == 'inactive') badge-secondary
                                    @else badge-warning @endif">
                                    @if($product->status == 'active')
                                        <i class="fas fa-check-circle mr-1"></i> AKTIF
                                    @elseif($product->status == 'inactive')
                                        <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                    @else
                                        <i class="fas fa-pencil-alt mr-1"></i> DRAFT
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">
                                @if($product->is_featured)
                                    <span class="badge badge-warning" title="Produk Unggulan">
                                        <i class="fas fa-star"></i>
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <!-- DROPDOWN 3 TITIK -->
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.products.show', $product->id) }}">
                                                <i class="fas fa-eye me-2 text-info"></i> Lihat Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">
                                                <i class="fas fa-edit me-2 text-warning"></i> Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <!-- FIXED: Form Delete yang benar -->
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  id="delete-form-{{ $product->id }}"
                                                  onsubmit="return confirm('Hapus produk {{ $product->name }}?')">
                                                @csrf 
                                                @method('DELETE')
                                            </form>
                                            <button type="submit" 
                                                    form="delete-form-{{ $product->id }}"
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
                            <td colspan="8" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="fas fa-box-open fa-2x mb-3"></i>
                                    <p>Belum ada data produk</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus mr-1"></i> Tambah Produk Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($products->count() > 0)
            <div class="mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            Menampilkan {{ $products->count() }} produk
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
    
    /* CSS DROPDOWN */
    .dropdown-toggle::after {
        display: none !important;
    }
    .dropdown-menu {
        min-width: 180px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
        #productsTable td, #productsTable th {
            padding: 0.5rem;
        }
        .dropdown-menu {
            min-width: 150px;
        }
    }
</style>
@endpush

@push('scripts')
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
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
            $('body').append('<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }
        
        $('#toastContainer').append(toastHtml);
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();
        
        // Remove after hide
        toastElement.addEventListener('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
    
    // Quick status toggle
    $('.status-badge').click(function() {
        const productId = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        if (confirm(`Ubah status produk menjadi ${newStatus === 'active' ? 'AKTIF' : 'NONAKTIF'}?`)) {
            $.ajax({
                url: `/admin/products/${productId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
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