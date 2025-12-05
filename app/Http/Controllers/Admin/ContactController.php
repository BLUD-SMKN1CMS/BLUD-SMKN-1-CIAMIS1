<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Tandai sebagai dibaca jika belum
        if (!$contact->status || $contact->status == 'unread') {
            $contact->update(['status' => 'read']);
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:unread,read,replied,archived'
        ]);
        
        $contact->update($request->only('status'));
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Status pesan diperbarui');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Pesan berhasil dihapus');
    }

    public function reply(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        
        $request->validate([
            'reply_message' => 'required|string'
        ]);
        
        // Simpan balasan (tidak perlu kirim email untuk demo)
        $contact->update([
            'status' => 'replied',
            'replied_at' => now()
        ]);
        
        return redirect()->route('admin.contacts.show', $contact)
            ->with('success', 'Balasan telah disimpan');
    }

    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update(['status' => 'read']);
        
        return response()->json(['success' => true]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada pesan yang dipilih');
        }
        
        Contact::whereIn('id', $ids)->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', count($ids) . ' pesan berhasil dihapus');
    }
}