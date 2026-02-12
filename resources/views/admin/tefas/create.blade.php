@extends('admin.layouts.app')

@section('title', 'Tambah TEFA Baru')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah TEFA Baru</h1>
        <a href="{{ route('admin.tefas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah TEFA</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tefas.store') }}" method="POST" id="tefaForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama TEFA *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" required placeholder="Contoh: Akuntansi Keuangan Lembaga">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Singkat *</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror"
                                value="{{ old('code') }}" required placeholder="Contoh: AKL">
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
                        placeholder="Deskripsi singkat tentang jurusan TEFA ini...">{{ old('description') }}</textarea>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Icon</label>
                            <div class="input-group">
                                <input type="text" name="icon" class="form-control" id="iconInput"
                                    value="{{ old('icon', 'fas fa-school') }}" 
                                    placeholder="fas fa-school" required readonly>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#iconModal">
                                    <i class="fas fa-icons"></i> Pilih Icon
                                </button>
                            </div>
                            <small class="text-muted">Klik tombol untuk memilih icon dari daftar</small>
                            
                            <!-- Icon Preview -->
                            <div class="mt-2" id="iconPreview">
                                <div class="border rounded p-3 text-center">
                                    <i class="{{ old('icon', 'fas fa-school') }} fa-2x mb-2 text-primary"></i>
                                    <p class="mb-0 small text-muted" id="iconName">fas fa-school</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Urutan Tampilan</label>
                            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0" max="100">
                            <small class="text-muted">Angka kecil = tampil di awal</small>
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
                                value='{{ old('services_json', '[]') }}'>
                            
                            <div class="text-center mt-3">
                                <p class="text-muted small" id="noServicesMessage">
                                    <i class="fas fa-info-circle"></i> Belum ada layanan yang ditambahkan
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Simpan TEFA
                    </button>
                    <a href="{{ route('admin.tefas.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Pilih Icon - FIXED BOOTSTRAP 5 -->
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
                            <strong id="currentSelectedIcon">fas fa-school</strong>
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
    
    .service-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #4A90E2;
        transition: all 0.3s;
    }
    
    .service-item:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }
    
    .service-item input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 8px;
        font-size: 0.95rem;
    }
    
    .service-item input:focus {
        outline: none;
        background: white;
        border-radius: 4px;
        box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.25);
    }
    
    .remove-service {
        color: #dc3545;
        cursor: pointer;
        margin-left: 10px;
        padding: 6px 12px;
        border-radius: 4px;
        transition: all 0.2s;
    }
    
    .remove-service:hover {
        color: #c82333;
        background: rgba(220, 53, 69, 0.1);
    }
    
    #iconInput[readonly] {
        background-color: #f8f9fa;
        cursor: pointer;
    }
</style>
@push('scripts')
<script>
$(document).ready(function() {
    // ============ ICON PICKER FIXED ============
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
        'fas fa-store', 'fas fa-industry', 'fas fa-truck',
        'fas fa-money-bill-wave', 'fas fa-chart-bar', 'fas fa-cube'
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
        
        // Update current selected icon text
        $('#currentSelectedIcon').text(selectedIcon);
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
        $('#currentSelectedIcon').text(selectedIcon);
    });
    
    // Tombol pilih icon
    $('#selectIconBtn').click(function() {
        if (selectedIcon) {
            $('#iconInput').val(selectedIcon);
            $('#iconPreview i').attr('class', selectedIcon + ' fa-2x mb-2 text-primary');
            $('#iconName').text(selectedIcon);
            
            // Close modal menggunakan Bootstrap 5 API
            const iconModal = bootstrap.Modal.getInstance(document.getElementById('iconModal'));
            if (iconModal) {
                iconModal.hide();
            }
            
            // Feedback
            showToast('Icon berhasil dipilih: ' + selectedIcon.replace('fas fa-', ''), 'success');
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
            showToast('Layanan ditambahkan', 'success');
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
                    <span class="badge bg-primary me-2">${index + 1}</span>
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
            showToast('Layanan diperbarui', 'info');
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
            showToast('Layanan dihapus', 'warning');
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
            showToast('Nama dan Kode TEFA harus diisi!', 'error');
            return false;
        }
        
        // Convert services to JSON
        updateJsonField();
    });
    
    // Toast notification
    function showToast(message, type = 'info') {
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-bg-${type} border-0" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation' : 'info'}-circle me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        // Add toast container if not exists
        if ($('#toastContainer').length === 0) {
            $('body').append('<div id="toastContainer" class="toast-container position-fixed bottom-0 end-0 p-3"></div>');
        }
        
        $('#toastContainer').append(toastHtml);
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, { delay: 3000 });
        toast.show();
        
        // Remove after hide
        toastElement.addEventListener('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
});
</script>
@endpush