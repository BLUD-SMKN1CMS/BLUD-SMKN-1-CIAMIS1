<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key', 'value', 'group', 'type', 'description', 'order'
    ];

    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    public static function getAllGrouped()
    {
        $settings = self::orderBy('group')
            ->orderBy('order')
            ->get();
        
        $grouped = [];
        
        foreach ($settings as $setting) {
            $group = $setting->group;
            $key = $setting->key;
            
            if (!isset($grouped[$group])) {
                $grouped[$group] = [];
            }
            
            $grouped[$group][$key] = $setting->value;
        }
        
        return $grouped;
    }
}