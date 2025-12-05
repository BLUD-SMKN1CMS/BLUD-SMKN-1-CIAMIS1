@extends('admin.layouts.app')

@section('title', 'Tambah Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Layanan Baru</h1>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Layanan</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.services.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Nama Layanan *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                        value="{{ old('name') }}" required placeholder="Contoh: Sewa Gedung, Air Minum Galon">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" 
                        placeholder="Deskripsi lengkap layanan...">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Harga per Hari *</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror"
                                    value="{{ old('price_per_day') }}" required>
                                @error('price_per_day')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Unit *</label>
                            <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                                value="{{ old('unit') }}" required placeholder="Contoh: hari, jam, unit, galon">
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status *</label>
                    <select name="status" class="form-control" required>
                        <option value="available" {{ old('status') == 'available' ? 'selected' : '' }} selected>Tersedia</option>
                        <option value="unavailable" {{ old('status') == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Layanan
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