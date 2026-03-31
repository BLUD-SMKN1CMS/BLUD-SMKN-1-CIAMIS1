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

                        <!-- Manual Crop Section -->
                        <div class="card mt-4 border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="fas fa-crop me-2"></i>Manual Crop Gambar</h6>
                            </div>
                            <div class="card-body">
                                <p class="mb-3 text-muted">Pilih area gambar yang ingin ditampilkan. Rasio tetap 16:9.</p>

                                <div id="cropContainer" style="max-height: 400px; position: relative; background: #f8f9fa; margin-bottom: 15px; display: none;">
                                    <img id="cropImage" src="#" alt="Crop Image" style="max-width: 100%; max-height: 400px;">
                                </div>

                                <div class="mb-3" id="cropButtonsContainer" style="display: none;">
                                    <button type="button" class="btn btn-sm btn-info me-2" onclick="resetCrop()">
                                        <i class="fas fa-undo me-1"></i>Reset Crop
                                    </button>
                                    <button type="button" class="btn btn-sm btn-success" onclick="applyCrop()">
                                        <i class="fas fa-check me-1"></i>Terapkan Crop
                                    </button>
                                </div>

                                <!-- Hidden inputs untuk menyimpan crop data -->
                                <input type="hidden" id="cropX" name="crop_x" value="">
                                <input type="hidden" id="cropY" name="crop_y" value="">
                                <input type="hidden" id="cropWidth" name="crop_width" value="">
                                <input type="hidden" id="cropHeight" name="crop_height" value="">
                                <input type="hidden" id="cropScaleX" name="crop_scale_x" value="1">
                                <input type="hidden" id="cropScaleY" name="crop_scale_y" value="1">

                                <div class="alert alert-light border-info" id="cropStatus">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Upload gambar terlebih dahulu untuk menggunakan fitur crop</small>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    let cropper = null;

    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        const cropContainer = document.getElementById('cropContainer');
        const cropImage = document.getElementById('cropImage');
        const cropButtonsContainer = document.getElementById('cropButtonsContainer');
        const cropStatus = document.getElementById('cropStatus');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';

                // Setup cropper
                cropImage.src = e.target.result;
                cropContainer.style.display = 'block';
                cropButtonsContainer.style.display = 'block';

                // Destroy existing cropper if any
                if (cropper) {
                    cropper.destroy();
                }

                // Initialize new cropper
                cropper = new Cropper(cropImage, {
                    viewMode: 1,
                    autoCropArea: 1,
                    aspectRatio: 16 / 9,
                    guides: true,
                    highlight: true,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    toggleDragModeOnDblclick: true,
                    responsive: true,
                    restore: true,
                    background: true,
                });

                // Update status
                cropStatus.innerHTML = '<i class="fas fa-check-circle me-2" style="color: #17a2b8;"></i><small><strong>Crop ready:</strong> Tarik dan sesuaikan area crop sesuai kebutuhan</small>';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            previewDiv.style.display = 'none';
            preview.src = '';
            cropContainer.style.display = 'none';
            cropButtonsContainer.style.display = 'none';
            cropStatus.innerHTML = '<i class="fas fa-info-circle me-2"></i><small>Upload gambar terlebih dahulu untuk menggunakan fitur crop</small>';

            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }
    }

    function resetCrop() {
        if (cropper) {
            cropper.reset();
            document.getElementById('cropStatus').innerHTML = '<i class="fas fa-info-circle me-2"></i><small>Crop area direset ke ukuran asli</small>';
        }
    }

    function applyCrop() {
        if (!cropper) {
            alert('Silakan upload gambar terlebih dahulu');
            return;
        }

        const canvas = cropper.getCroppedCanvas();
        const cropData = cropper.getData();
        const imageData = cropper.getImageData();

        // Store crop data in hidden inputs
        document.getElementById('cropX').value = Math.round(cropData.x);
        document.getElementById('cropY').value = Math.round(cropData.y);
        document.getElementById('cropWidth').value = Math.round(cropData.width);
        document.getElementById('cropHeight').value = Math.round(cropData.height);
        document.getElementById('cropScaleX').value = imageData.scaleX;
        document.getElementById('cropScaleY').value = imageData.scaleY;

        // Update preview with cropped image
        const preview = document.getElementById('preview');
        preview.src = canvas.toDataURL();

        // Show success message
        document.getElementById('cropStatus').innerHTML = '<i class="fas fa-check-circle me-2" style="color: #28a745;"></i><small><strong>Crop diterapkan!</strong> Klik Perbarui untuk menyimpan perubahan</small>';
    }
</script>
@endpush