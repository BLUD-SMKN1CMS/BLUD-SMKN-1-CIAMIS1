<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'tefa_id' => 'nullable|exists:tefas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'panorama_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->hasFile('panorama_image')) {
            $data['panorama_image'] = $request->file('panorama_image')->store('services/panorama', 'public');
        }

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
            'tefa_id' => 'nullable|exists:tefas,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'panorama_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($data['image']);
        }

        if ($request->hasFile('panorama_image')) {
            if ($service->panorama_image && Storage::disk('public')->exists($service->panorama_image)) {
                Storage::disk('public')->delete($service->panorama_image);
            }
            $data['panorama_image'] = $request->file('panorama_image')->store('services/panorama', 'public');
        } else {
            unset($data['panorama_image']);
        }

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

        if ($service->panorama_image && Storage::disk('public')->exists($service->panorama_image)) {
            Storage::disk('public')->delete($service->panorama_image);
        }

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route($this->getRoutePrefix() . '.services.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}
