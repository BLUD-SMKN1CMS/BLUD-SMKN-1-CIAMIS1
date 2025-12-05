@extends('admin.layouts.app') 
 
@section('content') 
<div class="container-fluid"> 
    <div class="row"> 
        <div class="col-12"> 
            <div class="card"> 
                <div class="card-header"> 
                    <h3 class="card-title"> 
                        <i class="fas fa-cog"></i> Pengaturan Website 
                    </h3> 
                </div> 
                <div class="card-body">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        @foreach($groups as $group => $items)
        <div class="card card-primary mb-3">
            <div class="card-header">
                <h4 class="mb-0">
                    @if($group == 'contact')
                        <i class="fas fa-address-book"></i> Kontak & Informasi
                    @elseif($group == 'social')
                        <i class="fas fa-share-alt"></i> Media Sosial
                    @elseif($group == 'hours')
                        <i class="fas fa-clock"></i> Jam Operasional
                    @else
                        <i class="fas fa-cog"></i> Pengaturan {{ ucfirst($group) }}
                    @endif
                </h4>
            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($items as $setting)
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">{{ $setting->description }}</label>
                                        
                                        @if($setting->type == 'textarea')
                                            <textarea name="{{ $setting->key }}" class="form-control" rows="3">{{ $setting->value }}</textarea>
                                        @elseif($setting->type == 'email')
                                            <input type="email" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                                        @elseif($setting->type == 'url')
                                            <input type="url" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}" placeholder="https://">
                                        @else
                                            <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                                        @endif
                                        
                                        @if($setting->group == 'hours')
                                            <small class="text-muted">Contoh: Senin - Jumat: 08:00 - 16:00</small>
                                        @endif
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Semua Perubahan
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div> 
        </div> 
    </div> 
</div> 
@endsection 
