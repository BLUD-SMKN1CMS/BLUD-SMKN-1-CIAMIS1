@extends('admin.layouts.app')

@section('title', 'Edit Konten Program TEFA')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Konten Program TEFA</h1>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">×</button>
    </div>
    @endif

    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        Pilih program keahlian TEFA yang ingin Anda edit kontennya (About, Visi, Misi, Video, Prospek Kerja).
    </div>

    <div class="row">
        @forelse($tefas as $tefa)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100 border-left-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($tefa->logo)
                        <img src="{{ asset($tefa->logo) }}" alt="{{ $tefa->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: contain; margin-right: 15px;">
                        @else
                        <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; margin-right: 15px;">
                            <i class="fas fa-school fa-2x"></i>
                        </div>
                        @endif
                        <div>
                            <h5 class="mb-1 font-weight-bold">{{ $tefa->name }}</h5>
                            <span class="badge badge-{{ $tefa->is_active ? 'success' : 'secondary' }}">
                                {{ $tefa->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>

                    <p class="text-muted small mb-3">
                        <strong>Kode:</strong> {{ $tefa->code }}
                    </p>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span><i class="fas fa-info-circle"></i> About</span>
                            <span>{{ $tefa->about ? '✓' : '✗' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span><i class="fas fa-eye"></i> Visi</span>
                            <span>{{ $tefa->vision ? '✓' : '✗' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span><i class="fas fa-bullseye"></i> Misi</span>
                            <span>{{ $tefa->mission ? '✓' : '✗' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-1">
                            <span><i class="fas fa-video"></i> Video</span>
                            <span>{{ $tefa->video_url ? '✓' : '✗' }}</span>
                        </div>
                        <div class="d-flex justify-content-between text-muted small">
                            <span><i class="fas fa-briefcase"></i> Prospek Kerja</span>
                            <span>{{ $tefa->job_prospects && count($tefa->job_prospects) > 0 ? count($tefa->job_prospects) . ' item' : '✗' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('superadmin.tefas.content.edit', $tefa->id) }}" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Edit Konten
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i>
                Belum ada TEFA yang terdaftar.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection