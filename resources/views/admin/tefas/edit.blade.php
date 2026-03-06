@extends('admin.layouts.app')

@section('title', 'Edit TEFA')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit TEFA</h1>
        @if(Auth::guard('admin')->user()->isSuperAdmin())
        <a href="{{ route($routePrefix . '.tefas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
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
            <h6 class="m-0 font-weight-bold text-primary">Edit Data TEFA: {{ $tefa->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route($routePrefix . '.tefas.update', $tefa->id) }}" method="POST" enctype="multipart/form-data" id="tefaForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama TEFA <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $tefa->name) }}" required placeholder="Contoh: Akuntansi Keuangan Lembaga">
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
                                value="{{ old('code', $tefa->code) }}" required placeholder="Contoh: AKL, PM, DKV, PPLG">
                            <small class="text-muted">Kode 3 huruf (contoh: AKL, PM, DKV, PPLG)</small>
                            @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                        placeholder="Deskripsi singkat tentang jurusan TEFA ini...">{{ old('description', $tefa->description) }}</textarea>
                    <small class="text-muted">Penjelasan singkat yang akan ditampilkan di card</small>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Icon</label>
                            <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                id="logoInput" accept="image/*">
                            <small class="text-muted">Klik tombol untuk memilih icon dari daftar. Kosongkan jika tidak ingin mengubah.</small>
                            @error('logo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            <!-- Current Logo -->
                            @if($tefa->logo)
                            <div class="mt-3" id="currentLogo">
                                <div class="border rounded p-3 text-center bg-light">
                                    <p class="mb-2 small text-muted">Logo Saat Ini:</p>
                                    <img src="{{ asset($tefa->logo) }}" alt="Current Logo" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                </div>
                            </div>
                            @endif

                            <!-- Logo Preview -->
                            <div class="mt-3" id="logoPreview" style="display: none;">
                                <div class="border rounded p-3 text-center bg-light">
                                    <p class="mb-2 small text-muted">Preview Logo Baru:</p>
                                    <img id="logoPreviewImage" src="" alt="Logo Preview" style="max-width: 100px; max-height: 100px; object-fit: contain;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                                <option value="1" {{ old('is_active', $tefa->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active', $tefa->is_active) == 0 ? 'selected' : '' }}>Nonaktif</option>
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
                                value="{{ old('order', $tefa->order) }}" min="0" max="100">
                            <small class="text-muted">Angka kecil = tampil di awal</small>
                            @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Layanan per Jurusan -->
                <div class="form-group">
                    <label class="d-block mb-2">
                        <strong>Layanan yang Ditawarkan</strong>
                        <small class="text-muted">(Opsional - tambah layanan yang ditawarkan jurusan ini)</small>
                    </label>

                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Daftar Layanan</span>
                                <button type="button" class="btn btn-sm btn-primary" id="addServiceBtn">
                                    <i class="fas fa-plus"></i> Tambah Layanan
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Container untuk daftar layanan -->
                            <div id="servicesContainer">
                                <!-- Layanan akan ditambahkan di sini -->
                            </div>

                            <!-- Input tersembunyi untuk JSON -->
                            <input type="hidden" name="services_json" id="servicesJson"
                                value='{{ old('services_json', $tefa->services ? json_encode($tefa->services) : '[]') }}'>

                            <div class="text-center mt-3">
                                <p class="text-muted small" id="noServicesMessage">
                                    <i class="fas fa-info-circle"></i> Belum ada layanan yang ditambahkan
                                </p>
                            </div>
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
                        <i class="fas fa-save"></i> Simpan Perubahan
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
                    $('#currentLogo').hide();
                    $('#logoPreview').show();
                };
                reader.readAsDataURL(file);
            } else {
                $('#logoPreview').hide();
                $('#currentLogo').show();
            }
        });

        // ============ SERVICES MANAGEMENT ============
        let services = [];

        // Parse existing services from JSON
        try {
            const existingServices = JSON.parse($('#servicesJson').val() || '[]');
            services = existingServices;
            renderServices();
        } catch (e) {
            console.error('Error parsing services JSON:', e);
            services = [];
        }

        // Add new service
        $('#addServiceBtn').click(function() {
            const serviceName = prompt('Masukkan nama layanan baru:');
            if (serviceName && serviceName.trim()) {
                services.push(serviceName.trim());
                renderServices();
                updateJsonField();
            }
        });

        // Render services list
        function renderServices() {
            $('#servicesContainer').empty();

            if (services.length === 0) {
                $('#noServicesMessage').show();
                return;
            }

            $('#noServicesMessage').hide();

            services.forEach((service, index) => {
                $('#servicesContainer').append(`
                <div class="service-item" data-index="${index}">
                    <span class="badge badge-primary">${index + 1}</span>
                    <input type="text" class="service-input" value="${service}" 
                           placeholder="Nama layanan...">
                    <button type="button" class="btn btn-sm btn-danger remove-service">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `);
            });
        }

        // Update service
        $(document).on('blur', '.service-input', function() {
            const index = $(this).closest('.service-item').data('index');
            const newValue = $(this).val().trim();

            if (newValue) {
                services[index] = newValue;
                updateJsonField();
            } else {
                alert('Nama layanan tidak boleh kosong!');
                $(this).val(services[index]).focus();
            }
        });

        // Enter key to blur
        $(document).on('keypress', '.service-input', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                $(this).blur();
            }
        });

        // Remove service
        $(document).on('click', '.remove-service', function() {
            const index = $(this).closest('.service-item').data('index');
            const serviceName = services[index];

            if (confirm(`Hapus layanan "${serviceName}"?`)) {
                services.splice(index, 1);
                renderServices();
                updateJsonField();
            }
        });

        // Update hidden JSON field
        function updateJsonField() {
            $('#servicesJson').val(JSON.stringify(services));
        }

        // Form validation
        $('#tefaForm').submit(function(e) {
            const name = $('input[name="name"]').val().trim();
            const code = $('input[name="code"]').val().trim();

            if (!name || !code) {
                e.preventDefault();
                alert('Nama dan Kode TEFA harus diisi!');
                if (!name) $('input[name="name"]').focus();
                else if (!code) $('input[name="code"]').focus();
                return false;
            }

            // Update JSON before submit
            updateJsonField();

            // Show loading
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...').prop('disabled', true);
        });
    });
</script>
@endpush