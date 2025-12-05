@extends('admin.layouts.app')

@section('title', 'Tambah Kontak')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Kontak</h1>
    <div class="card shadow">
        <div class="card-body">
            <p class="text-muted">Halaman untuk menambah kontak manual (jarang digunakan).</p>
            <p>Kontak biasanya datang dari form publik di website.</p>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Lihat Daftar Kontak
            </a>
        </div>
    </div>
</div>
@endsection