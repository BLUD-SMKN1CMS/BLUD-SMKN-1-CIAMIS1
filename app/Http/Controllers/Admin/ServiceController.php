<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, hanya tampilkan services untuk TEFA miliknya
        $query = Service::with('tefa')->orderBy('created_at', 'desc');

        if ($admin->isAdminTefa()) {
            $query->where('tefa_id', $admin->tefa_id);
        }

        $services = $query->get();
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $admin = Auth::guard('admin')->user();

        // Dropdown TEFA: superadmin lihat semua, admin-tefa hanya miliknya
        $tefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->get()
            : Tefa::where('is_active', true)->get();

        return view('admin.services.create', compact('tefas'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, force tefa_id sesuai miliknya
        if ($admin->isAdminTefa()) {
            $request->merge(['tefa_id' => $admin->tefa_id]);
        }

        $request->validate([
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Service::create($data);

        return redirect()->route($this->getRoutePrefix() . '.services.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        $service = Service::findOrFail($id);

        // Admin-tefa hanya bisa lihat service untuk TEFA miliknya
        if ($admin->isAdminTefa() && $service->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke layanan ini');
        }

        return view('admin.services.show', compact('service'));
    }

    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $service = Service::findOrFail($id);

        // Admin-tefa hanya bisa edit service untuk TEFA miliknya
        if ($admin->isAdminTefa() && $service->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke layanan ini');
        }

        // Dropdown TEFA: superadmin lihat semua, admin-tefa hanya miliknya
        $tefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->get()
            : Tefa::where('is_active', true)->get();

        return view('admin.services.edit', compact('service', 'tefas'));
    }

    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $service = Service::findOrFail($id);

        // Admin-tefa hanya bisa update service untuk TEFA miliknya
        if ($admin->isAdminTefa() && $service->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke layanan ini');
        }

        // Jika admin-tefa, force tefa_id sesuai miliknya
        if ($admin->isAdminTefa()) {
            $request->merge(['tefa_id' => $admin->tefa_id]);
        }

        $request->validate([
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $service->update($data);

        return redirect()->route($this->getRoutePrefix() . '.services.index')
            ->with('success', 'Layanan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $admin = Auth::guard('admin')->user();
        $service = Service::findOrFail($id);

        // Admin-tefa tidak bisa delete service
        if ($admin->isAdminTefa()) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus layanan');
        }

        $service->delete();

        return redirect()->route($this->getRoutePrefix() . '.services.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}
