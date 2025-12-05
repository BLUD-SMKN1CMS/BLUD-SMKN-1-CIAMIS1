<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('tefa')->orderBy('created_at', 'desc')->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $tefas = Tefa::where('is_active', true)->get();
        return view('admin.products.create', compact('tefas'));
    }

    public function store(Request $request)
    {
        // VALIDASI YANG LEBIH DETAIL
        $validator = Validator::make($request->all(), [
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // 2MB max, tambah webp
        ], [
            'name.required' => 'Nama produk wajib diisi',
            'name.unique' => 'Nama produk sudah ada',
            'price.min' => 'Harga tidak boleh minus',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token']);
        $data['slug'] = Str::slug($request->name);
        
        // Handle image upload dengan validasi lebih ketat
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            // Validasi ekstensi manual
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Format file tidak didukung. Gunakan: jpeg, png, jpg, gif, atau webp']);
            }
            
            // Validasi ukuran (dalam bytes)
            $maxSize = 2 * 1024 * 1024; // 2MB dalam bytes
            if ($image->getSize() > $maxSize) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Ukuran gambar terlalu besar. Maksimal 2MB']);
            }
            
            // Pastikan folder uploads/products ada
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Generate nama file unik
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
            
            // Simpan gambar dengan kualitas optimal
            try {
                $image->move($uploadPath, $filename);
                $data['image'] = 'uploads/products/' . $filename;
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        } else {
            // Jika tidak upload gambar, set null
            $data['image'] = null;
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
            
            return redirect()->route('admin.products.index')
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
        $product = Product::with('tefa')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $tefas = Tefa::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'tefas'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // VALIDASI UPDATE (perlu validasi unique dengan pengecualian)
        $validator = Validator::make($request->all(), [
            'tefa_id' => 'required|exists:tefas,id',
            'name' => 'required|string|max:255|unique:products,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'status' => 'required|in:draft,active,inactive',
            'is_featured' => 'boolean',
            'order' => 'integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.unique' => 'Nama produk sudah ada',
            'price.min' => 'Harga tidak boleh minus',
            'image.mimes' => 'Format gambar harus: jpeg, png, jpg, gif, atau webp',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->except(['_token', '_method']);
        $data['slug'] = Str::slug($request->name);
        
        // Handle image upload jika ada file baru
        if ($request->hasFile('image')) {
            // Validasi ekstensi
            $image = $request->file('image');
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'webp'];
            $extension = strtolower($image->getClientOriginalExtension());
            
            if (!in_array($extension, $allowedExtensions)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Format file tidak didukung. Gunakan: jpeg, png, jpg, gif, atau webp']);
            }
            
            // Hapus gambar lama jika ada
            $oldImage = $product->image;
            
            // Pastikan folder uploads/products ada
            $uploadPath = public_path('uploads/products');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            // Generate nama file unik
            $filename = 'product_' . time() . '_' . uniqid() . '.' . $extension;
            
            try {
                // Simpan gambar baru
                $image->move($uploadPath, $filename);
                $data['image'] = 'uploads/products/' . $filename;
                
                // Hapus gambar lama setelah sukses upload baru
                if ($oldImage && file_exists(public_path($oldImage))) {
                    @unlink(public_path($oldImage));
                }
                
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['image' => 'Gagal mengupload gambar: ' . $e->getMessage()]);
            }
        } else {
            // Jika tidak upload gambar baru, pertahankan gambar lama
            $data['image'] = $product->image;
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
            
            return redirect()->route('admin.products.index')
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
            $product = Product::findOrFail($id);
            
            // Simpan path gambar untuk dihapus
            $imagePath = $product->image;
            
            // Hapus dari database
            $product->delete();
            
            // Hapus gambar dari storage
            if ($imagePath && file_exists(public_path($imagePath))) {
                @unlink(public_path($imagePath));
            }
            
            return redirect()->route('admin.products.index')
                ->with('success', '✅ Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            \Log::error('Error deleting product: ' . $e->getMessage());
            
            return redirect()->back()
                ->withErrors(['error' => 'Gagal menghapus produk. Error: ' . $e->getMessage()]);
        }
    }
}