@extends('admin.layouts.app')

@section('title', 'Detail Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Carousel</h1>
        <div>
            <a href="{{ route('admin.carousels.edit', $carousel->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('admin.carousels.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Carousel Details -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Carousel</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Judul</h6>
                            <p>{{ $carousel->title }}</p>
                        </div>
                        <div class="col-md-3">
                            <h6 class="font-weight-bold">Status</h6>
                            <span class="badge bg-{{ $carousel->status === 'active' ? 'success' : 'secondary' }}">
                                {{ $carousel->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="col-md-3">
                            <h6 class="font-weight-bold">Urutan</h6>
                            <span class="badge bg-info">{{ $carousel->order }}</span>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <h6 class="font-weight-bold">Deskripsi</h6>
                            <p>{{ $carousel->description ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>

                    @if($carousel->button_text || $carousel->button_url)
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Teks Tombol</h6>
                            <p>{{ $carousel->button_text ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">URL Tombol</h6>
                            <p>
                                @if($carousel->button_url)
                                    <a href="{{ $carousel->button_url }}" target="_blank" class="text-decoration-none">
                                        {{ $carousel->button_url }}
                                        <i class="fas fa-external-link-alt ms-1"></i>
                                    </a>
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Dibuat</h6>
                            <p>{{ $carousel->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="font-weight-bold">Diperbarui</h6>
                            <p>{{ $carousel->updated_at->format('d/m/Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carousel Image & Actions -->
        <div class="col-lg-4">
            <!-- Image Preview -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Gambar</h6>
                </div>
                <div class="card-body text-center">
                    @if($carousel->image)
                        <div class="ratio ratio-16x9 mb-3">
                            <img src="{{ asset('storage/' . $carousel->image) }}" 
                                 alt="{{ $carousel->title }}" 
                                 class="img-fluid rounded" 
                                 style="object-fit: cover;">
                        </div>
                        <p class="small text-muted">
                            <i class="fas fa-file-image me-1"></i>
                            {{ basename($carousel->image) }}
                        </p>
                        <a href="{{ asset('storage/' . $carousel->image) }}" 
                           target="_blank" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>Lihat Full Size
                        </a>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.carousels.edit', $carousel->id) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Carousel
                        </a>
                        
                        <form action="{{ route('admin.carousels.toggle-status', $carousel->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $carousel->status === 'active' ? 'secondary' : 'success' }} w-100">
                                <i class="fas fa-{{ $carousel->status === 'active' ? 'eye-slash' : 'eye' }} me-2"></i>
                                {{ $carousel->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.carousels.destroy', $carousel->id) }}" method="POST"
                              onsubmit="return confirm('Hapus carousel ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Carousel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview on Homepage -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Preview di Homepage</h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Note:</strong> Ini adalah simulasi bagaimana carousel akan tampil di homepage.
            </div>
            
            <div class="border rounded p-4 bg-light">
                <div class="carousel-item active">
                    @if($carousel->image)
                        <img src="{{ asset('storage/' . $carousel->image) }}" 
                             class="d-block w-100" 
                             alt="{{ $carousel->title }}" 
                             style="height: 400px; object-fit: cover;">
                    @else
                        <div class="bg-dark text-white text-center py-5" style="height: 400px;">
                            <i class="fas fa-image fa-4x mb-3"></i>
                            <h4>No Image</h4>
                        </div>
                    @endif
                    
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 p-4 rounded">
                        <h5 class="text-white">{{ $carousel->title }}</h5>
                        @if($carousel->description)
                            <p class="text-light">{{ Str::limit($carousel->description, 100) }}</p>
                        @endif
                        @if($carousel->button_text && $carousel->button_url)
                            <a href="{{ $carousel->button_url }}" class="btn btn-primary btn-sm">
                                {{ $carousel->button_text }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-3 text-center">
                <small class="text-muted">
                    <i class="fas fa-desktop me-1"></i> Rasio: 16:9 | Height: 400px (simulasi)
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .ratio-16x9 {
        --bs-aspect-ratio: 56.25%; /* 16:9 Aspect Ratio */
    }
</style>
@endpush