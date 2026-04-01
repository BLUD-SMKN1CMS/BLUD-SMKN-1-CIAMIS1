@extends('admin.layouts.app')

@section('title', 'Detail Layanan: ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Layanan</h1>
        <div class="btn-group" role="group">
            <a href="{{ route($routePrefix . '.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">Ã—</button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">Ã—</button>
    </div>
    @endif

    @php
    $tefaShowRouteName = $routePrefix . '.tefas.show';
    $tefaEditRouteName = $routePrefix . '.tefas.edit';
    $tefaCreateRouteName = $routePrefix . '.tefas.create';
    $toggleFeaturedRouteName = $routePrefix . '.products.toggle-featured';
    $isAdminTefa = auth('admin')->user()?->isAdminTefa();

    $hasTefaShowRoute = \Illuminate\Support\Facades\Route::has($tefaShowRouteName);
    $hasTefaEditRoute = \Illuminate\Support\Facades\Route::has($tefaEditRouteName);
    $hasTefaCreateRoute = \Illuminate\Support\Facades\Route::has($tefaCreateRouteName);
    $hasToggleFeaturedRoute = \Illuminate\Support\Facades\Route::has($toggleFeaturedRouteName);
    @endphp

    <div class="row">
        <!-- Kolom Kiri: Informasi Layanan -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-box mr-2"></i> {{ $product->name }}
                    </h6>
                    <div>
                        <span class="badge badge-secondary">
                            ID: {{ $product->id }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Gambar Layanan -->
                        <div class="col-md-5 mb-4 mb-md-0">
                            @php
                            $imagePath = $product->image;
                            $hasImage = $imagePath && file_exists(public_path($imagePath));
                            $placeholder = 'https://via.placeholder.com/400x300/4A90E2/FFFFFF?text=' . urlencode(substr($product->name, 0, 30));
                            @endphp

                            <div class="text-center">
                                <div class="product-image-container mb-3">
                                    @if($hasImage)
                                    <img src="{{ asset($imagePath) }}"
                                        alt="{{ $product->name }}"
                                        class="img-fluid rounded shadow-lg"
                                        style="max-height: 300px; object-fit: contain;"
                                        onerror="this.src='{{ $placeholder }}'"
                                        id="productMainImage">
                                    @else
                                    <div class="bg-light rounded shadow-lg d-flex flex-column align-items-center justify-content-center py-5"
                                        style="height: 300px;">
                                        <i class="fas fa-image fa-4x text-muted mb-3"></i>
                                        <p class="text-muted mb-1">Tidak ada gambar</p>
                                        @if($imagePath)
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            File: {{ basename($imagePath) }}
                                        </small>
                                        @endif
                                    </div>
                                    @endif
                                </div>

                                @if($hasImage)
                                <div class="mt-3">
                                    <a href="{{ asset($imagePath) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt mr-1"></i> Buka Gambar
                                    </a>
                                    <button class="btn btn-sm btn-outline-secondary"
                                        onclick="copyToClipboard('{{ asset($imagePath) }}')">
                                        <i class="fas fa-copy mr-1"></i> Salin URL
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Detail Layanan -->
                        <div class="col-md-7">
                            <table class="table table-bordered table-hover">
                                <tbody>
                                    <tr>
                                        <th width="35%" class="bg-light">Nama Layanan</th>
                                        <td>
                                            <strong>{{ $product->name }}</strong>
                                            @if($product->is_featured)
                                            <span class="badge badge-warning ml-2">
                                                <i class="fas fa-star mr-1"></i> UNGGULAN
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if(!$isAdminTefa)
                                    <tr>
                                        <th class="bg-light">TEFA</th>
                                        <td>
                                            @if($product->tefa)
                                            <span class="badge badge-primary">
                                                <i class="fas {{ $product->tefa->icon ?? 'fa-school' }} mr-1"></i>
                                                {{ $product->tefa->code }}
                                            </span>
                                            {{ $product->tefa->name }}
                                            @if($hasTefaShowRoute)
                                            <a href="{{ route($tefaShowRouteName, $product->tefa->id) }}"
                                                class="btn btn-sm btn-outline-primary ml-2">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            @endif
                                            @else
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Belum memiliki TEFA
                                            </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif

                                    <tr>
                                        <th class="bg-light">Kategori</th>
                                        <td>
                                            <span class="badge badge-info">{{ $product->category }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            <span class="badge
                                                @if($product->status == 'active') badge-success
                                                @elseif($product->status == 'inactive') badge-secondary
                                                @else badge-warning @endif"
                                                style="font-size: 0.9rem; padding: 0.4rem 0.8rem;">
                                                @if($product->status == 'active')
                                                <i class="fas fa-check-circle mr-1"></i> AKTIF
                                                @elseif($product->status == 'inactive')
                                                <i class="fas fa-times-circle mr-1"></i> NONAKTIF
                                                @else
                                                <i class="fas fa-pencil-alt mr-1"></i> DRAFT
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                    @if($hasToggleFeaturedRoute)
                                    <tr>
                                        <th class="bg-light">Unggulan</th>
                                        <td>
                                            <form action="{{ route($toggleFeaturedRouteName, $product->id) }}" method="POST" class="d-flex align-items-center gap-2 mb-0">
                                                @csrf
                                                <input type="hidden" name="is_featured" value="0">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_featured" name="is_featured" {{ $product->is_featured ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        Jadikan layanan unggulan
                                                    </label>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-outline-primary ml-2">Simpan</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th class="bg-light">Urutan Tampilan</th>
                                        <td>
                                            <span class="badge badge-secondary">{{ $product->order }}</span>
                                            <small class="text-muted ml-2">(Angka kecil = tampil lebih awal)</small>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th class="bg-light">Dibuat</th>
                                        <td>
                                            <i class="far fa-calendar-alt mr-1 text-muted"></i>
                                            {{ $product->created_at->format('d F Y') }}
                                            <small class="text-muted ml-2">
                                                ({{ $product->created_at->diffForHumans() }})
                                            </small>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Terakhir Diupdate</th>
                                        <td>
                                            <i class="far fa-clock mr-1 text-muted"></i>
                                            {{ $product->updated_at->format('d F Y H:i') }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Deskripsi Layanan -->
                    <div class="mt-4">
                        <h5 class="border-bottom pb-2 mb-3">
                            <i class="fas fa-align-left mr-2 text-primary"></i>Deskripsi Layanan
                        </h5>
                        <div class="p-4 rounded bg-light border">
                            @if($product->description)
                            {{ $product->description }}
                            @else
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-info-circle fa-2x mb-3"></i>
                                <p class="mb-0">Belum ada deskripsi layanan</p>
                                <small>Tambahkan deskripsi di halaman edit</small>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Informasi -->
        <div class="col-lg-4">
            <!-- Informasi TEFA -->
            <div class="card shadow">
                <div class="card-header py-3 bg-info text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-school mr-2"></i>Informasi TEFA
                    </h6>
                </div>
                <div class="card-body">
                    @if($product->tefa)
                    <div class="text-center mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="fas {{ $product->tefa->icon ?? 'fa-school' }} fa-2x text-white"></i>
                        </div>
                        <h5 class="mb-1">{{ $product->tefa->name }}</h5>
                        <p class="text-muted mb-2">({{ $product->tefa->code }})</p>
                    </div>

                    <table class="table table-sm">
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge {{ $product->tefa->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $product->tefa->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Urutan:</strong></td>
                            <td>{{ $product->tefa->order }}</td>
                        </tr>
                        <tr>
                            <td><strong>Layanan:</strong></td>
                            <td>{{ $product->tefa->products_count ?? 0 }} layanan</td>
                        </tr>
                    </table>

                    <div class="mt-3 text-center">
                        @if($hasTefaShowRoute)
                        <a href="{{ route($tefaShowRouteName, $product->tefa->id) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt mr-1"></i> Detail TEFA
                        </a>
                        @endif

                        @if($hasTefaEditRoute)
                        <a href="{{ route($tefaEditRouteName, $product->tefa->id) }}"
                            class="btn btn-outline-warning btn-sm {{ $hasTefaShowRoute ? 'ml-2' : '' }}">
                            <i class="fas fa-edit mr-1"></i> Edit TEFA
                        </a>
                        @endif
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mb-3"></i>
                        <p class="text-muted mb-0">Layanan ini belum memiliki TEFA</p>
                        <small class="text-muted">Tambahkan TEFA di halaman edit layanan</small>
                        @if($hasTefaCreateRoute)
                        <div class="mt-3">
                            <a href="{{ route($tefaCreateRouteName) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus mr-1"></i> Buat TEFA Baru
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <!-- Statistik -->
            <div class="card shadow mt-4">
                <div class="card-header py-3 bg-secondary text-white">
                    <h6 class="m-0 font-weight-bold">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-primary">{{ $product->order }}</div>
                                <small class="text-muted">Urutan</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-success">
                                    {{ $product->status == 'active' ? 'âœ“' : 'âœ—' }}
                                </div>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-warning">
                                    {{ $product->is_featured ? 'â˜…' : 'â˜†' }}
                                </div>
                                <small class="text-muted">Unggulan</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="h4 mb-0 text-info">
                                    {{ $product->tefa ? 'âœ“' : 'âœ—' }}
                                </div>
                                <small class="text-muted">TEFA</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .product-image-container img {
        transition: transform 0.3s;
    }

    .product-image-container:hover img {
        transform: scale(1.05);
    }

    .list-group-item-action:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: all 0.3s;
    }

    .card-header.bg-primary,
    .card-header.bg-info,
    .card-header.bg-secondary {
        border-radius: 0.35rem 0.35rem 0 0 !important;
    }

    @media print {

        .btn,
        .card-header.bg-primary,
        .card-header.bg-info,
        .card-header.bg-secondary {
            display: none !important;
        }

        .col-lg-4 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete() {
        return confirm('Hapus layanan "{{ $product->name }}"?\n\nTindakan ini tidak dapat dibatalkan!');
    }

    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            alert('URL berhasil disalin ke clipboard: ' + text);
        }, function(err) {
            console.error('Gagal menyalin: ', err);
            // Fallback untuk browser lama
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('URL berhasil disalin!');
        });
    }

    // Tooltip initialization
    $(document).ready(function() {
        $('[title]').tooltip();

        // Print button
        $('.print-btn').click(function() {
            window.print();
        });
    });
</script>
@endpush