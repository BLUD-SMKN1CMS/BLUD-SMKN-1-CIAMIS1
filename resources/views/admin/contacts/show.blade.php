@extends('admin.layouts.app')

@section('title', 'Detail Pesan Kontak')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pesan</h1>
        <div>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#replyModal">
                <i class="fas fa-reply"></i> Balas
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Pesan dari: {{ $contact->name }}</h6>
                    <span class="badge 
                        @if($contact->status == 'unread') badge-danger
                        @elseif($contact->status == 'read') badge-warning
                        @elseif($contact->status == 'replied') badge-success
                        @else badge-secondary @endif">
                        {{ strtoupper($contact->status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>Email:</strong><br>
                            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                        </div>
                        <div class="col-md-6">
                            <strong>Telepon:</strong><br>
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Subjek:</strong><br>
                        {{ $contact->subject }}
                    </div>
                    
                    <div class="mb-3">
                        <strong>Pesan:</strong><br>
                        <div class="border p-3 rounded bg-light">
                            {{ $contact->message }}
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Dikirim pada:</strong><br>
                            {{ $contact->created_at->format('d F Y H:i') }}
                        </div>
                        @if($contact->replied_at)
                        <div class="col-md-6">
                            <strong>Dibalas pada:</strong><br>
                            {{ \Carbon\Carbon::parse($contact->replied_at)->format('d F Y H:i') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST" class="mb-3">
                        @csrf @method('PUT')
                        <div class="form-group">
                            <label>Ubah Status</label>
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                                <option value="archived" {{ $contact->status == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                            </select>
                        </div>
                    </form>
                    
                    <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="mb-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block" 
                            onclick="return confirm('Hapus pesan ini?')">
                            <i class="fas fa-trash"></i> Hapus Pesan
                        </button>
                    </form>
                    
                    <a href="{{ route('admin.contacts.edit', $contact->id) }}" class="btn btn-warning btn-block">
                        <i class="fas fa-edit"></i> Edit Status
                    </a>
                </div>
            </div>
            
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Info Pengirim</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $contact->name }}</p>
                    <p><strong>Email:</strong> {{ $contact->email }}</p>
                    <p><strong>Telepon:</strong> {{ $contact->phone }}</p>
                    <hr>
                    <p class="small text-muted">ID: {{ $contact->id }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Balas Pesan -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Balas ke {{ $contact->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kepada:</label>
                        <input type="text" class="form-control" value="{{ $contact->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Subjek:</label>
                        <input type="text" class="form-control" value="Re: {{ $contact->subject }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Pesan Balasan *</label>
                        <textarea name="reply_message" class="form-control" rows="5" required 
                            placeholder="Tulis balasan Anda..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection