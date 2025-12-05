<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'order',
        'button_text',
        'button_url',
    ];

    // Scope untuk carousel aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->orderBy('order');
    }
}