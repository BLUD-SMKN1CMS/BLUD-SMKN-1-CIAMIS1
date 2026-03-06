@extends('admin.layouts.app')

@section('title', 'Kelola Admin TEFA')

@section('page-title', 'Kelola Admin TEFA')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">Daftar Admin TEFA</h4>
                <p class="text-muted small mb-0">Kelola admin untuk setiap jurusan TEFA</p>
            </div>
            <a href="{{ route($routePrefix . '.admin-management.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Admin
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Admin TEFA</h6>
                <span class="badge badge-success">
                    Total: {{ $admins->count() }}
                </span>
            </div>
            <div class="card-body">
                @if($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>TEFA</th>
                                <th>Dibuat</th>
                                <th width="100" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $admin->name }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <i class="fas fa-user me-1"></i>{{ $admin->username }}
                                    </span>
                                </td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    @if($admin->tefa)
                                    <span class="badge bg-primary">
                                        {{ $admin->tefa->code }} - {{ $admin->tefa->name }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>{{ $admin->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route($routePrefix . '.admin-management.edit', $admin->id) }}">
                                                    <i class="fas fa-edit me-2 text-warning"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route($routePrefix . '.admin-management.destroy', $admin->id) }}"
                                                    method="POST" id="delete-admin-{{ $admin->id }}"
                                                    onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="submit" form="delete-admin-{{ $admin->id }}"
                                                    class="dropdown-item text-danger text-decoration-none w-100 text-start">
                                                    <i class="fas fa-trash me-2"></i> Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $admins->links() }}
                </div>
                <div class="mt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">
                                Menampilkan {{ $admins->count() }} admin
                            </small>
                        </div>
                        <div class="col-md-6 text-right">
                            <small class="text-muted">
                                <i class="fas fa-info-circle mr-1"></i>
                                Klik 3 titik untuk menu aksi
                            </small>
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada admin TEFA yang terdaftar</p>
                    <a href="{{ route($routePrefix . '.admin-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Admin TEFA
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .dropdown-toggle::after {
        display: none !important;
    }

    .dropdown-toggle {
        border: none !important;
        background: transparent !important;
        color: #6c757d;
        padding: 0.25rem 0.5rem;
    }

    .dropdown-toggle:hover {
        color: #495057;
        background: transparent !important;
    }

    .dropdown-toggle:focus {
        box-shadow: none !important;
    }

    .dropdown-menu {
        min-width: 180px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border: 1px solid #eee;
    }

    .dropdown-item {
        padding: 8px 15px;
        font-size: 0.9rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(3px);
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
    }
</style>
@endpush