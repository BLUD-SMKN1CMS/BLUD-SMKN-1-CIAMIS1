@extends('admin.layouts.app')

@section('title', 'Tambah Admin TEFA')

@section('page-title', 'Tambah Admin TEFA')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Form Tambah Admin TEFA</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.admin-management.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control @error('username') is-invalid @enderror"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            required>
                        <small class="text-muted">Username untuk login</small>
                        @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tefa_id" class="form-label">TEFA <span class="text-danger">*</span></label>
                        <select class="form-select @error('tefa_id') is-invalid @enderror"
                            id="tefa_id"
                            name="tefa_id"
                            required>
                            <option value="">-- Pilih TEFA --</option>
                            @foreach($tefas as $tefa)
                            <option value="{{ $tefa->id }}" {{ old('tefa_id') == $tefa->id ? 'selected' : '' }}>
                                {{ $tefa->code }} - {{ $tefa->name }}
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Admin akan mengelola TEFA yang dipilih</small>
                        @error('tefa_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required>
                        <small class="text-muted">Minimal 8 karakter</small>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation"
                            name="password_confirmation"
                            required>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.admin-management.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Admin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection