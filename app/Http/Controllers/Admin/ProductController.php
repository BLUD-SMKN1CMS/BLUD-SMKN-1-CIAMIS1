<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $query = Product::with('tefa')->orderBy('created_at', 'desc');

        // Jika admin-tefa, filter hanya product untuk TEFA miliknya
        if ($admin->isAdminTefa()) {
            $query->where('tefa_id', $admin->tefa_id);
        } elseif ($request->has('tefa_id') && $request->tefa_id != '') {
            // Superadmin bisa filter by TEFA jika disediakan
            $query->where('tefa_id', $request->tefa_id);
        }

        $products = $query->get();

        // Untuk dropdown filter: superadmin lihat semua TEFA, admin-tefa hanya miliknya
        $tefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->where('is_active', true)->orderBy('name', 'asc')->get()
            : Tefa::where('is_active', true)->orderBy('name', 'asc')->get();

        return view('admin.products.index', compact('products', 'tefas'));
    }

    public function create()
    {
        $admin = Auth::guard('admin')->user();

        // Untuk dropdown: superadmin lihat semua TEFA, admin-tefa hanya miliknya
        $tefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->get()
            : Tefa::where('is_active', true)->get();

        return view('admin.products.create', compact('tefas'));
    }

    public function store(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, pastikan hanya bisa create product untuk TEFA miliknya
        if ($admin->isAdminTefa()) {
            $request->merge(['tefa_id' => $admin->tefa_id]);
        }

        // VALIDASI YANG LEBIH DETAIL
        $validator = Validator::make($request->all(), [
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max, tambah webp
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50', // Add unit validation
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max, tambah webp
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk sudah ada',
            'price.min' => 'Harga tidak boleh minus',
            'stock.min' => 'Stok tidak boleh minus',
            'unit.required' => 'Satuan wajib diisi', // Add unit message
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'image_2.image' => 'File gambar 2 harus berupa gambar',
            'image_3.image' => 'File gambar 3 harus berupa gambar',
            'image_4.image' => 'File gambar 4 harus berupa gambar',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token']);
        // Fix: Description cannot be null in DB
        if (empty($data['description'])) {
            $data['description'] = '-';
        }
        $data['slug'] = Str::slug($request->name);

        // Handle image uploads
        $imageFields = ['image', 'image_2', 'image_3', 'image_4'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $image = $request->file($field);

                // Validasi ekstensi manual
                $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                $extension = strtolower($image->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$field => 'Format file tidak didukung. Gunakan: jpeg, png, jpg, gif, atau webp']);
                }

                // Validasi ukuran (dalam bytes)
                $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
                if ($image->getSize() > $maxSize) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$field => 'Ukuran gambar terlalu besar. Maksimal 2MB']);
                }

                // Pastikan folder uploads/products ada
                $uploadPath = public_path('uploads/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Generate nama file unik
                $filename = 'product_' . $field . '_' . time() . '_' . uniqid() . '.' . $extension;

                // Simpan gambar dengan kualitas optimal
                try {
                    $image->move($uploadPath, $filename);
                    $data[$field] = 'uploads/products/' . $filename;
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$field => 'Gagal mengupload gambar: ' . $e->getMessage()]);
                }
            } else {
                // Jika tidak upload gambar, set null
                $data[$field] = null;
            }
        }

        // Set default values jika kosong
        if (empty($data['order'])) {
            $data['order'] = 0;
        }

        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        try {
            Product::create($data);

            return redirect()->route($this->getRoutePrefix() . '.products.index')
                ->with('success', '✅ Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            \Log::error('Error creating product: ' . $e->getMessage());

            // Hapus gambar jika upload gagal
            if (isset($data['image']) && file_exists(public_path($data['image']))) {
                @unlink(public_path($data['image']));
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal menyimpan produk. Error: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $admin = Auth::guard('admin')->user();
        $product = Product::with('tefa')->findOrFail($id);

        // Admin-tefa hanya bisa lihat product untuk TEFA miliknya
        if ($admin->isAdminTefa() && $product->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini');
        }

        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $admin = Auth::guard('admin')->user();
        $product = Product::findOrFail($id);

        // Admin-tefa hanya bisa edit product untuk TEFA miliknya
        if ($admin->isAdminTefa() && $product->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini');
        }

        // Dropdown TEFA: superadmin lihat semua, admin-tefa hanya miliknya
        $tefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->get()
            : Tefa::where('is_active', true)->get();

        return view('admin.products.edit', compact('product', 'tefas'));
    }

    public function update(Request $request, $id)
    {
        $admin = Auth::guard('admin')->user();
        $product = Product::findOrFail($id);

        // Admin-tefa hanya bisa update product untuk TEFA miliknya
        if ($admin->isAdminTefa() && $product->tefa_id !== $admin->tefa_id) {
            abort(403, 'Anda tidak memiliki akses ke produk ini');
        }

        // Jika admin-tefa, force tefa_id sesuai miliknya
        if ($admin->isAdminTefa()) {
            $request->merge(['tefa_id' => $admin->tefa_id]);
        }

        // VALIDASI UPDATE (perlu validasi unique dengan pengecualian)
        $validator = Validator::make($request->all(), [
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'unit' => 'required|string|max:50', // Add unit validation
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.unique' => 'Nama produk sudah ada',
            'price.min' => 'Harga tidak boleh minus',
            'stock.min' => 'Stok tidak boleh minus',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token', '_method', 'image', 'image_2', 'image_3', 'image_4']);

        // Fix: Description cannot be null in DB
        if (empty($data['description'])) {
            $data['description'] = '-';
        }
        $data['slug'] = Str::slug($request->name);

        // Handle image upload jika ada file baru (LOOPING)
        $imageFields = ['image', 'image_2', 'image_3', 'image_4'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // ... same logic ...
                // Validasi ekstensi
                $image = $request->file($field);
                $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
                $extension = strtolower($image->getClientOriginalExtension());

                if (!in_array($extension, $allowedExtensions)) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$field => 'Format file tidak didukung. Gunakan: jpeg, png, jpg, gif, atau webp']);
                }

                // Hapus gambar lama jika ada
                $oldImage = $product->$field;

                // Pastikan folder uploads/products ada
                $uploadPath = public_path('uploads/products');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Generate nama file unik
                $filename = 'product_' . $field . '_' . time() . '_' . uniqid() . '.' . $extension;

                try {
                    // Simpan gambar baru
                    $image->move($uploadPath, $filename);
                    $data[$field] = 'uploads/products/' . $filename;

                    // Hapus gambar lama setelah sukses upload baru
                    if ($oldImage && file_exists(public_path($oldImage))) {
                        @unlink(public_path($oldImage));
                    }
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->withErrors([$field => 'Gagal mengupload gambar: ' . $e->getMessage()]);
                }
            }
        }

        // Set default values jika kosong
        if (empty($data['order'])) {
            $data['order'] = 0;
        }

        if (!isset($data['is_featured'])) {
            $data['is_featured'] = false;
        }

        try {
            $product->update($data);

            return redirect()->route($this->getRoutePrefix() . '.products.index')
                ->with('success', '✅ Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updating product: ' . $e->getMessage());

            // Jika gagal update, hapus gambar baru (jika ada)
            if (isset($data['image']) && $data['image'] !== $product->image) {
                if (file_exists(public_path($data['image']))) {
                    @unlink(public_path($data['image']));
                }
            }

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Gagal memperbarui produk. Error: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $admin = Auth::guard('admin')->user();
            $product = Product::findOrFail($id);

            // Admin-tefa hanya bisa delete product untuk TEFA miliknya
            if ($admin->isAdminTefa() && $product->tefa_id !== $admin->tefa_id) {
                abort(403, 'Anda tidak memiliki akses ke produk ini');
            }

            // Simpan path gambar untuk dihapus
            $imageFields = ['image', 'image_2', 'image_3', 'image_4'];
            $imagesToDelete = [];
            foreach ($imageFields as $field) {
                if ($product->$field) {
                    $imagesToDelete[] = $product->$field;
                }
            }

            // Hapus dari database
            $product->delete();

            // Hapus gambar dari storage
            foreach ($imagesToDelete as $path) {
                if ($path && file_exists(public_path($path))) {
                    @unlink(public_path($path));
                }
            }

            return redirect()->route($this->getRoutePrefix() . '.products.index')
                ->with('success', '✅ Produk berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());

            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus produk. Error: ' . $e->getMessage()]);
        }
    }
}
