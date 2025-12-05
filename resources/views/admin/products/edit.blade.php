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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" name="image" class="form-control-file" accept="image/*">
                            @if($product->image)
                                <div class="mt-2">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                        style="max-width: 200px; max-height: 150px;" class="img-thumbnail">
                                    <small class="text-muted d-block">Gambar saat ini</small>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="draft" {{ $product->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
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