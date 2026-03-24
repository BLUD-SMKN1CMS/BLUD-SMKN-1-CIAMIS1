@extends('admin.layouts.app')

@section('title', 'Edit Carousel')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Carousel</h1>
        <a href="{{ route($routePrefix . '.carousels.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Carousel</h6>
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . '.carousels.update', $carousel->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
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
                                        <option value="active" {{ old('status', $carousel->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                        <option value="inactive" {{ old('status', $carousel->status) == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
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
                                           id="order" name="order" value="{{ old('order', $carousel->order) }}" min="1">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="fas fa-image me-2"></i>Gambar Carousel</h6>
                            </div>
                            <div class="card-body">
                                <!-- Current Image -->
                                @if($carousel->image)
                                    <div class="text-center mb-3">
                                        <p class="text-muted small">Gambar Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $carousel->image) }}" 
                                             alt="{{ $carousel->title }}" 
                                             class="img-fluid rounded border mb-2" 
                                             style="max-height: 150px;">
                                        <p class="small text-muted">
                                            {{ basename($carousel->image) }}
                                        </p>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Baru (Opsional)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*"
                                           onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                </div>

                                <!-- New Image Preview -->
                                <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                    <p class="text-muted small">Preview Gambar Baru:</p>
                                    <img id="preview" class="img-fluid rounded border" 
                                         style="max-height: 150px;" alt="Preview">
                                </div>

                                <!-- Ratio Info -->
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Rasio 16:9</strong><br>
                                    Gambar akan <strong>auto-cut ke 1920×1080px</strong>
                                </div>
                            </div>
                        </div>

                        <!-- Carousel Info -->
                        <div class="card mt-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Info Carousel</h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled small">
                                    <li><strong>ID:</strong> {{ $carousel->id }}</li>
                                    <li><strong>Dibuat:</strong> {{ $carousel->created_at->format('d/m/Y H:i') }}</li>
                                    <li><strong>Diperbarui:</strong> {{ $carousel->updated_at->format('d/m/Y H:i') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Perbarui Carousel
                    </button>
                    <a href="{{ route($routePrefix . '.carousels.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            
            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
            preview.src = '';
        }
    }

</script>
@endpush