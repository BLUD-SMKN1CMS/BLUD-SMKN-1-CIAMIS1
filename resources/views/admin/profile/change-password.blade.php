@extends('admin.layouts.app')

@section('title', 'Ubah Password')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Ubah Password</h1>
        <a href="{{ route('admin.profile.edit') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Profil
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>Terjadi kesalahan!
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-warning">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-key me-2"></i>Form Ubah Password
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.updatePassword') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Saat Ini *</label>
                            <input type="password" name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   required placeholder="Masukkan password saat ini">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password Baru *</label>
                            <input type="password" name="new_password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   required placeholder="Minimal 6 karakter">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Password minimal 6 karakter</small>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Konfirmasi Password Baru *</label>
                            <input type="password" name="new_password_confirmation" 
                                   class="form-control" 
                                   required placeholder="Ulangi password baru">
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Tips:</strong> Pastikan password mudah diingat tapi sulit ditebak. 
                            Gunakan kombinasi huruf, angka, dan simbol.
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-user me-2"></i> Kembali ke Profil
                            </a>
                            <div>
                                <button type="submit" class="btn btn-warning px-4">
                                    <i class="fas fa-key me-2"></i> Ubah Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Security Tips -->
            <div class="card border-left-success shadow">
                <div class="card-body">
                    <h6 class="font-weight-bold text-success mb-3">
                        <i class="fas fa-shield-alt me-2"></i>Tips Keamanan Password
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Gunkan password minimal 8 karakter
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Kombinasikan huruf besar, kecil, angka, dan simbol
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Jangan gunakan informasi pribadi (tanggal lahir, nama)
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Ganti password secara berkala
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Jangan bagikan password ke siapapun
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection