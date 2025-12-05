@extends('admin.layouts.app')

@section('title', 'Detail TEFA')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail TEFA</h1>
        <a href="{{ route('admin.tefas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $tefa->name }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h4>Informasi TEFA</h4>
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $tefa->name }}</td>
                        </tr>
                        <tr>
                            <th>Kode</th>
                            <td><span class="badge badge-primary">{{ $tefa->code }}</span></td>
                        </tr>
                        <tr>
                            <th>Slug URL</th>
                            <td><code>/tefa/{{ $tefa->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Icon</th>
                            <td>
                                @if($tefa->icon)
                                    <i class="{{ $tefa->icon }} fa-2x"></i> {{ $tefa->icon }}
                                @else
                                    <span class="text-muted">Belum ada icon</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $tefa->is_active ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $tefa->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Urutan Tampilan</th>
                            <td>{{ $tefa->order }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>{{ $tefa->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                    
                    <h4 class="mt-4">Deskripsi</h4>
                    <div class="border p-3 rounded">
                        {{ $tefa->description ?? 'Tidak ada deskripsi' }}
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">Aksi</h6>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('admin.tefas.edit', $tefa->id) }}" class="btn btn-warning btn-block mb-2">
                                <i class="fas fa-edit"></i> Edit TEFA
                            </a>
                            <form action="{{ route('admin.tefas.destroy', $tefa->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block" 
                                    onclick="return confirm('Hapus TEFA ini? Semua produk di dalamnya juga akan dihapus!')">
                                    <i class="fas fa-trash"></i> Hapus TEFA
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">Layanan TEFA</h6>
                        </div>
                        <div class="card-body">
                            @php
                                $services = json_decode($tefa->services_json ?? '[]', true);
                            @endphp
                            
                            @if(!empty($services))
                                <ul class="list-group">
                                    @foreach($services as $service)
                                        <li class="list-group-item">{{ $service }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">Belum ada layanan yang didefinisikan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection