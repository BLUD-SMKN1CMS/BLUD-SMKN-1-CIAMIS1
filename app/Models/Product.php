<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'tefa_id',
        'name',
        'slug',
        'description',
        'price',
        'category',
        'image',
        'stock',
        'status',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'order' => 'integer',
    ];

    // TAMBAHKAN INI - agar otomatis include accessor
    protected $appends = ['image_url', 'formatted_price'];

    // Relasi ke Tefa
    public function tefa()
    {
        return $this->belongsTo(Tefa::class);
    }

    // Scope untuk produk aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk produk featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('order');
    }

    // Boot method untuk generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $baseSlug = Str::slug($product->name);
            $slug = $baseSlug;
            $counter = 1;
            
            while (Product::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $product->slug = $slug;
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $counter = 1;
                
                while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $product->slug = $slug;
            }
        });
    }

    // ========== PERBAIKAN ACCESSOR ==========
    
    /**
     * Accessor untuk image_url - SESUAIKAN DENGAN CONTROLLER
     * Controller menyimpan: 'uploads/products/filename.jpg'
     */
    public function getImageUrlAttribute()
    {
        // Jika tidak ada gambar
        if (empty($this->image)) {
            return $this->generatePlaceholder();
        }

        // Jika sudah URL lengkap
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Controller menyimpan: 'uploads/products/filename.jpg'
        // Cek file dengan berbagai kemungkinan path
        
        // 1. Path asli dari database
        $originalPath = $this->image;
        $publicPath = public_path($originalPath);
        
        if (file_exists($publicPath)) {
            return asset($originalPath);
        }

        // 2. Jika tanpa 'uploads/' prefix, tambahkan
        if (!str_starts_with($originalPath, 'uploads/') && !str_starts_with($originalPath, '/uploads/')) {
            $withUploads = 'uploads/' . ltrim($originalPath, '/');
            if (file_exists(public_path($withUploads))) {
                return asset($withUploads);
            }
        }

        // 3. Cek dengan 'public/' prefix
        $withPublic = 'public/' . ltrim($originalPath, '/');
        if (file_exists(public_path($withPublic))) {
            return asset($withPublic);
        }

        // 4. Coba ambil hanya filename
        $filename = basename($originalPath);
        $filenamePath = 'uploads/products/' . $filename;
        if (file_exists(public_path($filenamePath))) {
            return asset($filenamePath);
        }

        // 5. Jika semua gagal, placeholder
        return $this->generatePlaceholder();
    }

    /**
     * Helper untuk generate placeholder
     */
    private function generatePlaceholder()
    {
        $productName = substr($this->name, 0, 30);
        $encodedName = urlencode($productName);
        $color = substr(md5($this->name), 0, 6);
        
        return "https://via.placeholder.com/400x300/{$color}/FFFFFF?text=" . $encodedName;
    }

    /**
     * Accessor untuk format harga
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}