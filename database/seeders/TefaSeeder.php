<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tefa;
use Illuminate\Support\Str;

class TefaSeeder extends Seeder
{
    public function run(): void
    {
        $tefas = [
            [
                'code' => 'AKL',
                'name' => 'TEFA AKL',
                'description' => 'Akuntansi dan Keuangan Lembaga - Menyediakan jasa akuntansi dan konsultasi keuangan',
                'contact_person' => 'Bu Ani',
                'contact_number' => '081234567890',
                'contact_email' => 'akl@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567890',
                'logo' => 'tefa/akl.png',
                'banner' => 'tefa/akl-banner.jpg',
            ],
            [
                'code' => 'PM',
                'name' => 'TEFA PM',
                'description' => 'Pemasaran - Menyediakan jasa pemasaran digital dan konvensional',
                'contact_person' => 'Pak Budi',
                'contact_number' => '081234567891',
                'contact_email' => 'pm@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567891',
                'logo' => 'tefa/pm.png',
                'banner' => 'tefa/pm-banner.jpg',
            ],
            [
                'code' => 'MPLB',
                'name' => 'TEFA MPLB',
                'description' => 'Manajemen Perkantoran dan Layanan Bisnis - Menyediakan jasa administrasi perkantoran',
                'contact_person' => 'Ibu Citra',
                'contact_number' => '081234567892',
                'contact_email' => 'mplb@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567892',
                'logo' => 'tefa/mplb.png',
                'banner' => 'tefa/mplb-banner.jpg',
            ],
            [
                'code' => 'HOTEL',
                'name' => 'TEFA HOTEL',
                'description' => 'Perhotelan - Menyediakan jasa hospitality dan event organizer',
                'contact_person' => 'Pak Dedi',
                'contact_number' => '081234567893',
                'contact_email' => 'hotel@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567893',
                'logo' => 'tefa/hotel.png',
                'banner' => 'tefa/hotel-banner.jpg',
            ],
            [
                'code' => 'KULINER',
                'name' => 'TEFA KULINER',
                'description' => 'Kuliner - Menyediakan catering dan jasa boga untuk berbagai acara',
                'contact_person' => 'Chef Eka',
                'contact_number' => '081234567894',
                'contact_email' => 'kuliner@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567894',
                'logo' => 'tefa/kuliner.png',
                'banner' => 'tefa/kuliner-banner.jpg',
            ],
            [
                'code' => 'DKV',
                'name' => 'TEFA DKV',
                'description' => 'Desain Komunikasi Visual - Menyediakan jasa desain grafis dan multimedia',
                'contact_person' => 'Pak Fajar',
                'contact_number' => '081234567895',
                'contact_email' => 'dkv@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567895',
                'logo' => 'tefa/dkv.png',
                'banner' => 'tefa/dkv-banner.jpg',
            ],
            [
                'code' => 'PPLG',
                'name' => 'TEFA PPLG',
                'description' => 'Pengembangan Perangkat Lunak dan Gim - Menyediakan jasa pembuatan website dan aplikasi',
                'contact_person' => 'Pak Guntur',
                'contact_number' => '081234567896',
                'contact_email' => 'pplg@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/081234567896',
                'logo' => 'tefa/pplg.png',
                'banner' => 'tefa/pplg-banner.jpg',
            ],
        ];

        $order = 1;
        foreach ($tefas as $tefa) {
            Tefa::create([
                'code' => $tefa['code'],
                'name' => $tefa['name'],
                'slug' => Str::slug($tefa['name']),
                'description' => $tefa['description'],
                'contact_person' => $tefa['contact_person'],
                'contact_number' => $tefa['contact_number'],
                'contact_email' => $tefa['contact_email'],
                'whatsapp_url' => $tefa['whatsapp_url'],
                'logo' => $tefa['logo'],
                'banner' => $tefa['banner'],
                'is_active' => true,
                'order' => $order++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ ' . Tefa::count() . ' TEFA berhasil dibuat!');
    }
}