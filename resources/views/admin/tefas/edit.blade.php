@extends('admin.layouts.app')

@section('title', 'Edit TEFA')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit TEFA</h1>
        <a href="{{ route('admin.tefas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data TEFA: {{ $tefa->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tefas.update', $tefa->id) }}" method="POST" id="tefaForm">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama TEFA *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $tefa->name) }}" required placeholder="Contoh: Akuntansi Keuangan Lembaga">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Singkat *</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code', $tefa->code) }}" required placeholder="Contoh: AKL">
                            <small class="text-muted">Kode 3 huruf (contoh: AKL, PM, DKV, PPLG)</small>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="description" class="form-control" rows="3" 
                        placeholder="Deskripsi singkat tentang jurusan TEFA ini...">{{ old('description', $tefa->description) }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Icon</label>
                            <div class="input-group">
                                <input type="text" name="icon" class="form-control" id="iconInput"
                                    value="{{ old('icon', $tefa->icon ?? 'fas fa-school') }}" 
                                    placeholder="fas fa-school" required>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#iconModal">
                                    <i class="fas fa-icons"></i> Pilih Icon
                                </button>
                            </div>
                            <small class="text-muted">Klik tombol untuk memilih icon dari daftar</small>
                            
                            <!-- Icon Preview -->
                            <div class="mt-2" id="iconPreview">
                                <div class="border rounded p-3 text-center">
                                    <i class="{{ old('icon', $tefa->icon ?? 'fas fa-school') }} fa-2x mb-2 text-primary"></i>
                                    <p class="mb-0 small text-muted" id="iconName">{{ old('icon', $tefa->icon ?? 'fas fa-school') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ $tefa->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$tefa->is_active ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Urutan Tampilan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', $tefa->order) }}" min="0" max="100">
                            <small class="text-muted">Angka kecil = tampil di awal</small>
                        </div>
                    </div>
                </div>

                <!-- Layanan per Jurusan - UI YANG LEBIH USER FRIENDLY -->
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
                                value='{{ old('services_json', $tefa->services_json ?? '[]') }}'>
                            
                            <div class="text-center mt-3">
                                <p class="text-muted small" id="noServicesMessage">
                                    <i class="fas fa-info-circle"></i> Belum ada layanan yang ditambahkan
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contoh layanan berdasarkan jurusan -->
                    <div class="alert alert-info small">
                        <strong>Contoh layanan per jurusan:</strong><br>
                        • AKL: Laporan Keuangan, Bimbingan Pelaporan, Myob/Spreadsheet<br>
                        • MPLB: Layanan Bisnis, Event Organizer, Agen POS<br>
                        • KULINER: Bakery, Catering, Cafe & Resto<br>
                        • DKV: Desain Grafis, Videografis, Percetakan<br>
                        • PPLG: Service Komputer, Pengembangan Aplikasi<br>
                        • PERHOTELAN: Jasa Laundry, Meeting Service, Jasa Perhotelan
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update TEFA
                    </button>
                    <a href="{{ route('admin.tefas.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Pilih Icon -->
<div class="modal fade" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="iconModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="iconModalLabel">Pilih Icon FontAwesome</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Daftar Icon Populer -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="text" class="form-control" id="iconSearch" placeholder="Cari icon...">
                        </div>
                        
                        <div class="icon-grid" id="iconGrid" style="max-height: 400px; overflow-y: auto;">
                            <!-- Icon akan diisi oleh JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="selectIconBtn">Pilih Icon</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
        gap: 10px;
        padding: 10px;
    }
    
    .icon-item {
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .icon-item:hover {
        background-color: #f8f9fa;
        border-color: #4A90E2;
        transform: translateY(-2px);
    }
    
    .icon-item.selected {
        background-color: #e3f2fd;
        border-color: #4A90E2;
        border-width: 2px;
    }
    
    .icon-item i {
        font-size: 24px;
        margin-bottom: 5px;
        color: #4A90E2;
    }
    
    .icon-name {
        font-size: 11px;
        word-break: break-word;
        color: #666;
    }
    
    .service-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        border-left: 4px solid #4A90E2;
    }
    
    .service-item input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 5px;
    }
    
    .service-item input:focus {
        outline: none;
        background: white;
        border-radius: 3px;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.25);
    }
    
    .remove-service {
        color: #dc3545;
        cursor: pointer;
        margin-left: 10px;
        padding: 5px 10px;
        background: none;
        border: none;
        transition: all 0.3s;
    }
    
    .remove-service:hover {
        color: #c82333;
        transform: scale(1.1);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .icon-grid {
            grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        }
        
        .icon-item {
            padding: 10px;
        }
        
        .icon-item i {
            font-size: 20px;
        }
        
        .service-item {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .service-item input {
            width: 100%;
            margin: 5px 0;
        }
        
        .remove-service {
            align-self: flex-end;
        }
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // ============ ICON PICKER ============
    const popularIcons = [
        'fas fa-school', 'fas fa-laptop-code', 'fas fa-paint-brush', 
        'fas fa-utensils', 'fas fa-hotel', 'fas fa-briefcase',
        'fas fa-chart-line', 'fas fa-calculator', 'fas fa-building',
        'fas fa-desktop', 'fas fa-camera', 'fas fa-car',
        'fas fa-book', 'fas fa-flask', 'fas fa-microchip',
        'fas fa-code', 'fas fa-database', 'fas fa-network-wired',
        'fas fa-print', 'fas fa-video', 'fas fa-music',
        'fas fa-tools', 'fas fa-wrench', 'fas fa-cogs',
        'fas fa-graduation-cap', 'fas fa-user-tie', 'fas fa-users',
        'fas fa-chart-bar', 'fas fa-money-bill-wave', 'fas fa-file-invoice',
        'fas fa-store', 'fas fa-shopping-cart', 'fas fa-truck',
        'fas fa-coffee', 'fas fa-birthday-cake', 'fas fa-concierge-bell',
        'fas fa-bed', 'fas fa-bell-concierge', 'fas fa-towel',
        'fas fa-palette', 'fas fa-film', 'fas fa-print',
        'fas fa-server', 'fas fa-mobile-alt', 'fas fa-globe'
    ];
    
    let selectedIcon = $('#iconInput').val();
    
    // Load icons ke modal
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
        
        // Jika tidak ada icon yang cocok dengan search
        if (filteredIcons.length === 0) {
            $('#iconGrid').html(`
                <div class="col-12 text-center py-5">
                    <i class="fas fa-search fa-2x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada icon yang cocok dengan pencarian</p>
                </div>
            `);
        }
    }
    
    // Inisialisasi icons
    loadIcons();
    
    // Search icons
    $('#iconSearch').on('input', function() {
        loadIcons($(this).val());
    });
    
    // Pilih icon
    $(document).on('click', '.icon-item', function() {
        $('.icon-item').removeClass('selected');
        $(this).addClass('selected');
        selectedIcon = $(this).data('icon');
    });
    
    // Tombol pilih icon
    $('#selectIconBtn').click(function() {
        if (selectedIcon) {
            $('#iconInput').val(selectedIcon);
            $('#iconPreview i').attr('class', selectedIcon + ' fa-2x mb-2 text-primary');
            $('#iconName').text(selectedIcon);
            $('#iconModal').modal('hide');
        } else {
            alert('Silakan pilih icon terlebih dahulu!');
        }
    });
    
    // Update preview saat input berubah
    $('#iconInput').on('input', function() {
        const icon = $(this).val();
        if (icon) {
            $('#iconPreview i').attr('class', icon + ' fa-2x mb-2 text-primary');
            $('#iconName').text(icon);
            selectedIcon = icon;
        }
    });
    
    // ============ SERVICES MANAGEMENT ============
    let services = [];
    
    // Parse existing services from JSON
    try {
        const existingServices = @json($tefa->services_json ? json_decode($tefa->services_json, true) : []);
        services = existingServices || [];
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
                    <span class="mr-2 font-weight-bold">${index + 1}.</span>
                    <input type="text" class="service-input form-control-sm" value="${service}" 
                           placeholder="Nama layanan...">
                    <button type="button" class="btn btn-sm btn-danger remove-service">
                        <i class="fas fa-trash"></i> Hapus
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
            $(this).focus();
        }
    });
    
    // Enter key untuk update service
    $(document).on('keypress', '.service-input', function(e) {
        if (e.which === 13) { // Enter key
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
        // Simple validation
        const name = $('input[name="name"]').val().trim();
        const code = $('input[name="code"]').val().trim();
        
        if (!name) {
            e.preventDefault();
            alert('Nama TEFA harus diisi!');
            $('input[name="name"]').focus();
            return false;
        }
        
        if (!code) {
            e.preventDefault();
            alert('Kode TEFA harus diisi!');
            $('input[name="code"]').focus();
            return false;
        }
        
        // Validasi kode (harus huruf dan angka, max 10 karakter)
        if (!/^[A-Za-z0-9]{1,10}$/.test(code)) {
            e.preventDefault();
            alert('Kode harus berupa huruf/angka (maksimal 10 karakter)!');
            $('input[name="code"]').focus();
            return false;
        }
        
        // Convert services to JSON
        updateJsonField();
        
        // Show loading
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Memproses...');
    });
    
    // Auto-preview saat icon berubah
    $('input[name="icon"]').on('change', function() {
        const iconClass = $(this).val();
        if (iconClass) {
            $('#iconPreview i').attr('class', iconClass + ' fa-2x mb-2 text-primary');
            $('#iconName').text(iconClass);
        }
    });
});
</script>
@endpush