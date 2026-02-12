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
                    <label>Pilih Icon</label>
                    <div class="input-group">
                        <input type="text" name="icon" class="form-control" id="iconInput"
                            value="{{ old('icon', 'fas fa-concierge-bell') }}"
                            placeholder="fas fa-concierge-bell" readonly>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#iconModal">
                            <i class="fas fa-icons"></i> Pilih Icon
                        </button>
                    </div>
                    <small class="text-muted">Klik tombol untuk memilih icon dari daftar</small>

                    <!-- Icon Preview -->
                    <div class="mt-2" id="iconPreview">
                        <div class="border rounded p-3 text-center">
                            <i class="{{ old('icon', 'fas fa-concierge-bell') }} fa-2x mb-2 text-primary"></i>
                            <p class="mb-0 small text-muted" id="iconName">fas fa-concierge-bell</p>
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
                            <strong id="currentSelectedIcon">fas fa-concierge-bell</strong>
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
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
</style>
@endpush

@push('scripts')
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
});
</script>
@endpush