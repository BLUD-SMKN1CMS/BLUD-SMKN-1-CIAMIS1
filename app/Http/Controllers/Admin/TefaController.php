<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TefaController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, hanya tampilkan TEFA miliknya
        $query = Tefa::orderBy('order');

        if ($admin->isAdminTefa()) {
            $query->where('id', $admin->tefa_id);
        }

        $tefas = $query->get();
        return view('admin.tefas.index', compact('tefas'));
    }

    public function create()
    {
        $admin = Auth::guard('admin')->user();

        // Admin-tefa tidak bisa membuat TEFA baru
        if ($admin->isAdminTefa()) {
            return redirect()->route('superadmin.tefas.index')
                ->with('error', 'Anda tidak memiliki izin untuk membuat TEFA baru');
        }

        return view('admin.tefas.create');
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Admin-tefa tidak bisa menyimpan TEFA baru
        if ($admin->isAdminTefa()) {
            return redirect()->route('superadmin.tefas.index')
                ->with('error', 'Anda tidak memiliki izin untuk membuat TEFA baru');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:tefas,code',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Tefa::create($data);

        return redirect()->route('superadmin.tefas.index')
            ->with('success', 'TEFA berhasil ditambahkan');
    }

    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa hanya bisa lihat TEFA miliknya
        if ($admin->isAdminTefa() && $tefa->id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke TEFA ini');
        }

        return view('admin.tefas.show', compact('tefa'));
    }

    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa hanya bisa edit TEFA miliknya
        if ($admin->isAdminTefa() && $tefa->id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke TEFA ini');
        }

        return view('admin.tefas.edit', compact('tefa'));
    }

    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa hanya bisa edit TEFA miliknya
        if ($admin->isAdminTefa() && $tefa->id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke TEFA ini');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:tefas,code,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $tefa->update($data);

        return redirect()->route('superadmin.tefas.index')
            ->with('success', 'TEFA berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa tidak bisa menghapus TEFA
        if ($admin->isAdminTefa()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus TEFA');
        }

        $tefa->delete();

        return redirect()->route('superadmin.tefas.index')
            ->with('success', 'TEFA berhasil dihapus');
    }
}
