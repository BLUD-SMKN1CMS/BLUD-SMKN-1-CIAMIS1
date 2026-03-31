@extends('admin.layouts.app')

@section('title', 'Detail Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Layanan</h1>
        <div>
            <a href="{{ route($routePrefix . '.services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route($routePrefix . '.services.edit', $service->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $service->name }}</h6>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama Layanan</th>
                            <td>{{ $service->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug URL</th>
                            <td><code>/layanan/{{ $service->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Harga per Jam</th>
                            <td>{{ $service->price_per_hour ? 'Rp ' . number_format($service->price_per_hour, 0, ',', '.') : 'Tidak dikenakan biaya per jam' }}</td>
                        </tr>
                        <tr>
                            <th>Harga per Hari</th>
                            <td>Rp {{ number_format($service->price_per_day, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $service->status == 'available' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ \App\Helpers\StatusHelper::getServiceStatusLabel($service->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat</th>
                            <td>{{ $service->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <h5>Deskripsi Layanan</h5>
                        <div class="border p-3 rounded bg-light">
                            {{ $service->description ?? 'Tidak ada deskripsi' }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Fasilitas & Keunggulan</h5>
                        <div class="border p-3 rounded bg-light" style="white-space: pre-line;">
                            {{ $service->facilities ?: 'Belum diisi' }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Syarat & Ketentuan</h5>
                        <div class="border p-3 rounded bg-light" style="white-space: pre-line;">
                            {{ $service->terms_conditions ?: 'Belum diisi' }}
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Foto 360 Derajat</h5>
                        <div class="border p-3 rounded bg-light">
                            @if($service->panorama_image_url)
                            <img src="{{ $service->panorama_image_url }}" alt="Foto 360 {{ $service->name }}" class="img-fluid rounded border mb-2" style="max-height: 220px; object-fit: cover;">
                            <div class="small text-muted">File: {{ basename($service->panorama_image) }}</div>
                            @else
                            <span class="text-muted">Belum diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route($routePrefix . '.services.destroy', $service->id) }}" method="POST" class="mb-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block"
                            onclick="confirmDelete(event, 'Hapus layanan {{ addslashes($service->name) }}? Tindakan ini tidak dapat dibatalkan.')">
                            <i class="fas fa-trash"></i> Hapus Layanan
                        </button>
                    </form>

                    <a href="{{ route($routePrefix . '.services.edit', $service->id) }}" class="btn btn-warning btn-block mb-3">
                        <i class="fas fa-edit"></i> Edit Layanan
                    </a>

                    @if($service->status == 'available')
                    <form action="{{ route($routePrefix . '.services.update', $service->id) }}" method="POST" class="mb-3">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="unavailable">
                        <button type="submit" class="btn btn-secondary btn-block">
                            <i class="fas fa-ban"></i> Tandai Tidak Tersedia
                        </button>
                    </form>
                    @else
                    <form action="{{ route($routePrefix . '.services.update', $service->id) }}" method="POST" class="mb-3">
                        @csrf @method('PUT')
                        <input type="hidden" name="status" value="available">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-check"></i> Tandai Tersedia
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Harga</h6>
                </div>
                <div class="card-body">
                    <p><strong>Harga per Hari:</strong><br>
                        Rp {{ number_format($service->price_per_day, 0, ',', '.') }}</p>

                    <p><strong>Perhitungan:</strong></p>
                    <ul class="list-unstyled">
                        <li>1 hari: Rp {{ number_format($service->price_per_day, 0, ',', '.') }}</li>
                        <li>3 hari: Rp {{ number_format($service->price_per_day * 3, 0, ',', '.') }}</li>
                        <li>7 hari: Rp {{ number_format($service->price_per_day * 7, 0, ',', '.') }}</li>
                        <li>30 hari: Rp {{ number_format($service->price_per_day * 30, 0, ',', '.') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection