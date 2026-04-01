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
            @if($errors->any())
            <div class="alert alert-danger">
                <strong>Gagal menyimpan carousel:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

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
                                    <small class="text-muted d-block mt-1">Maksimal ukuran file: 2MB</small>

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
    let cropper = null;
    let originalImageData = null;

    function previewImage(input) {
        const maxFileSize = 2 * 1024 * 1024; // 2MB
        const preview = document.getElementById('mainPreview');
        const placeholder = document.getElementById('placeholderContent');
        const cropContainer = document.getElementById('cropContainer');
        const cropImage = document.getElementById('cropImage');
        const cropButtonsContainer = document.getElementById('cropButtonsContainer');
        const cropStatus = document.getElementById('cropStatus');

        if (input.files && input.files[0]) {
            if (input.files[0].size > maxFileSize) {
                input.value = '';
                preview.style.display = 'none';
                preview.src = '#';
                placeholder.classList.remove('d-none');
                cropContainer.style.display = 'none';
                cropButtonsContainer.style.display = 'none';
                cropStatus.innerHTML = '<i class="fas fa-exclamation-triangle me-2 text-danger"></i><small><strong>Ukuran gambar terlalu besar.</strong> Maksimal 2MB.</small>';
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                // Show main preview
                preview.src = e.target.result;
                preview.style.display = 'block';
                placeholder.classList.add('d-none');

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
            preview.style.display = 'none';
            preview.src = '#';
            placeholder.classList.remove('d-none');
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
        const safeScaleX = Number.isFinite(imageData.scaleX) ? imageData.scaleX : 1;
        const safeScaleY = Number.isFinite(imageData.scaleY) ? imageData.scaleY : 1;
        document.getElementById('cropScaleX').value = safeScaleX;
        document.getElementById('cropScaleY').value = safeScaleY;

        // Update main preview with cropped image
        const mainPreview = document.getElementById('mainPreview');
        mainPreview.src = canvas.toDataURL();

        // Show success message
        document.getElementById('cropStatus').innerHTML = '<i class="fas fa-check-circle me-2" style="color: #28a745;"></i><small><strong>Crop diterapkan!</strong> Klik Simpan untuk menyimpan perubahan</small>';
    }
</script>