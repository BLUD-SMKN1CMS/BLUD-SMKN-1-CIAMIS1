<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    /**
     * Process uploaded carousel image with optional manual crop.
     * If crop data is provided, use it; otherwise, auto-crop to 16:9.
     */
    private function processCarouselImage($image, $cropData = null): string
    {
        if (!function_exists('imagecreatefromstring') || !function_exists('imagecopyresampled')) {
            throw new \RuntimeException('Ekstensi GD tidak tersedia di server.');
        }

        $filename = 'carousel_' . time() . '_' . uniqid() . '.jpg';
        $path = 'carousels/' . $filename;
        $targetWidth = 1920;
        $targetHeight = 1080;

        $imageInfo = getimagesize($image->getRealPath());
        if (!$imageInfo) {
            throw new \RuntimeException('Gambar tidak valid.');
        }

        [$srcWidth, $srcHeight] = $imageInfo;
        $mime = $imageInfo['mime'] ?? 'image/jpeg';

        $rawContent = file_get_contents($image->getRealPath());
        if ($rawContent === false) {
            throw new \RuntimeException('Gagal membaca konten file gambar.');
        }

        $source = imagecreatefromstring($rawContent);
        if (!$source) {
            throw new \RuntimeException('Gagal membaca file gambar.');
        }

        // Determine crop area: manual or auto
        if ($cropData && $cropData['hasManualCrop']) {
            // Manual crop from user input
            $srcX = max(0, (int) $cropData['cropX']);
            $srcY = max(0, (int) $cropData['cropY']);
            $cropWidth = max(1, (int) $cropData['cropWidth']);
            $cropHeight = max(1, (int) $cropData['cropHeight']);

            // Clamp to image bounds
            $srcX = min($srcX, $srcWidth - 1);
            $srcY = min($srcY, $srcHeight - 1);
            $cropWidth = min($cropWidth, $srcWidth - $srcX);
            $cropHeight = min($cropHeight, $srcHeight - $srcY);
        } else {
            // Auto-crop: center crop to 16:9 ratio
            $targetRatio = $targetWidth / $targetHeight;
            $sourceRatio = $srcWidth / $srcHeight;

            if ($sourceRatio > $targetRatio) {
                $cropHeight = $srcHeight;
                $cropWidth = (int) round($srcHeight * $targetRatio);
                $srcX = (int) round(($srcWidth - $cropWidth) / 2);
                $srcY = 0;
            } else {
                $cropWidth = $srcWidth;
                $cropHeight = (int) round($srcWidth / $targetRatio);
                $srcX = 0;
                $srcY = (int) round(($srcHeight - $cropHeight) / 2);
            }
        }

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);
        if (in_array($mime, ['image/png', 'image/gif'], true)) {
            imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));
        }

        imagecopyresampled(
            $canvas,
            $source,
            0,
            0,
            $srcX,
            $srcY,
            $targetWidth,
            $targetHeight,
            $cropWidth,
            $cropHeight
        );

        ob_start();
        imagejpeg($canvas, null, 85);
        $binary = ob_get_clean();

        Storage::disk('public')->put($path, $binary);

        return $path;
    }

    /**
     * Simpan gambar carousel dengan optional manual crop data.
     * Fallback ke auto-crop jika proses gagal.
     */
    private function saveCarouselImage($image, $cropData = null): string
    {
        try {
            return $this->processCarouselImage($image, $cropData);
        } catch (\Throwable $e) {
            Log::warning('Carousel image processing failed, fallback to original upload.', [
                'message' => $e->getMessage(),
            ]);

            return $image->store('carousels', 'public');
        }
    }

    /**
     * Display a listing of carousels.
     */
    public function index()
    {
        $carousels = Carousel::orderBy('order')->paginate(10);
        
        return view('admin.carousels.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new carousel.
     */
    public function create()
    {
        return view('admin.carousels.create');
    }

    /**
     * Store a newly created carousel in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_width' => 'nullable|numeric',
            'crop_height' => 'nullable|numeric',
            'crop_scale_x' => 'nullable|numeric',
            'crop_scale_y' => 'nullable|numeric',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Prepare crop data if available
            $cropData = null;
            if ($request->filled('crop_x') || $request->filled('crop_y') || $request->filled('crop_width') || $request->filled('crop_height')) {
                $cropData = [
                    'hasManualCrop' => true,
                    'cropX' => $request->input('crop_x', 0),
                    'cropY' => $request->input('crop_y', 0),
                    'cropWidth' => $request->input('crop_width', 0),
                    'cropHeight' => $request->input('crop_height', 0),
                    'scaleX' => $request->input('crop_scale_x', 1),
                    'scaleY' => $request->input('crop_scale_y', 1),
                ];
            }

            // Process with manual crop or auto-crop
            $validated['image'] = $this->saveCarouselImage($image, $cropData);
        }

        // Set default order if not provided
        if (empty($validated['order'])) {
            $maxOrder = Carousel::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        // Remove crop data from validated array (not needed in DB)
        unset($validated['crop_x'], $validated['crop_y'], $validated['crop_width'], $validated['crop_height'], $validated['crop_scale_x'], $validated['crop_scale_y']);

        // Keep text fields internal because carousel is now image-focused in admin UI.
        $validated['title'] = 'Carousel Image ' . now()->format('YmdHis');
        $validated['description'] = null;
        $validated['button_text'] = null;
        $validated['button_url'] = null;

        Carousel::create($validated);

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Carousel berhasil ditambahkan!');
    }

    /**
     * Display the specified carousel.
     */
    public function show(string $id)
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return redirect()->route('superadmin.carousels.index')
                ->with('error', 'Carousel tidak ditemukan.');
        }

        return view('admin.carousels.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified carousel.
     */
    public function edit(string $id)
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return redirect()->route('superadmin.carousels.index')
                ->with('error', 'Carousel tidak ditemukan.');
        }

        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Update the specified carousel in storage.
     */
    public function update(Request $request, string $id)
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return redirect()->route('superadmin.carousels.index')
                ->with('error', 'Carousel tidak ditemukan.');
        }

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
            'crop_x' => 'nullable|numeric',
            'crop_y' => 'nullable|numeric',
            'crop_width' => 'nullable|numeric',
            'crop_height' => 'nullable|numeric',
            'crop_scale_x' => 'nullable|numeric',
            'crop_scale_y' => 'nullable|numeric',
        ]);

        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Prepare crop data if available
            $cropData = null;
            if ($request->filled('crop_x') || $request->filled('crop_y') || $request->filled('crop_width') || $request->filled('crop_height')) {
                $cropData = [
                    'hasManualCrop' => true,
                    'cropX' => $request->input('crop_x', 0),
                    'cropY' => $request->input('crop_y', 0),
                    'cropWidth' => $request->input('crop_width', 0),
                    'cropHeight' => $request->input('crop_height', 0),
                    'scaleX' => $request->input('crop_scale_x', 1),
                    'scaleY' => $request->input('crop_scale_y', 1),
                ];
            }

            // Simpan gambar baru dulu, baru hapus gambar lama jika sukses.
            $newImagePath = $this->saveCarouselImage($image, $cropData);

            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            $validated['image'] = $newImagePath;
        } else {
            // Keep existing image
            unset($validated['image']);
        }

        // Remove crop data from validated array (not needed in DB)
        unset($validated['crop_x'], $validated['crop_y'], $validated['crop_width'], $validated['crop_height'], $validated['crop_scale_x'], $validated['crop_scale_y']);

        $carousel->update($validated);

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Carousel berhasil diperbarui!');
    }

    /**
     * Remove the specified carousel from storage.
     */
    public function destroy(string $id)
    {
        $carousel = Carousel::find($id);
        if (!$carousel) {
            return redirect()->route('superadmin.carousels.index')
                ->with('error', 'Carousel tidak ditemukan.');
        }

        // Delete image file if exists
        if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->delete();

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Carousel berhasil dihapus!');
    }

    /**
     * Toggle carousel status (active/inactive) - PERBAIKI PARAMETER!
     */
    public function toggleStatus(Carousel $carousel)  // ← UBAH INI dari string $id ke Carousel $carousel
    {
        $carousel->status = $carousel->status === 'active' ? 'inactive' : 'active';
        $carousel->save();

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Status carousel berhasil diubah!');
    }

    /**
     * Set carousel status (alternative method) - TAMBAHKAN INI JIKA DIPERLUKAN
     */
    public function setActive(Carousel $carousel)
    {
        $carousel->status = 'active';
        $carousel->save();

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Carousel berhasil diaktifkan!');
    }

    /**
     * Update carousel order via drag & drop
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer',
        ]);

        foreach ($request->order as $index => $id) {
            Carousel::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}