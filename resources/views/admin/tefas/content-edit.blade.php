@extends('admin.layouts.app')

@section('title', 'Edit Konten ' . $tefa->name)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit"></i> Edit Konten Program Keahlian
            </h1>
            <p class="text-muted mb-0">{{ $tefa->name }} ({{ $tefa->code }})</p>
        </div>
        <a href="{{ route('superadmin.tefas.content.index') }}" class="btn btn-secondary">
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

    <!-- Form -->
    <form action="{{ route('superadmin.tefas.content.update', $tefa->id) }}" method="POST" id="contentForm">
        @csrf
        @method('PUT')

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h6 class="m-0 font-weight-bold">
                    <i class="fas fa-file-alt"></i> Konten Detail Halaman Jurusan
                </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label><strong><i class="fas fa-info-circle"></i> Tentang Jurusan Ini</strong></label>
                    <textarea name="about" class="form-control" rows="6"
                        placeholder="Tulis penjelasan lengkap tentang jurusan ini, apa yang dipelajari, keunggulan, dll...">{{ old('about', $tefa->about) }}</textarea>
                    <small class="text-muted">Penjelasan detail tentang jurusan yang akan ditampilkan di bagian "Tentang"</small>
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

                <!-- Prospek Kerja Management -->
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
                            <!-- Container untuk daftar prospek kerja -->
                            <div id="jobProspectsContainer">
                                <!-- Prospek kerja akan ditambahkan di sini -->
                            </div>

                            <!-- Input tersembunyi untuk JSON -->
                            <input type="hidden" name="job_prospects_json" id="jobProspectsJson"
                                value='{{ old('job_prospects_json', $tefa->job_prospects ? json_encode($tefa->job_prospects) : '[]') }}'>

                            <div class="text-center mt-3">
                                <p class="text-muted small" id="noJobProspectsMessage">
                                    <i class="fas fa-info-circle"></i> Belum ada prospek kerja yang ditambahkan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contoh prospek kerja -->
                    <div class="alert alert-info small mt-2">
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

        <div class="text-right mb-5">
            <a href="{{ route('superadmin.tefas.content.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>
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
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
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