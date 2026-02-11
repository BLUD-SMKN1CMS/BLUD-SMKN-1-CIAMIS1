@extends('layouts.app')

@section('title', 'Semua Produk')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Semua Produk TEFA</h1>
    
    <!-- Filter Form -->
    <form method="GET" action="{{ route('products.all') }}" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="tefa" class="form-label">Filter TEFA</label>
            <select name="tefa" id="tefa" class="form-select">
                <option value="all">Semua TEFA</option>
                @foreach($tefas as $tefa)
                    <option value="{{ $tefa->slug }}" {{ request('tefa') == $tefa->slug ? 'selected' : '' }}>
                        {{ $tefa->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="category" class="form-label">Filter Kategori</label>
            <select name="category" id="category" class="form-select">
                <option value="all">Semua Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="search" class="form-label">Cari Produk</label>
            <div class="input-group">
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>
    
    @if($products->isEmpty())
        <div class="alert alert-info">
            Tidak ditemukan produk.
        </div>
    @else
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="mb-2">
                                <span class="badge bg-primary">{{ $product->tefa->name }}</span>
                                <span class="badge bg-secondary">{{ $product->category }}</span>
                                @if($product->is_featured)
                                    <span class="badge bg-warning">Unggulan</span>
                                @endif
                            </div>
                            <h5 class="text-primary">{{ 'Rp ' . number_format($product->price, 0, ',', '.') }}</h5>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection