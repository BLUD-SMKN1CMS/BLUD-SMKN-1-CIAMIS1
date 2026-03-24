<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $this->authorizeSuperAdmin();

        $query = Service::with('tefa')->orderBy('created_at', 'desc');

        $services = $query->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $this->authorizeSuperAdmin();

        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $this->authorizeSuperAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'remove_main_image' => 'nullable|boolean',
            'remove_gallery_images' => 'nullable|array',
            'remove_gallery_images.*' => 'nullable|string',
            'panorama_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['tefa_id'] = null;
        $data['slug'] = Str::slug($request->name);
        unset($data['price_per_hour'], $data['price_per_day'], $data['capacity'], $data['unit']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $galleryImages = collect($request->file('gallery_images'))
                ->filter()
                ->map(fn($file) => $file->store('services/gallery', 'public'))
                ->values()
                ->all();

            $data['gallery_images'] = $galleryImages;
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
        $this->authorizeSuperAdmin();

        $service = Service::findOrFail($id);

        return view('admin.services.show', compact('service'));
    }

    public function edit($id)
    {
        $this->authorizeSuperAdmin();
        $service = Service::findOrFail($id);

        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeSuperAdmin();
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'price_per_hour' => 'nullable|numeric|min:0',
            'price_per_day' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'unit' => 'nullable|string|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'panorama_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'icon' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
        ]);

        $data = $request->all();
        $data['tefa_id'] = null;
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('services', 'public');
        } else {
            unset($data['image']);
        }

        if ($request->boolean('remove_main_image')) {
            if ($service->image && Storage::disk('public')->exists($service->image)) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = null;
        }

        $existingGalleryImages = collect($service->gallery_images ?? [])
            ->filter(fn($path) => is_string($path) && trim($path) !== '')
            ->values();

        $galleryImagesToRemove = collect($request->input('remove_gallery_images', []))
            ->filter(fn($path) => is_string($path) && trim($path) !== '')
            ->values();

        $galleryChanged = false;

        if ($galleryImagesToRemove->isNotEmpty()) {
            $validImagesToRemove = $galleryImagesToRemove->intersect($existingGalleryImages)->values();

            foreach ($validImagesToRemove as $removeImagePath) {
                if (Storage::disk('public')->exists($removeImagePath)) {
                    Storage::disk('public')->delete($removeImagePath);
                }
            }

            $existingGalleryImages = $existingGalleryImages
                ->reject(fn($path) => $validImagesToRemove->contains($path))
                ->values();

            $galleryChanged = true;
        }

        if ($request->hasFile('gallery_images')) {
            $newGalleryImages = collect($request->file('gallery_images'))
                ->filter()
                ->map(fn($file) => $file->store('services/gallery', 'public'))
                ->values();

            if ($newGalleryImages->isNotEmpty()) {
                $existingGalleryImages = $existingGalleryImages
                    ->concat($newGalleryImages)
                    ->values();

                $galleryChanged = true;
            }
        }

        if ($galleryChanged) {
            $data['gallery_images'] = $existingGalleryImages->all();
        } else {
            unset($data['gallery_images']);
        }

        if (array_key_exists('image', $data) && is_null($data['image']) && $existingGalleryImages->isNotEmpty()) {
            $data['image'] = $existingGalleryImages->first();
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
        $this->authorizeSuperAdmin();

        $service = Service::findOrFail($id);

        if ($service->panorama_image && Storage::disk('public')->exists($service->panorama_image)) {
            Storage::disk('public')->delete($service->panorama_image);
        }

        foreach (collect($service->gallery_images ?? [])->filter() as $galleryImage) {
            if (Storage::disk('public')->exists($galleryImage)) {
                Storage::disk('public')->delete($galleryImage);
            }
        }

        if ($service->image && Storage::disk('public')->exists($service->image)) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route($this->getRoutePrefix() . '.services.index')
            ->with('success', 'Layanan berhasil dihapus');
    }

    private function authorizeSuperAdmin(): void
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::guard('admin')->user();

        if (!$admin || !$admin->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengelola layanan sewa.');
        }
    }
}
