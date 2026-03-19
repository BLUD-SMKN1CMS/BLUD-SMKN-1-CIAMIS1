<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $this->ensureLandingPageSettings();

        $settings = Setting::orderBy('group')->orderBy('order')->get();
        $groups = $settings->groupBy('group');

        return view('admin.settings.index', compact('groups'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');
        $keys = array_keys($data);
        $settings = Setting::whereIn('key', $keys)->get()->keyBy('key');

        foreach ($data as $key => $value) {
            if (!isset($settings[$key])) {
                continue;
            }

            $settings[$key]->value = $value;
            $settings[$key]->save();
        }

        return redirect()->route('superadmin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }

    private function ensureLandingPageSettings(): void
    {
        $landingSettings = [
            [
                'key' => 'landing_hero_title',
                'value' => 'selamat datang di smkn1 ciamis',
                'group' => 'landing',
                'type' => 'text',
                'description' => 'Judul Hero Landing Page',
                'order' => 1,
            ],
            [
                'key' => 'landing_hero_description',
                'value' => 'ini dia smk terkeren',
                'group' => 'landing',
                'type' => 'textarea',
                'description' => 'Deskripsi Hero Landing Page',
                'order' => 2,
            ],
            [
                'key' => 'landing_primary_button_text',
                'value' => 'Mulai Sekarang',
                'group' => 'landing',
                'type' => 'text',
                'description' => 'Teks Tombol Utama Hero',
                'order' => 3,
            ],
            [
                'key' => 'landing_primary_button_url',
                'value' => '#tefa-section',
                'group' => 'landing',
                'type' => 'text',
                'description' => 'URL Tombol Utama Hero',
                'order' => 4,
            ],
            [
                'key' => 'landing_secondary_button_text',
                'value' => 'Pelajari Lebih Lanjut',
                'group' => 'landing',
                'type' => 'text',
                'description' => 'Teks Tombol Kedua Hero',
                'order' => 5,
            ],
            [
                'key' => 'landing_secondary_button_url',
                'value' => '#kontak-section',
                'group' => 'landing',
                'type' => 'text',
                'description' => 'URL Tombol Kedua Hero',
                'order' => 6,
            ],
        ];

        foreach ($landingSettings as $setting) {
            $existing = Setting::where('key', $setting['key'])->first();

            if (!$existing) {
                Setting::create($setting);
                continue;
            }

            $existing->update([
                'group' => $setting['group'],
                'type' => $setting['type'],
                'description' => $setting['description'],
                'order' => $setting['order'],
            ]);
        }
    }
}
