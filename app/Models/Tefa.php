<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tefa extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'slug',
        'description',
        'logo',
        'banner',
        'contact_person',
        'contact_number',
        'contact_email',
        'whatsapp_url',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Relasi ke Products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope untuk TEFA aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Boot method untuk generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tefa) {
            $tefa->slug = Str::slug($tefa->name);
        });

        static::updating(function ($tefa) {
            $tefa->slug = Str::slug($tefa->name);
        });
    }

    // Accessor untuk logo URL
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('assets/iconsmea.png');
    }

    // Accessor untuk banner URL
    public function getBannerUrlAttribute()
    {
        return $this->banner ? asset('storage/' . $this->banner) : asset('assets/teachingfactorysmea.png');
    }
}