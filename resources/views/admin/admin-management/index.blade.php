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
            <a href="{{ route('admin.admin-management.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i> Tambah Admin
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>TEFA</th>
                                <th>Dibuat</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $index => $admin)
                            <tr>
                                <td>{{ $admins->firstItem() + $index }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            {{ substr($admin->name, 0, 1) }}
                                        </div>
                                        <strong>{{ $admin->name }}</strong>
                                    </div>
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
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.admin-management.edit', $admin->id) }}"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.admin-management.destroy', $admin->id) }}"
                                            method="POST"
                                            class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
                @else
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada admin TEFA yang terdaftar</p>
                    <a href="{{ route('admin.admin-management.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Tambah Admin TEFA
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endsection