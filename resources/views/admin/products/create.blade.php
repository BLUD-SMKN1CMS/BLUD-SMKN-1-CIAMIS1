@extends('admin.layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Produk Baru</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Produk</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>TEFA *</label>
                            <select name="tefa_id" class="form-control @error('tefa_id') is-invalid @enderror" required>
                                <option value="">Pilih TEFA</option>
                                @foreach($tefas as $tefa)
                                    <option value="{{ $tefa->id }}" {{ old('tefa_id') == $tefa->id ? 'selected' : '' }}>
                                        {{ $tefa->name }} ({{ $tefa->code }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tefa_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Harga *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Stok *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', 0) }}" required min="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Kategori *</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                                value="{{ old('category') }}" required placeholder="Contoh: Makanan">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="font-weight-bold">Gambar Produk (Maks. 4)</label>
                        <div class="row">
                            <!-- Image 1 -->
                            <div class="col-md-3">
                                <div class="card p-2 h-100">
                                    <label class="small font-weight-bold">Gambar Utama</label>
                                    <div id="preview-container-1" class="mb-2 text-center bg-light d-flex align-items-center justify-content-center" style="height: 120px; border-radius: 4px;">
                                        <i class="fas fa-image fa-2x text-gray-300"></i>
                                    </div>
                                    <input type="file" name="image" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-1')">
                                    @error('image')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Image 2 -->
                            <div class="col-md-3">
                                <div class="card p-2 h-100">
                                    <label class="small font-weight-bold">Gambar 2</label>
                                    <div id="preview-container-2" class="mb-2 text-center bg-light d-flex align-items-center justify-content-center" style="height: 120px; border-radius: 4px;">
                                        <i class="fas fa-image fa-2x text-gray-300"></i>
                                    </div>
                                    <input type="file" name="image_2" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-2')">
                                    @error('image_2')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image 3 -->
                            <div class="col-md-3">
                                <div class="card p-2 h-100">
                                    <label class="small font-weight-bold">Gambar 3</label>
                                    <div id="preview-container-3" class="mb-2 text-center bg-light d-flex align-items-center justify-content-center" style="height: 120px; border-radius: 4px;">
                                        <i class="fas fa-image fa-2x text-gray-300"></i>
                                    </div>
                                    <input type="file" name="image_3" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-3')">
                                    @error('image_3')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Image 4 -->
                            <div class="col-md-3">
                                <div class="card p-2 h-100">
                                    <label class="small font-weight-bold">Gambar 4</label>
                                    <div id="preview-container-4" class="mb-2 text-center bg-light d-flex align-items-center justify-content-center" style="height: 120px; border-radius: 4px;">
                                        <i class="fas fa-image fa-2x text-gray-300"></i>
                                    </div>
                                    <input type="file" name="image_4" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-4')">
                                    @error('image_4')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2">Format: JPG, PNG, JPEG | Max: 2MB per gambar</small>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }} selected>Aktif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                        value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Tampilkan sebagai produk unggulan di homepage
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Produk
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-redo"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewProductImage(input, containerId) {
        const container = document.getElementById(containerId);
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Check if there is already an img tag
                let img = container.querySelector('img');
                
                if (img) {
                    img.src = e.target.result;
                    img.style.display = 'block';
                } else {
                    // Remove the placeholder icon if it exists
                    container.innerHTML = '';
                    container.classList.remove('bg-light', 'd-flex', 'align-items-center', 'justify-content-center');
                    
                    img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Preview';
                    img.className = 'img-fluid img-thumbnail';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    container.appendChild(img);
                }
            }

            reader.readAsDataURL(file);
        }
    }
</script>
@endpush