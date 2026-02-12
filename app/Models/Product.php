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
        'name',
        'slug',
        'description',
        'price',
        'category',
        'unit', // Add unit
        'image',
        'image_2',
        'image_3',
        'image_4',
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
    protected $appends = ['image_url', 'image_2_url', 'image_3_url', 'image_4_url', 'formatted_price'];

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

        // Jika sudah URL lengkap (http/https)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }

        // Langsung return asset URL
        // Controller menyimpan path sebagai: 'uploads/products/filename.jpg'
        // Jadi kita langsung gunakan asset() helper
        return asset($this->image);
    }

    public function getImage2UrlAttribute()
    {
        if (empty($this->image_2)) return null;
        if (filter_var($this->image_2, FILTER_VALIDATE_URL)) return $this->image_2;
        return asset($this->image_2);
    }

    public function getImage3UrlAttribute()
    {
        if (empty($this->image_3)) return null;
        if (filter_var($this->image_3, FILTER_VALIDATE_URL)) return $this->image_3;
        return asset($this->image_3);
    }

    public function getImage4UrlAttribute()
    {
        if (empty($this->image_4)) return null;
        if (filter_var($this->image_4, FILTER_VALIDATE_URL)) return $this->image_4;
        return asset($this->image_4);
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