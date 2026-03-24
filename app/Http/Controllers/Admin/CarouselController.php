<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarouselController extends Controller
{
    /**
     * Process uploaded carousel image to fixed 16:9 ratio (1920x1080).
     */
    private function processCarouselImage($image): string
    {
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

        $source = imagecreatefromstring(file_get_contents($image->getRealPath()));
        if (!$source) {
            throw new \RuntimeException('Gagal membaca file gambar.');
        }

        // Hitung area crop tengah agar rasio source menjadi 16:9.
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

        imagedestroy($source);
        imagedestroy($canvas);

        Storage::disk('public')->put($path, $binary);

        return $path;
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
        ]);

        // Handle image upload with 16:9 validation
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Auto crop image to 16:9 (1920x1080) for consistent carousel display.
            $validated['image'] = $this->processCarouselImage($image);
        }

        // Set default order if not provided
        if (empty($validated['order'])) {
            $maxOrder = Carousel::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

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
        $carousel = Carousel::findOrFail($id);
        return view('admin.carousels.show', compact('carousel'));
    }

    /**
     * Show the form for editing the specified carousel.
     */
    public function edit(string $id)
    {
        $carousel = Carousel::findOrFail($id);
        return view('admin.carousels.edit', compact('carousel'));
    }

    /**
     * Update the specified carousel in storage.
     */
    public function update(Request $request, string $id)
    {
        $carousel = Carousel::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
        ]);

        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Delete old image if exists
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            // Auto crop image to 16:9 (1920x1080) for consistent carousel display.
            $validated['image'] = $this->processCarouselImage($image);
        } else {
            // Keep existing image
            unset($validated['image']);
        }

        $carousel->update($validated);

        return redirect()->route('superadmin.carousels.index')
            ->with('success', 'Carousel berhasil diperbarui!');
    }

    /**
     * Remove the specified carousel from storage.
     */
    public function destroy(string $id)
    {
        $carousel = Carousel::findOrFail($id);

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