@extends('layouts.app')

@section('title', 'Semua TEFA')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Semua Jurusan TEFA SMKN 1 Ciamis</h1>
    
    @if($tefas->isEmpty())
        <div class="alert alert-info">
            Belum ada data TEFA.
        </div>
    @else
        <div class="row">
            @foreach($tefas as $tefa)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $tefa->name }}</h5>
                            <p class="card-text">{{ Str::limit($tefa->description, 150) }}</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $tefa->code }}</span>
                                <span class="badge bg-success">{{ $tefa->products_count }} Produk</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('tefa.show', $tefa->slug) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
