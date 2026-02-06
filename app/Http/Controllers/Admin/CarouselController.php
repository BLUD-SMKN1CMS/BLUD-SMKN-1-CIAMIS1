<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CarouselController extends Controller
{
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
        ]);

        // Handle image upload with 16:9 validation
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Check image dimensions (should be 16:9 ratio)
            list($width, $height) = getimagesize($image->getPathname());
            $ratio = $width / $height;
            
            // Allow small tolerance for 16:9 ratio (1.777)
            if (abs($ratio - 16/9) > 0.1) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'image' => 'Rasio gambar harus 16:9. Ukuran yang disarankan: 1920x1080px'
                    ]);
            }

            // Generate unique filename
            $filename = 'carousel_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store in carousels directory
            $path = $image->storeAs('carousels', $filename, 'public');
            
            // Create thumbnail (optional)
            // $thumbnail = Image::make($image->getRealPath())->resize(300, 169);
            // Storage::disk('public')->put('carousels/thumbs/' . $filename, $thumbnail->stream());
            
            $validated['image'] = $path;
        }

        // Set default order if not provided
        if (empty($validated['order'])) {
            $maxOrder = Carousel::max('order') ?? 0;
            $validated['order'] = $maxOrder + 1;
        }

        Carousel::create($validated);

        return redirect()->route('admin.carousels.index')
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'required|in:active,inactive',
            'order' => 'nullable|integer',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
        ]);

        // Handle image upload if new image provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Check image dimensions (should be 16:9 ratio)
            list($width, $height) = getimagesize($image->getPathname());
            $ratio = $width / $height;
            
            // Allow small tolerance for 16:9 ratio (1.777)
            if (abs($ratio - 16/9) > 0.1) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'image' => 'Rasio gambar harus 16:9. Ukuran yang disarankan: 1920x1080px'
                    ]);
            }

            // Delete old image if exists
            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            // Generate unique filename
            $filename = 'carousel_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store in carousels directory
            $path = $image->storeAs('carousels', $filename, 'public');
            
            $validated['image'] = $path;
        } else {
            // Keep existing image
            unset($validated['image']);
        }

        $carousel->update($validated);

        return redirect()->route('admin.carousels.index')
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

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Carousel berhasil dihapus!');
    }

    /**
     * Toggle carousel status (active/inactive) - PERBAIKI PARAMETER!
     */
    public function toggleStatus(Carousel $carousel)  // ← UBAH INI dari string $id ke Carousel $carousel
    {
        $carousel->status = $carousel->status === 'active' ? 'inactive' : 'active';
        $carousel->save();

        return redirect()->route('admin.carousels.index')
            ->with('success', 'Status carousel berhasil diubah!');
    }

    /**
     * Set carousel status (alternative method) - TAMBAHKAN INI JIKA DIPERLUKAN
     */
    public function setActive(Carousel $carousel)
    {
        $carousel->status = 'active';
        $carousel->save();

        return redirect()->route('admin.carousels.index')
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