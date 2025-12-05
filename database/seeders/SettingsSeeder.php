<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Contact Information
            [
                'key' => 'company_name',
                'value' => 'BLUD SMKN 1 CIAMIS',
                'group' => 'contact',
                'type' => 'text',
                'description' => 'Nama perusahaan/organisasi',
                'order' => 1,
            ],
            [
                'key' => 'company_address',
                'value' => 'Jl. Raya Ciamis No.123, Ciamis, Jawa Barat 46251',
                'group' => 'contact',
                'type' => 'textarea',
                'description' => 'Alamat lengkap',
                'order' => 2,
            ],
            [
                'key' => 'company_phone',
                'value' => '(0265) 123456',
                'group' => 'contact',
                'type' => 'text',
                'description' => 'Nomor telepon',
                'order' => 3,
            ],
            [
                'key' => 'company_email',
                'value' => 'blud@smkn1ciamis.sch.id',
                'group' => 'contact',
                'type' => 'email',
                'description' => 'Email utama',
                'order' => 4,
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '6281234567890',
                'group' => 'contact',
                'type' => 'text',
                'description' => 'Nomor WhatsApp (format: 628xxxxxxx)',
                'order' => 5,
            ],
            [
                'key' => 'whatsapp_message',
                'value' => 'Halo, saya tertarik dengan layanan BLUD SMKN 1 Ciamis',
                'group' => 'contact',
                'type' => 'textarea',
                'description' => 'Pesan default WhatsApp',
                'order' => 6,
            ],
            
            // Operating Hours
            [
                'key' => 'opening_hours_weekdays',
                'value' => 'Senin - Jumat: 08:00 - 16:00',
                'group' => 'hours',
                'type' => 'text',
                'description' => 'Jam operasional hari kerja',
                'order' => 1,
            ],
            [
                'key' => 'opening_hours_saturday',
                'value' => 'Sabtu: 08:00 - 14:00',
                'group' => 'hours',
                'type' => 'text',
                'description' => 'Jam operasional Sabtu',
                'order' => 2,
            ],
            [
                'key' => 'opening_hours_sunday',
                'value' => 'Minggu & Hari Libur Nasional: Tutup',
                'group' => 'hours',
                'type' => 'text',
                'description' => 'Jam operasional Minggu',
                'order' => 3,
            ],
            
            // Social Media
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/bludsmkn1ciamis',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL Facebook',
                'order' => 1,
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/bludsmkn1ciamis',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL Instagram',
                'order' => 2,
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com/bludsmkn1ciamis',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL YouTube',
                'order' => 3,
            ],
            [
                'key' => 'tiktok_url',
                'value' => 'https://tiktok.com/@bludsmkn1ciamis',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL TikTok',
                'order' => 4,
            ],
            [
                'key' => 'twitter_url',
                'value' => 'https://twitter.com/bludsmkn1ciamis',
                'group' => 'social',
                'type' => 'url',
                'description' => 'URL Twitter/X',
                'order' => 5,
            ],
        ];

        foreach ($settings as $setting) {
            // Gunakan updateOrCreate untuk menghindari duplicate error
            Setting::updateOrCreate(
                ['key' => $setting['key']], // Cari berdasarkan key
                $setting // Update atau create dengan data ini
            );
        }
        
        $this->command->info('✅ Settings seeder berhasil dijalankan!');
        $this->command->info('   Total settings: ' . Setting::count());
    }
}