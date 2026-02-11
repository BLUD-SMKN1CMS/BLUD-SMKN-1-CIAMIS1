@extends('admin.layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Produk</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data Produk: {{ $product->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Produk *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $product->name) }}" required>
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
                                    <option value="{{ $tefa->id }}" 
                                        {{ old('tefa_id', $product->tefa_id) == $tefa->id ? 'selected' : '' }}>
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                    value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Stok *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $product->stock) }}" required min="0">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori *</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                                value="{{ old('category', $product->category) }}" required>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="font-weight-bold">Gambar Produk (Maks. 4)</label>
                        <div class="row">
                            <!-- Image 1 (Utama) -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar Utama</label>
                                    <div id="preview-container-1" class="mb-2 text-center" style="min-height: 120px;">
                                        @if($product->image)
                                            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset($product->image) }}" 
                                                alt="Main Image" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="image" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-1')">
                                </div>
                            </div>
                            
                            <!-- Image 2 -->
                            <!-- Image 2 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 2</label>
                                    <div id="preview-container-2" class="mb-2 text-center" style="min-height: 120px;">
                                        @if($product->image_2)
                                            <img src="{{ Str::startsWith($product->image_2, 'http') ? $product->image_2 : asset($product->image_2) }}" 
                                                alt="Image 2" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="image_2" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-2')">
                                </div>
                            </div>

                            <!-- Image 3 -->
                            <!-- Image 3 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 3</label>
                                    <div id="preview-container-3" class="mb-2 text-center" style="min-height: 120px;">
                                        @if($product->image_3)
                                            <img src="{{ Str::startsWith($product->image_3, 'http') ? $product->image_3 : asset($product->image_3) }}" 
                                                alt="Image 3" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="image_3" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-3')">
                                </div>
                            </div>

                            <!-- Image 4 -->
                            <!-- Image 4 -->
                            <div class="col-md-3">
                                <div class="card p-2">
                                    <label class="small font-weight-bold">Gambar 4</label>
                                    <div id="preview-container-4" class="mb-2 text-center" style="min-height: 120px;">
                                        @if($product->image_4)
                                            <img src="{{ Str::startsWith($product->image_4, 'http') ? $product->image_4 : asset($product->image_4) }}" 
                                                alt="Image 4" class="img-fluid img-thumbnail" style="height: 120px; object-fit: cover;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 120px; width: 100%;">
                                                <span class="text-muted small">Tidak ada gambar</span>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" name="image_4" class="form-control-file small" accept="image/*" onchange="previewProductImage(this, 'preview-container-4')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $product->order) }}">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input type="checkbox" name="is_featured" class="form-check-input" id="is_featured"
                        value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_featured">
                        Tampilkan sebagai produk unggulan
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Produk
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
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
                    // Remove the "Tidak ada gambar" placeholder if it exists
                    container.innerHTML = '';
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