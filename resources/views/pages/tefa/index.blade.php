@extends('layouts.app')

@section('title', 'Semua TEFA - BLUD SMKN 1 CIAMIS')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-primary mb-3">Teaching Factory (TEFA)</h1>
                <p class="lead">7 Jurusan Unggulan SMKN 1 Ciamis</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($tefas as $tefa)
                <div class="col-md-4">
                    <div class="tefa-card p-4 h-100">
                        <div class="text-center mb-4">
                            <div class="tefa-icon mx-auto">
                                <i class="fas fa-{{ $tefa->code == 'AKL' ? 'calculator' : ($tefa->code == 'PM' ? 'chart-line' : ($tefa->code == 'MPLB' ? 'building' : ($tefa->code == 'HOTEL' ? 'hotel' : ($tefa->code == 'KULINER' ? 'utensils' : ($tefa->code == 'DKV' ? 'palette' : 'code'))))) }}"></i>
                            </div>
                            <h3 class="fw-bold">{{ $tefa->name }}</h3>
                            <span class="badge bg-primary">{{ $tefa->code }}</span>
                        </div>
                        
                        <p class="text-muted">{{ $tefa->description }}</p>
                        
                        <div class="contact-info mt-4">
                            <p class="mb-2"><i class="fas fa-user me-2 text-primary"></i> {{ $tefa->contact_person }}</p>
                            <p class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> {{ $tefa->contact_number }}</p>
                            <p class="mb-3"><i class="fas fa-envelope me-2 text-primary"></i> {{ $tefa->contact_email }}</p>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('tefa.show', $tefa->slug) }}" class="btn btn-primary w-100">
                                <i class="fas fa-box-open me-2"></i>Lihat Detail Produk
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection