@extends('admin.layouts.app')

@section('title', 'Tambah Carousel Baru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Carousel Baru</h1>
        <a href="{{ route($routePrefix . '.carousels.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Carousel</h6>
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . '.carousels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Carousel sekarang hanya untuk <strong>gambar background hero</strong>. Teks judul, deskripsi, dan tombol diatur dari menu <strong>Settings</strong>.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="order" class="form-label">Urutan</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                           id="order" name="order" value="{{ old('order') }}" 
                                           min="1" placeholder="Kosongkan untuk urutan terakhir">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Angka kecil = muncul lebih awal</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-image me-2"></i>Upload Gambar</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Carousel <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*" required
                                           onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <!-- Image Preview Container -->
                                    <div class="text-center mt-4">
                                        <div class="ratio ratio-16x9 border rounded bg-light overflow-hidden position-relative">
                                            <!-- Default Placeholder Content -->
                                            <div id="placeholderContent" class="d-flex flex-column justify-content-center align-items-center w-100 h-100">
                                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                                <p class="text-muted mb-0">Preview akan muncul di sini</p>
                                            </div>
                                            
                                            <!-- Image Preview -->
                                            <img id="mainPreview" src="#" alt="Preview" class="w-100 h-100 position-absolute top-0" style="display: none; object-fit: cover; left: 0;">
                                        </div>
                                        <small class="text-muted mt-2 d-block">Preview rasio 16:9</small>
                                    </div>
                                    
                                    <!-- Ratio Info -->
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Rasio 16:9</strong><br>
                                        Ukuran akan <strong>auto-cut ke 1920×1080px</strong><br>
                                        Format: JPG, PNG, GIF (max 5MB)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Carousel
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('mainPreview');
        const placeholder = document.getElementById('placeholderContent');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.classList.add('d-none');
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
            preview.src = '#';
            placeholder.classList.remove('d-none');
        }
    }

</script>
@endpush