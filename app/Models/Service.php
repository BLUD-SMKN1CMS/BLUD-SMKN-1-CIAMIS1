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
        'price_per_hour',
        'price_per_day',
        'capacity',
        'unit',
        'image',
        'status',
    ];

    protected $casts = [
        'price_per_hour' => 'decimal:2',
        'price_per_day' => 'decimal:2',
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

    // Scope untuk layanan tersedia
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Accessor untuk harga format
    public function getFormattedPricePerHourAttribute()
    {
        return $this->price_per_hour ? 'Rp ' . number_format($this->price_per_hour, 0, ',', '.') : null;
    }

    public function getFormattedPricePerDayAttribute()
    {
        return $this->price_per_day ? 'Rp ' . number_format($this->price_per_day, 0, ',', '.') : null;
    }

    // Accessor untuk image URL
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/default-service.jpg');
    }
}