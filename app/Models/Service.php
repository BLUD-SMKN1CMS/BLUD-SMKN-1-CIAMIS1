<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'facilities',
        'terms_conditions',
        'price_per_hour',
        'price_per_day',
        'capacity',
        'unit',
        'image',
        'panorama_image',
        'icon',
        'status',
        'tefa_id',
    ];

    // Boot method untuk generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            $service->slug = Str::slug($service->name);
        });

        static::updating(function ($service) {
            $service->slug = Str::slug($service->name);
        });
    }

    /**
     * Relasi ke TEFA
     */
    public function tefa()
    {
        return $this->belongsTo(Tefa::class);
    }

    // Scope untuk layanan tersedia
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-service.jpg');
    }

    public function getPanoramaImageUrlAttribute()
    {
        return $this->panorama_image ? asset('storage/' . $this->panorama_image) : null;
    }
}
