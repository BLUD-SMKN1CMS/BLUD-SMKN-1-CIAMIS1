<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'label', 'value', 'icon', 'suffix',
        'is_auto', 'auto_source', 'order', 'is_active'
    ];

    /**
     * Get active statistics ordered
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function($stat) {
                // Jika auto, hitung dari database
                if ($stat->is_auto && $stat->auto_source) {
                    switch($stat->auto_source) {
                        case 'tefas':
                            $stat->value = Tefa::where('is_active', true)->count();
                            break;
                        case 'products':
                            $stat->value = Product::where('status', 'active')->count();
                            break;
                        case 'services':
                            $stat->value = Service::where('status', 'available')->count();
                            break;
                    }
                }
                return $stat;
            });
    }

    /**
     * Get statistic value by name
     */
    public static function getValue($name, $default = 0)
    {
        $stat = self::where('name', $name)->first();
        if ($stat && $stat->is_auto && $stat->auto_source) {
            return self::calculateAutoValue($stat->auto_source);
        }
        return $stat ? $stat->value : $default;
    }

    private static function calculateAutoValue($source)
    {
        switch($source) {
            case 'tefas':
                return Tefa::where('is_active', true)->count();
            case 'products':
                return Product::where('status', 'active')->count();
            case 'services':
                return Service::where('status', 'available')->count();
            default:
                return 0;
        }
    }
}