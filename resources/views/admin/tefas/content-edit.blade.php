@extends('admin.layouts.app')

@section('title', 'Edit Konten ' . $tefa->name)

@section('content')
@php
    $contentUpdateRouteName = \Illuminate\Support\Facades\Route::has($routePrefix . '.tefas.content.update')
        ? $routePrefix . '.tefas.content.update'
        : $routePrefix . '.tefas.update';

    $contentBackRouteName = \Illuminate\Support\Facades\Route::has($routePrefix . '.tefas.content.index')
        ? $routePrefix . '.tefas.content.index'
        : $routePrefix . '.dashboard';
@endphp
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Konten Program Keahlian</h1>
        <a href="{{ route($contentBackRouteName) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    @endif

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

    <form action="{{ route($contentUpdateRouteName, $tefa->id) }}" method="POST" enctype="multipart/form-data" id="contentForm">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            Konten Detail Halaman Jurusan: {{ $tefa->name }} ({{ $tefa->code }})
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label><strong><i class="fas fa-align-left"></i> Deskripsi Singkat</strong></label>
                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Deskripsi singkat jurusan...">{{ old('description', $tefa->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label><strong><i class="fas fa-image"></i> Ganti Icon/Logo Jurusan</strong></label>
                            <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*">
                            <small class="text-muted">Upload logo/icon jurusan baru (JPG/PNG/WEBP, maks 2MB).</small>
                        </div>

                        <div class="form-group">
                            <label><strong><i class="fas fa-info-circle"></i> Tentang Jurusan Ini</strong></label>
                            <textarea name="about" class="form-control" rows="6"
                                placeholder="Tulis penjelasan lengkap tentang jurusan ini, apa yang dipelajari, keunggulan, dll...">{{ old('about', $tefa->about) }}</textarea>
                            <small class="text-muted">Penjelasan detail tentang jurusan yang akan ditampilkan di bagian "Tentang"</small>
                        </div>

                        <div class="form-group">
                            <label><strong><i class="fas fa-images"></i> Foto Slider Halaman Detail TEFA</strong></label>
                            <input type="file" name="slider_images[]" id="sliderImagesInput" class="form-control" accept="image/*" multiple>
                            <small class="text-muted">Bisa upload lebih dari satu foto slider (JPG/PNG/WEBP, maks 4MB per file).</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><i class="fas fa-eye"></i> Visi</strong></label>
                                    <textarea name="vision" class="form-control" rows="5"
                                        placeholder="Visi jurusan...">{{ old('vision', $tefa->vision) }}</textarea>
                                    <small class="text-muted">Visi jurusan</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><strong><i class="fas fa-bullseye"></i> Misi</strong></label>
                                    <textarea name="mission" class="form-control" rows="5"
                                        placeholder="Misi jurusan (pisahkan dengan enter untuk list)...">{{ old('mission', $tefa->mission) }}</textarea>
                                    <small class="text-muted">Misi jurusan (pisahkan setiap poin dengan enter/baris baru)</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><strong><i class="fas fa-video"></i> Video Profil Jurusan</strong></label>
                            <input type="url" name="video_url" class="form-control"
                                value="{{ old('video_url', $tefa->video_url) }}"
                                placeholder="https://www.youtube.com/watch?v=xxxxx atau https://www.youtube.com/embed/xxxxx">
                            <small class="text-muted">URL video YouTube atau Vimeo yang menampilkan profil jurusan</small>
                        </div>

                        <div class="form-group">
                            <label class="d-block mb-2">
                                <strong><i class="fas fa-briefcase"></i> Prospek Kerja</strong>
                                <small class="text-muted">(Opsional - tambah prospek karir lulusan jurusan ini)</small>
                            </label>

                            <div class="card">
                                <div class="card-header bg-light py-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Daftar Prospek Kerja</span>
                                        <button type="button" class="btn btn-sm btn-success" id="addJobProspectBtn">
                                            <i class="fas fa-plus"></i> Tambah Prospek Kerja
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="jobProspectsContainer"></div>

                                    <input type="hidden" name="job_prospects_json" id="jobProspectsJson"
                                        value='{{ old('job_prospects_json', $tefa->job_prospects ? json_encode($tefa->job_prospects) : '[]') }}'>

                                    <div class="text-center mt-3">
                                        <p class="text-muted small" id="noJobProspectsMessage">
                                            <i class="fas fa-info-circle"></i> Belum ada prospek kerja yang ditambahkan
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info small mt-2 mb-0">
                                <strong>Contoh prospek kerja per jurusan:</strong><br>
                                • AKL: Akuntan, Auditor, Tax Consultant, Finance Staff<br>
                                • MPLB: Marketing Manager, Sales Executive, Entrepreneur, Business Analyst<br>
                                • KULINER: Chef, Baker, Catering Manager, Food Blogger<br>
                                • DKV: Graphic Designer, UI/UX Designer, Animator, Video Editor<br>
                                • PPLG: Web Developer, Mobile App Developer, System Analyst, IT Support<br>
                                • PERHOTELAN: Hotel Manager, Front Office Staff, Housekeeping Supervisor
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3 text-right mb-5">
                    <a href="{{ route($contentBackRouteName) }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="content-preview-sticky">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Preview Icon Jurusan</h6>
                        </div>
                        <div class="card-body">
                            <div class="text-center">
                                <img id="sidebarLogoImage" src="{{ $tefa->logo ? asset($tefa->logo) : asset('assets/iconsmea.png') }}" alt="Preview Icon {{ $tefa->name }}" style="max-width: 140px; max-height: 140px; object-fit: contain; border-radius: 8px; border: 1px solid #e2e8f0; padding: 10px; background: #fff;">
                                <p class="text-muted small mt-2 mb-0">Icon yang dipakai di halaman detail TEFA</p>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Preview Slider TEFA</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Pilih foto yang ingin dihapus dari slider detail TEFA.</p>

                            <div id="sliderImagesCurrent" class="admin-gallery-preview">
                                @foreach(($tefa->slider_images ?? []) as $sliderImagePath)
                                    <div class="admin-gallery-card" data-slider-path="{{ $sliderImagePath }}">
                                        <img src="{{ asset($sliderImagePath) }}" alt="Slider {{ $tefa->name }}" class="admin-gallery-item">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input remove-gallery-checkbox" type="checkbox" name="remove_slider_images[]" value="{{ $sliderImagePath }}" id="remove_{{ md5($sliderImagePath) }}">
                                            <label class="form-check-label small text-danger" for="remove_{{ md5($sliderImagePath) }}">
                                                Hapus foto ini
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if(empty($tefa->slider_images))
                                <div id="sliderImagesEmpty" class="d-flex flex-column align-items-center justify-content-center text-center mt-3"
                                    style="height: 180px; border: 1px dashed #cbd5e0; border-radius: 12px; background: #f8fafc;">
                                    <i class="fas fa-images fa-2x mb-2 text-muted"></i>
                                    <p class="mb-0 text-muted">Belum ada foto slider.</p>
                                </div>
                            @endif

                            <div id="sliderImagesNewPreview" class="admin-gallery-preview mt-3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
    .service-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
        padding: 8px;
        background: #f8f9fc;
        border-radius: 5px;
        border-left: 3px solid #4e73df;
    }

    .service-item input {
        flex-grow: 1;
        border: 1px solid #d1d3e2;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .service-item button {
        flex-shrink: 0;
    }

    .job-prospect-input {
        flex: 1;
    }

    .admin-gallery-preview {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .admin-gallery-item {
        width: 100%;
        height: 120px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid #e2e8f0;
    }

    .admin-gallery-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px;
        background: #fff;
    }

    .admin-gallery-card.to-remove {
        opacity: 0.45;
        border-color: #ef4444;
        background: #fff5f5;
    }

    .admin-gallery-new-label {
        grid-column: 1 / -1;
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        margin-bottom: -4px;
    }

    .content-preview-sticky {
        position: sticky;
        top: 90px;
        z-index: 1;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#logoInput').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran icon/logo terlalu besar! Maksimal 2MB.');
                    $(this).val('');
                    $('#logoPreview').hide();
                    return;
                }

                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid! Gunakan JPG, PNG, atau WEBP.');
                    $(this).val('');
                    $('#logoPreview').hide();
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#sidebarLogoImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $('#sliderImagesInput').on('change', function(e) {
            const files = Array.from(e.target.files || []);
            const previewContainer = $('#sliderImagesNewPreview');
            previewContainer.empty();

            if (!files.length) {
                return;
            }

            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            for (const file of files) {
                if (file.size > 4 * 1024 * 1024) {
                    alert(`Ukuran file ${file.name} terlalu besar! Maksimal 4MB.`);
                    $(this).val('');
                    previewContainer.empty();
                    return;
                }

                if (!validTypes.includes(file.type)) {
                    alert(`Format file ${file.name} tidak valid! Gunakan JPG, PNG, atau WEBP.`);
                    $(this).val('');
                    previewContainer.empty();
                    return;
                }
            }

            $('#sliderImagesEmpty').remove();
            previewContainer.append('<div class="admin-gallery-new-label">Foto baru yang akan ditambahkan:</div>');

            files.forEach((file) => {
                const imageUrl = URL.createObjectURL(file);

                previewContainer.append(`
                    <div class="admin-gallery-card">
                        <img src="${imageUrl}" alt="Preview slider" class="admin-gallery-item">
                    </div>
                `);
            });
        });

        $(document).on('change', '.remove-gallery-checkbox', function() {
            const card = $(this).closest('.admin-gallery-card');
            card.toggleClass('to-remove', $(this).is(':checked'));
        });

        // Initialize job prospects array from existing data
        let jobProspects = [];
        try {
            jobProspects = JSON.parse($('#jobProspectsJson').val() || '[]');
        } catch (e) {
            jobProspects = [];
        }

        // Initial render
        renderJobProspects();

        // Add job prospect
        $('#addJobProspectBtn').click(function() {
            const jobName = prompt('Masukkan nama prospek kerja:');
            if (jobName && jobName.trim()) {
                jobProspects.push(jobName.trim());
                renderJobProspects();
                updateJobProspectsJsonField();
            }
        });

        // Render job prospects list
        function renderJobProspects() {
            $('#jobProspectsContainer').empty();

            if (jobProspects.length === 0) {
                $('#noJobProspectsMessage').show();
                return;
            }

            $('#noJobProspectsMessage').hide();

            jobProspects.forEach((job, index) => {
                $('#jobProspectsContainer').append(`
                <div class="service-item" data-index="${index}">
                    <span class="mr-2 font-weight-bold">${index + 1}.</span>
                    <input type="text" class="job-prospect-input form-control-sm" value="${job}"
                           placeholder="Nama prospek kerja...">
                    <button type="button" class="btn btn-sm btn-danger remove-job-prospect">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            `);
            });
        }

        // Update job prospect
        $(document).on('blur', '.job-prospect-input', function() {
            const index = $(this).closest('.service-item').data('index');
            const newValue = $(this).val().trim();

            if (newValue) {
                jobProspects[index] = newValue;
                updateJobProspectsJsonField();
            } else {
                alert('Nama prospek kerja tidak boleh kosong!');
                $(this).focus();
            }
        });

        // Enter key untuk update job prospect
        $(document).on('keypress', '.job-prospect-input', function(e) {
            if (e.which === 13) { // Enter key
                $(this).blur();
            }
        });

        // Remove job prospect
        $(document).on('click', '.remove-job-prospect', function() {
            const index = $(this).closest('.service-item').data('index');
            const jobName = jobProspects[index];

            if (confirm(`Hapus prospek kerja "${jobName}"?`)) {
                jobProspects.splice(index, 1);
                renderJobProspects();
                updateJobProspectsJsonField();
            }
        });

        // Update hidden JSON field for job prospects
        function updateJobProspectsJsonField() {
            $('#jobProspectsJson').val(JSON.stringify(jobProspects));
        }

        // Form validation
        $('#contentForm').submit(function(e) {
            // Update JSON before submit
            updateJobProspectsJsonField();

            // Show loading
            $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        });
    });
</script>
@endpush
