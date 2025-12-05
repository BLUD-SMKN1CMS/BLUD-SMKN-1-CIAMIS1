@extends('admin.layouts.app')

@section('title', 'Edit Kontak')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Pesan Kontak</h1>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pesan dari: {{ $contact->name }}</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.contacts.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pengirim</label>
                            <input type="text" class="form-control" value="{{ $contact->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $contact->email }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telepon</label>
                            <input type="text" class="form-control" value="{{ $contact->phone }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Subjek</label>
                            <input type="text" class="form-control" value="{{ $contact->subject }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Pesan</label>
                    <textarea class="form-control" rows="5" readonly>{{ $contact->message }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Dikirim</label>
                            <input type="text" class="form-control" 
                                value="{{ $contact->created_at->format('d M Y H:i') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status *</label>
                            <select name="status" class="form-control" required>
                                <option value="unread" {{ $contact->status == 'unread' ? 'selected' : '' }}>Belum Dibaca</option>
                                <option value="read" {{ $contact->status == 'read' ? 'selected' : '' }}>Sudah Dibaca</option>
                                <option value="replied" {{ $contact->status == 'replied' ? 'selected' : '' }}>Sudah Dibalas</option>
                                <option value="archived" {{ $contact->status == 'archived' ? 'selected' : '' }}>Diarsipkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                @if($contact->replied_at)
                <div class="form-group">
                    <label>Tanggal Dibalas</label>
                    <input type="text" class="form-control" 
                        value="{{ \Carbon\Carbon::parse($contact->replied_at)->format('d M Y H:i') }}" readonly>
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                    
                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-info">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                    
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#replyModal">
                        <i class="fas fa-reply"></i> Balas Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal untuk Balas Pesan -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Balas Pesan ke {{ $contact->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.contacts.reply', $contact->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Email Tujuan</label>
                        <input type="text" class="form-control" value="{{ $contact->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Subjek</label>
                        <input type="text" class="form-control" value="Re: {{ $contact->subject }}" readonly>
                    </div>
                    <div class="form-group">
                        <label>Pesan Balasan *</label>
                        <textarea name="reply_message" class="form-control" rows="5" required 
                            placeholder="Tulis balasan Anda di sini..."></textarea>
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