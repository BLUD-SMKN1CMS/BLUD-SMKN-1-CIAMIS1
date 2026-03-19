@extends('admin.layouts.app')

@section('title', 'Edit Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Layanan</h1>
        <a href="{{ route($routePrefix . '.services.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Data Layanan: {{ $service->name }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route($routePrefix . '.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                <div class="form-group">
                    <label>Nama Layanan *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $service->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $service->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Harga per Jam</label>
                        <input type="number" step="0.01" min="0" name="price_per_hour" class="form-control @error('price_per_hour') is-invalid @enderror"
                            value="{{ old('price_per_hour', $service->price_per_hour) }}" placeholder="Contoh: 50000">
                        @error('price_per_hour')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Harga per Hari</label>
                        <input type="number" step="0.01" min="0" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror"
                            value="{{ old('price_per_day', $service->price_per_day) }}" placeholder="Contoh: 300000">
                        @error('price_per_day')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Kapasitas</label>
                        <input type="number" min="0" name="capacity" class="form-control @error('capacity') is-invalid @enderror"
                            value="{{ old('capacity', $service->capacity) }}" placeholder="Contoh: 100">
                        @error('capacity')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Satuan</label>
                        <input type="text" name="unit" class="form-control @error('unit') is-invalid @enderror"
                            value="{{ old('unit', $service->unit) }}" placeholder="Contoh: orang / unit / kursi">
                        @error('unit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Foto Layanan (Bisa Lebih dari 1)</label>
                    <input type="file" id="galleryImagesInput" name="gallery_images[]" class="form-control @error('gallery_images') is-invalid @enderror @error('gallery_images.*') is-invalid @enderror"
                        accept="image/*" multiple>
                    @error('gallery_images')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('gallery_images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Pilih beberapa foto sekaligus untuk ditambahkan. Foto lama bisa dihapus per-item di panel preview kanan.</small>
                </div>

                <div class="form-group">
                    <label>Fasilitas & Keunggulan</label>
                    <textarea name="facilities" class="form-control" rows="5"
                        placeholder="Satu baris satu item. Format opsional: Judul|Deskripsi">{{ old('facilities', $service->facilities) }}</textarea>
                    <small class="text-muted">Contoh baris: Aman & Terpercaya|Dijamin keamanan dan kualitasnya</small>
                </div>

                <div class="form-group">
                    <label>Syarat & Ketentuan</label>
                    <textarea name="terms_conditions" class="form-control" rows="5"
                        placeholder="Satu baris satu syarat">{{ old('terms_conditions', $service->terms_conditions) }}</textarea>
                    <small class="text-muted">Contoh baris: Melakukan pemesanan minimal 3 hari sebelumnya</small>
                </div>

                <div class="form-group">
                    <label>Pilih Icon</label>
                    <div class="input-group">
                        <input type="text" name="icon" class="form-control" id="iconInput"
                            value="{{ old('icon', $service->icon ?? 'fas fa-concierge-bell') }}"
                            placeholder="fas fa-concierge-bell" readonly>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#iconModal">
                            <i class="fas fa-icons"></i> Pilih Icon
                        </button>
                    </div>
                    <small class="text-muted">Klik tombol untuk memilih icon dari daftar</small>

                    <!-- Icon Preview -->
                    <div class="mt-2" id="iconPreview">
                        <div class="border rounded p-3 text-center">
                            <i class="{{ old('icon', $service->icon ?? 'fas fa-concierge-bell') }} fa-2x mb-2 text-primary"></i>
                            <p class="mb-0 small text-muted" id="iconName">{{ old('icon', $service->icon ?? 'fas fa-concierge-bell') }}</p>
                        </div>
                    </div>
                </div>

                        <div class="form-group">
                            <label>Foto 360 Derajat (Opsional)</label>
                            <input type="file" id="panoramaInput" name="panorama_image" class="form-control @error('panorama_image') is-invalid @enderror"
                                accept="image/*">
                            @error('panorama_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Upload file baru untuk mengganti foto 360 saat ini.</small>
                        </div>

                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ $service->status == 'available' ? 'selected' : '' }}>Tersedia</option>
                        <option value="unavailable" {{ $service->status == 'unavailable' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Layanan
                            </button>
                            <a href="{{ route($routePrefix . '.services.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="services-preview-sticky">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview 360 Derajat</h6>
                </div>
                <div class="card-body">
                    @if($service->panorama_image_url)
                        <div id="admin-panorama-viewer" style="height: 360px; border-radius: 12px; overflow: hidden;"></div>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-info-circle me-1"></i>Geser untuk melihat sudut 360°.
                        </small>
                    @else
                        <div id="admin-panorama-fallback" class="d-flex flex-column align-items-center justify-content-center text-center"
                            style="height: 360px; border: 1px dashed #cbd5e0; border-radius: 12px; background: #f8fafc;">
                            <i class="fas fa-panorama fa-2x mb-2 text-muted"></i>
                            <p class="mb-0 text-muted">Belum ada foto 360.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Foto Layanan</h6>
                </div>
                <div class="card-body">
                    <div id="admin-gallery-preview" class="admin-gallery-preview">
                        @if($service->image)
                            <div class="admin-gallery-card" data-main-image="true">
                                <img src="{{ asset('storage/' . ltrim($service->image, '/')) }}" alt="Foto utama {{ $service->name }}" class="admin-gallery-item">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_main_image" value="1" id="remove_main_image">
                                    <label class="form-check-label small text-danger" for="remove_main_image">
                                        Hapus foto utama lama
                                    </label>
                                </div>
                            </div>
                        @endif

                        @foreach(($service->gallery_images ?? []) as $galleryImagePath)
                            <div class="admin-gallery-card" data-gallery-path="{{ $galleryImagePath }}">
                                <img src="{{ asset('storage/' . ltrim($galleryImagePath, '/')) }}" alt="Foto layanan {{ $service->name }}" class="admin-gallery-item">
                                <div class="form-check mt-2">
                                    <input class="form-check-input remove-gallery-checkbox" type="checkbox" name="remove_gallery_images[]" value="{{ $galleryImagePath }}" id="remove_{{ md5($galleryImagePath) }}">
                                    <label class="form-check-label small text-danger" for="remove_{{ md5($galleryImagePath) }}">
                                        Hapus foto ini
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(!$service->image && empty($service->gallery_images))
                        <div id="admin-gallery-empty" class="d-flex flex-column align-items-center justify-content-center text-center"
                            style="height: 200px; border: 1px dashed #cbd5e0; border-radius: 12px; background: #f8fafc;">
                            <i class="fas fa-images fa-2x mb-2 text-muted"></i>
                            <p class="mb-0 text-muted">Belum ada foto layanan.</p>
                        </div>
                    @endif

                    <div id="admin-gallery-new-preview" class="admin-gallery-preview mt-3"></div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk Pilih Icon -->
<div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="iconModalLabel">
                    <i class="fas fa-icons me-2"></i>Pilih Icon FontAwesome
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="iconSearch" placeholder="Cari icon...">
                            </div>
                        </div>

                        <div class="icon-grid" id="iconGrid" style="max-height: 400px; overflow-y: auto;">
                            <!-- Icon akan diisi oleh JavaScript -->
                        </div>

                        <div class="mt-3 alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Klik icon untuk memilih. Icon yang dipilih:
                            <strong id="currentSelectedIcon">{{ old('icon', $service->icon ?? 'fas fa-concierge-bell') }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-success" id="selectIconBtn">
                    <i class="fas fa-check me-1"></i> Pilih Icon
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@if($service->panorama_image_url)
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css"/>
@endif
<style>
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
        gap: 12px;
        padding: 10px;
    }

    .icon-item {
        padding: 15px;
        text-align: center;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .icon-item:hover {
        background-color: #f8f9fa;
        border-color: #4A90E2;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .icon-item.selected {
        background-color: #e3f2fd;
        border-color: #4A90E2;
        border-width: 3px;
    }

    .icon-item i {
        font-size: 28px;
        margin-bottom: 8px;
        color: #4A90E2;
    }

    .icon-name {
        font-size: 11px;
        word-break: break-word;
        color: #495057;
        font-weight: 500;
    }

    #iconInput[readonly] {
        background-color: #f8f9fa;
        cursor: pointer;
    }

    .admin-gallery-preview {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .admin-gallery-item {
        width: 100%;
        height: 120px;
        border-radius: 10px;
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

    .services-preview-sticky {
        position: sticky;
        top: 90px;
        z-index: 1;
    }
</style>
@endpush

@push('scripts')
@if($service->panorama_image_url)
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
@endif
<script>
    $(document).ready(function() {
        const popularIcons = [
            'fas fa-concierge-bell', 'fas fa-utensils', 'fas fa-bed',
            'fas fa-wifi', 'fas fa-tv', 'fas fa-shower',
            'fas fa-swimming-pool', 'fas fa-dumbbell', 'fas fa-spa',
            'fas fa-parking', 'fas fa-bus', 'fas fa-taxi',
            'fas fa-coffee', 'fas fa-cocktail', 'fas fa-birthday-cake',
            'fas fa-camera', 'fas fa-music', 'fas fa-gamepad',
            'fas fa-store', 'fas fa-shopping-cart', 'fas fa-credit-card',
            'fas fa-money-bill', 'fas fa-clock', 'fas fa-calendar-alt',
            'fas fa-map-marker-alt', 'fas fa-phone', 'fas fa-envelope',
            'fas fa-user', 'fas fa-users', 'fas fa-child',
            'fas fa-wheelchair', 'fas fa-paw', 'fas fa-smoking-ban',
            // Room and Building Icons
            'fas fa-building', 'fas fa-home', 'fas fa-door-open',
            'fas fa-warehouse', 'fas fa-store-alt', 'fas fa-hotel',
            'fas fa-archway', 'fas fa-dungeon', 'fas fa-place-of-worship',
            'fas fa-restroom', 'fas fa-person-booth', 'fas fa-hospital',
            'fas fa-school', 'fas fa-city', 'fas fa-landmark',
            'fas fa-campground', 'fas fa-industry'
        ];

        let selectedIcon = $('#iconInput').val();

        function loadIcons(search = '') {
            $('#iconGrid').empty();

            const filteredIcons = popularIcons.filter(icon =>
                icon.toLowerCase().includes(search.toLowerCase())
            );

            filteredIcons.forEach(icon => {
                const iconName = icon.replace('fas fa-', '');
                const isSelected = icon === selectedIcon;

                $('#iconGrid').append(`
                <div class="icon-item ${isSelected ? 'selected' : ''}" data-icon="${icon}">
                    <i class="${icon}"></i>
                    <div class="icon-name">${iconName}</div>
                </div>
            `);
            });

            $('#currentSelectedIcon').text(selectedIcon);
        }

        loadIcons();

        $('#iconSearch').on('input', function() {
            loadIcons($(this).val());
        });

        $(document).on('click', '.icon-item', function() {
            $('.icon-item').removeClass('selected');
            $(this).addClass('selected');
            selectedIcon = $(this).data('icon');
            $('#currentSelectedIcon').text(selectedIcon);
        });

        $('#selectIconBtn').click(function() {
            if (selectedIcon) {
                $('#iconInput').val(selectedIcon);
                $('#iconPreview i').attr('class', selectedIcon + ' fa-2x mb-2 text-primary');
                $('#iconName').text(selectedIcon);

                const iconModal = bootstrap.Modal.getInstance(document.getElementById('iconModal'));
                if (iconModal) {
                    iconModal.hide();
                }
            }
        });

        // Make readonly input clickable to open modal
        $('#iconInput').click(function() {
            const iconModal = new bootstrap.Modal(document.getElementById('iconModal'));
            iconModal.show();
        });

        @if($service->panorama_image_url)
        if (window.pannellum && document.getElementById('admin-panorama-viewer')) {
            pannellum.viewer('admin-panorama-viewer', {
                type: 'equirectangular',
                panorama: "{{ $service->panorama_image_url }}",
                autoLoad: true,
                showZoomCtrl: true,
                showFullscreenCtrl: true,
                compass: false,
                hfov: 110,
            });
        }
        @endif

        // Live preview for newly selected panorama image.
        $('#panoramaInput').on('change', function(e) {
            const file = e.target.files && e.target.files[0];
            if (!file) return;

            const blobUrl = URL.createObjectURL(file);
            const viewerId = 'admin-panorama-viewer';
            let viewer = document.getElementById(viewerId);

            if (!viewer) {
                const fallback = document.getElementById('admin-panorama-fallback');
                if (fallback) {
                    fallback.outerHTML = `<div id="${viewerId}" style="height: 360px; border-radius: 12px; overflow: hidden;"></div>`;
                }
                viewer = document.getElementById(viewerId);
            }

            if (viewer && window.pannellum) {
                viewer.innerHTML = '';
                pannellum.viewer(viewerId, {
                    type: 'equirectangular',
                    panorama: blobUrl,
                    autoLoad: true,
                    showZoomCtrl: true,
                    showFullscreenCtrl: true,
                    compass: false,
                    hfov: 110,
                });
            }
        });

        $('#galleryImagesInput').on('change', function(e) {
            const files = Array.from(e.target.files || []);
            const previewContainer = $('#admin-gallery-new-preview');
            previewContainer.empty();

            if (!files.length) return;

            $('#admin-gallery-empty').remove();
            previewContainer.append('<div class="admin-gallery-new-label">Foto baru yang akan ditambahkan:</div>');
            files.forEach(file => {
                const imageUrl = URL.createObjectURL(file);
                previewContainer.append(`
                    <div class="admin-gallery-card">
                        <img src="${imageUrl}" alt="Preview foto layanan" class="admin-gallery-item">
                    </div>
                `);
            });
        });

        $(document).on('change', '.remove-gallery-checkbox', function() {
            const card = $(this).closest('.admin-gallery-card');
            card.toggleClass('to-remove', $(this).is(':checked'));
        });
    });
</script>
@endpush
