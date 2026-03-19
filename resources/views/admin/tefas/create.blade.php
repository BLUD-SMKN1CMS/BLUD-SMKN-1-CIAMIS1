@extends('admin.layouts.app')

@section('title', 'Tambah TEFA Baru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah TEFA Baru</h1>
        @if(Auth::guard('admin')->user()->isSuperAdmin())
        <a href="{{ route($routePrefix . '.tefas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        @else
        <a href="{{ route($routePrefix . '.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
        </a>
        @endif
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Terjadi kesalahan!</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah TEFA</h6>
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . '.tefas.store') }}" method="POST" enctype="multipart/form-data" id="tefaForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama TEFA <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required placeholder="Contoh: Akuntansi Keuangan Lembaga">
                            <small class="text-muted">Masukkan nama lengkap program keahlian</small>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Singkat <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}" required placeholder="Contoh: AKL, PM, DKV, PPLG">
                            <small class="text-muted">Kode 3 huruf (contoh: AKL, PM, DKV, PPLG)</small>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Icon <span class="text-danger">*</span></label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                id="logoInput" accept="image/*" required>
                            <small class="text-muted">Klik tombol untuk memilih icon dari daftar</small>
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Logo Preview -->
                            <div class="mt-3" id="logoPreview" style="display: none;">
                                <div class="border rounded p-3 text-center bg-light">
                                    <p class="mb-2 small text-muted">fas fa-school</p>
                                    <img id="logoPreviewImage" src="" alt="Logo Preview" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Urutan Tampilan</label>
                            <input type="number" name="order" class="form-control @error('order') is-invalid @enderror"
                                value="{{ old('order', 0) }}" min="0" max="100">
                            <small class="text-muted">Angka kecil = tampil di awal</small>
                            @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4 text-right">
                    @if(Auth::guard('admin')->user()->isSuperAdmin())
                    <a href="{{ route($routePrefix . '.tefas.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    @else
                    <a href="{{ route($routePrefix . '.dashboard') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    @endif
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Simpan TEFA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .service-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 10px;
        background: #f8f9fc;
        border-radius: 5px;
        border-left: 3px solid #4e73df;
    }

    .service-item input {
        flex: 1;
        border: 1px solid #d1d3e2;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
    }

    .service-item input:focus {
        outline: none;
        border-color: #4e73df;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .service-item .badge {
        font-size: 12px;
        padding: 5px 10px;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // ============ LOGO UPLOAD PREVIEW ============
        $('#logoInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    $(this).val('');
                    $('#logoPreview').hide();
                    return;
                }

                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid! Gunakan JPG, PNG, atau WEBP.');
                    $(this).val('');
                    $('#logoPreview').hide();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#logoPreviewImage').attr('src', e.target.result);
                    $('#logoPreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#logoPreview').hide();
            }
        });

        // Form validation
        $('#tefaForm').submit(function(e) {
            const name = $('input[name="name"]').val().trim();
            const code = $('input[name="code"]').val().trim();
            const logo = $('#logoInput').val();

            if (!name || !code) {
                e.preventDefault();
                alert('Nama dan Kode TEFA harus diisi!');
                if (!name) $('input[name="name"]').focus();
                else if (!code) $('input[name="code"]').focus();
                return false;
            }

            if (!logo) {
                e.preventDefault();
                alert('Logo harus dipilih!');
                $('#logoInput').focus();
                return false;
            }

            // Show loading
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
        });
    });
</script>
@endpush
