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
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, hanya tampilkan TEFA miliknya
        $query = Tefa::orderBy('order');

        if ($admin->isAdminTefa()) {
            $query->where('id', $admin->tefa_id);
        }

        $tefas = $query->paginate(10);
        return view('admin.tefas.index', compact('tefas'));
    }

    public function create()
    {
        /** @var \App\Models\Admin $admin */
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
        /** @var \App\Models\Admin $admin */
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
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'video_url' => 'nullable|string',
            'logo' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string',
            'job_prospects_json' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $filename = 'tefa_logo_' . time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            // Ensure directory exists
            $uploadPath = public_path('uploads/tefas');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $logo->move($uploadPath, $filename);
            $data['logo'] = 'uploads/tefas/' . $filename;
        }

        // Handle banner upload (foto slider TEFA)
        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $bannerFilename = 'tefa_banner_' . time() . '_' . uniqid() . '.' . $banner->getClientOriginalExtension();

            $uploadPath = public_path('uploads/tefas');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $banner->move($uploadPath, $bannerFilename);
            $data['banner'] = 'uploads/tefas/' . $bannerFilename;
        }

        // Decode JSON strings to arrays
        if ($request->has('services_json')) {
            $data['services'] = json_decode($request->services_json, true) ?? [];
            unset($data['services_json']);
        }

        if ($request->has('job_prospects_json')) {
            $data['job_prospects'] = json_decode($request->job_prospects_json, true) ?? [];
            unset($data['job_prospects_json']);
        }

        Tefa::create($data);

        return redirect()->route('superadmin.tefas.index')
            ->with('success', 'TEFA berhasil ditambahkan');
    }

    public function show($id)
    {
        /** @var \App\Models\Admin $admin */
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
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa hanya bisa edit TEFA miliknya
        if ($admin->isAdminTefa() && $tefa->id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke TEFA ini');
        }

        if ($admin->isAdminTefa()) {
            return view('admin.tefas.content-edit', compact('tefa'));
        }

        return view('admin.tefas.edit', compact('tefa'));
    }

    public function update(Request $request, $id)
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();
        $tefa = Tefa::findOrFail($id);

        // Admin-tefa hanya bisa edit TEFA miliknya
        if ($admin->isAdminTefa() && $tefa->id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke TEFA ini');
        }

        $isContentModeRequest = !$request->hasAny(['name', 'code']);

        if ($admin->isAdminTefa() && $isContentModeRequest) {
            $request->validate([
                'description' => 'nullable|string',
                'about' => 'nullable|string',
                'vision' => 'nullable|string',
                'mission' => 'nullable|string',
                'video_url' => 'nullable|string',
                'job_prospects_json' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
                'slider_images' => 'nullable|array',
                'slider_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
                'remove_slider_images' => 'nullable|array',
                'remove_slider_images.*' => 'nullable|string',
            ]);

            $data = [];

            if ($request->has('description')) {
                $data['description'] = $request->description;
            }

            if ($request->has('about')) {
                $data['about'] = $request->about;
            }

            if ($request->has('vision')) {
                $data['vision'] = $request->vision;
            }

            if ($request->has('mission')) {
                $data['mission'] = $request->mission;
            }

            if ($request->has('video_url')) {
                $data['video_url'] = $request->video_url;
            }

            if ($request->has('job_prospects_json')) {
                $data['job_prospects'] = json_decode($request->job_prospects_json, true) ?? [];
            }

            if ($request->hasFile('logo')) {
                if ($tefa->logo && file_exists(public_path($tefa->logo))) {
                    unlink(public_path($tefa->logo));
                }

                $logo = $request->file('logo');
                $logoFilename = 'tefa_logo_' . time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

                $uploadPath = public_path('uploads/tefas');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $logo->move($uploadPath, $logoFilename);
                $data['logo'] = 'uploads/tefas/' . $logoFilename;
            }

            $existingSliderImages = collect($tefa->slider_images ?? [])
                ->filter(fn($path) => is_string($path) && trim($path) !== '')
                ->values();

            $sliderImagesToRemove = collect($request->input('remove_slider_images', []))
                ->filter(fn($path) => is_string($path) && trim($path) !== '')
                ->values();

            $sliderChanged = false;

            if ($sliderImagesToRemove->isNotEmpty()) {
                $validRemoveImages = $sliderImagesToRemove->intersect($existingSliderImages)->values();

                foreach ($validRemoveImages as $removePath) {
                    if (file_exists(public_path($removePath))) {
                        unlink(public_path($removePath));
                    }
                }

                $existingSliderImages = $existingSliderImages
                    ->reject(fn($path) => $validRemoveImages->contains($path))
                    ->values();

                $sliderChanged = true;
            }

            if ($request->hasFile('slider_images')) {
                $uploadPath = public_path('uploads/tefas/sliders');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                $newSliderImages = collect($request->file('slider_images'))
                    ->filter()
                    ->map(function ($image) use ($uploadPath) {
                        $filename = 'tefa_slider_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                        $image->move($uploadPath, $filename);
                        return 'uploads/tefas/sliders/' . $filename;
                    })
                    ->values();

                if ($newSliderImages->isNotEmpty()) {
                    $existingSliderImages = $existingSliderImages
                        ->concat($newSliderImages)
                        ->values();

                    $sliderChanged = true;
                }
            }

            if ($sliderChanged) {
                $data['slider_images'] = $existingSliderImages->all();

                if ($existingSliderImages->isNotEmpty()) {
                    $data['banner'] = $existingSliderImages->first();
                }
            }

            $tefa->update($data);

            return redirect()->route('admin.dashboard')
                ->with('success', 'Konten ' . $tefa->name . ' berhasil diperbarui');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:tefas,code,' . $id,
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'video_url' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string',
            'job_prospects_json' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($tefa->logo && file_exists(public_path($tefa->logo))) {
                unlink(public_path($tefa->logo));
            }

            $logo = $request->file('logo');
            $filename = 'tefa_logo_' . time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            // Ensure directory exists
            $uploadPath = public_path('uploads/tefas');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $logo->move($uploadPath, $filename);
            $data['logo'] = 'uploads/tefas/' . $filename;
        }

        // Handle banner upload (foto slider TEFA)
        if ($request->hasFile('banner')) {
            if ($tefa->banner && file_exists(public_path($tefa->banner))) {
                unlink(public_path($tefa->banner));
            }

            $banner = $request->file('banner');
            $bannerFilename = 'tefa_banner_' . time() . '_' . uniqid() . '.' . $banner->getClientOriginalExtension();

            $uploadPath = public_path('uploads/tefas');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $banner->move($uploadPath, $bannerFilename);
            $data['banner'] = 'uploads/tefas/' . $bannerFilename;
        }

        // Decode JSON strings to arrays
        if ($request->has('services_json')) {
            $data['services'] = json_decode($request->services_json, true) ?? [];
            unset($data['services_json']);
        }

        if ($request->has('job_prospects_json')) {
            $data['job_prospects'] = json_decode($request->job_prospects_json, true) ?? [];
            unset($data['job_prospects_json']);
        }

        $tefa->update($data);

        // Redirect based on user role
        if ($admin->isSuperAdmin()) {
            return redirect()->route('superadmin.tefas.index')
                ->with('success', 'TEFA berhasil diperbarui');
        } else {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Program Keahlian berhasil diperbarui');
        }
    }

    public function destroy($id)
    {
        /** @var \App\Models\Admin $admin */
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

    // TEFA Content Management Methods (untuk Super Admin edit konten detail TEFA)

    /**
     * Tampilkan daftar TEFA untuk edit konten
     */
    public function contentIndex()
    {
        $tefas = Tefa::orderBy('order')->get();
        return view('admin.tefas.content-index', compact('tefas'));
    }

    /**
     * Form edit konten TEFA (about, vision, mission, video, job_prospects)
     */
    public function contentEdit($id)
    {
        $tefa = Tefa::findOrFail($id);
        return view('admin.tefas.content-edit', compact('tefa'));
    }

    /**
     * Update konten TEFA
     */
    public function contentUpdate(Request $request, $id)
    {
        $tefa = Tefa::findOrFail($id);

        $request->validate([
            'description' => 'nullable|string',
            'about' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'video_url' => 'nullable|string',
            'job_prospects_json' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'slider_images' => 'nullable|array',
            'slider_images.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'remove_slider_images' => 'nullable|array',
            'remove_slider_images.*' => 'nullable|string',
        ]);

        $data = [];

        // Update only content fields
        if ($request->has('description')) {
            $data['description'] = $request->description;
        }

        if ($request->has('about')) {
            $data['about'] = $request->about;
        }

        if ($request->has('vision')) {
            $data['vision'] = $request->vision;
        }

        if ($request->has('mission')) {
            $data['mission'] = $request->mission;
        }

        if ($request->has('video_url')) {
            $data['video_url'] = $request->video_url;
        }

        // Decode JSON strings to arrays
        if ($request->has('job_prospects_json')) {
            $data['job_prospects'] = json_decode($request->job_prospects_json, true) ?? [];
        }

        if ($request->hasFile('logo')) {
            if ($tefa->logo && file_exists(public_path($tefa->logo))) {
                unlink(public_path($tefa->logo));
            }

            $logo = $request->file('logo');
            $logoFilename = 'tefa_logo_' . time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();

            $uploadPath = public_path('uploads/tefas');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $logo->move($uploadPath, $logoFilename);
            $data['logo'] = 'uploads/tefas/' . $logoFilename;
        }

        $existingSliderImages = collect($tefa->slider_images ?? [])
            ->filter(fn($path) => is_string($path) && trim($path) !== '')
            ->values();

        $sliderImagesToRemove = collect($request->input('remove_slider_images', []))
            ->filter(fn($path) => is_string($path) && trim($path) !== '')
            ->values();

        $sliderChanged = false;

        if ($sliderImagesToRemove->isNotEmpty()) {
            $validRemoveImages = $sliderImagesToRemove->intersect($existingSliderImages)->values();

            foreach ($validRemoveImages as $removePath) {
                if (file_exists(public_path($removePath))) {
                    unlink(public_path($removePath));
                }
            }

            $existingSliderImages = $existingSliderImages
                ->reject(fn($path) => $validRemoveImages->contains($path))
                ->values();

            $sliderChanged = true;
        }

        if ($request->hasFile('slider_images')) {
            $uploadPath = public_path('uploads/tefas/sliders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $newSliderImages = collect($request->file('slider_images'))
                ->filter()
                ->map(function ($image) use ($uploadPath) {
                    $filename = 'tefa_slider_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);
                    return 'uploads/tefas/sliders/' . $filename;
                })
                ->values();

            if ($newSliderImages->isNotEmpty()) {
                $existingSliderImages = $existingSliderImages
                    ->concat($newSliderImages)
                    ->values();

                $sliderChanged = true;
            }
        }

        if ($sliderChanged) {
            $data['slider_images'] = $existingSliderImages->all();

            if ($existingSliderImages->isNotEmpty()) {
                $data['banner'] = $existingSliderImages->first();
            }
        }

        $tefa->update($data);

        return redirect()->route('superadmin.tefas.content.index')
            ->with('success', 'Konten ' . $tefa->name . ' berhasil diperbarui');
    }
}
