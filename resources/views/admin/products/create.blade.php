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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kategori *</label>
                            <input type="text" name="category" class="form-control @error('category') is-invalid @enderror"
                                value="{{ old('category') }}" required placeholder="Contoh: Makanan, Elektronik, dll">
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Gambar Produk</label>
                            <input type="file" name="image" class="form-control-file @error('image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, JPEG | Max: 2MB</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
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