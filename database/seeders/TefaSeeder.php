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
                'name' => 'Akuntansi Keuangan Lembaga',
                'icon' => 'fas fa-calculator',
                'description' => 'Jurusan Akuntansi dan Keuangan Lembaga menyediakan berbagai layanan profesional di bidang akuntansi, pembukuan, dan konsultasi keuangan untuk membantu bisnis Anda berkembang.',
                'services' => json_encode([
                    'Jasa Pembukuan & Akuntansi',
                    'Konsultasi Pajak',
                    'Audit Keuangan',
                    'Pembuatan Laporan Keuangan',
                    'Pelatihan Akuntansi'
                ]),
                'contact_person' => 'Ibu Siti Nurjanah',
                'contact_number' => '081234567890',
                'contact_email' => 'akl@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567890',
            ],
            [
                'code' => 'MPLB',
                'name' => 'Manajemen Perkantoran Layanan Bisnis',
                'icon' => 'fas fa-briefcase',
                'description' => 'Jurusan MPLB menyediakan layanan administrasi perkantoran profesional, manajemen arsip, dan dukungan bisnis untuk meningkatkan efisiensi operasional perusahaan Anda.',
                'services' => json_encode([
                    'Administrasi Perkantoran',
                    'Manajemen Arsip & Dokumen',
                    'Jasa Sekretaris',
                    'Event Organizer',
                    'Pengetikan & Penggandaan'
                ]),
                'contact_person' => 'Ibu Rina Wulandari',
                'contact_number' => '081234567891',
                'contact_email' => 'mplb@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567891',
            ],
            [
                'code' => 'PM',
                'name' => 'Pemasaran',
                'icon' => 'fas fa-chart-line',
                'description' => 'Jurusan Pemasaran menawarkan solusi marketing digital dan konvensional yang inovatif untuk meningkatkan brand awareness dan penjualan produk Anda.',
                'services' => json_encode([
                    'Digital Marketing',
                    'Social Media Management',
                    'Riset Pasar',
                    'Promosi & Branding',
                    'Content Marketing'
                ]),
                'contact_person' => 'Bapak Ahmad Fauzi',
                'contact_number' => '081234567892',
                'contact_email' => 'pm@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567892',
            ],
            [
                'code' => 'KULINER',
                'name' => 'Kuliner',
                'icon' => 'fas fa-utensils',
                'description' => 'Jurusan Kuliner menyediakan layanan catering berkualitas dengan menu variatif dan cita rasa istimewa untuk berbagai acara dan kebutuhan Anda.',
                'services' => json_encode([
                    'Catering Acara',
                    'Kue & Pastry',
                    'Paket Nasi Box',
                    'Snack & Prasmanan',
                    'Pelatihan Memasak'
                ]),
                'contact_person' => 'Chef Dedi Kurniawan',
                'contact_number' => '081234567893',
                'contact_email' => 'kuliner@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567893',
            ],
            [
                'code' => 'HOTEL',
                'name' => 'Perhotelan',
                'icon' => 'fas fa-hotel',
                'description' => 'Jurusan Perhotelan menawarkan layanan hospitality profesional, pengelolaan event, dan pelayanan tamu dengan standar industri perhotelan internasional.',
                'services' => json_encode([
                    'Event Management',
                    'Wedding Organizer',
                    'Room Service Training',
                    'Housekeeping Service',
                    'Front Office Service'
                ]),
                'contact_person' => 'Bapak Eko Prasetyo',
                'contact_number' => '081234567894',
                'contact_email' => 'hotel@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567894',
            ],
            [
                'code' => 'DKV',
                'name' => 'Desain Komunikasi Visual',
                'icon' => 'fas fa-paint-brush',
                'description' => 'Jurusan DKV menyediakan jasa desain grafis profesional, multimedia, dan branding visual untuk kebutuhan promosi dan identitas bisnis Anda.',
                'services' => json_encode([
                    'Desain Logo & Branding',
                    'Desain Poster & Banner',
                    'Video Editing',
                    'Fotografi Produk',
                    'Animasi & Motion Graphics'
                ]),
                'contact_person' => 'Bapak Fajar Ramadhan',
                'contact_number' => '081234567895',
                'contact_email' => 'dkv@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567895',
            ],
            [
                'code' => 'PPLG',
                'name' => 'Pengembangan Perangkat Lunak & Gim',
                'icon' => 'fas fa-laptop-code',
                'description' => 'Jurusan PPLG menawarkan solusi teknologi informasi mulai dari pembuatan website, aplikasi mobile, hingga sistem informasi untuk mendukung transformasi digital bisnis Anda.',
                'services' => json_encode([
                    'Pembuatan Website',
                    'Aplikasi Mobile',
                    'Sistem Informasi',
                    'Maintenance & Support',
                    'Pelatihan Programming'
                ]),
                'contact_person' => 'Bapak Guntur Wijaya',
                'contact_number' => '081234567896',
                'contact_email' => 'pplg@smkn1ciamis.sch.id',
                'whatsapp_url' => 'https://wa.me/6281234567896',
            ],
        ];

        $order = 1;
        foreach ($tefas as $tefa) {
            Tefa::create([
                'code' => $tefa['code'],
                'name' => $tefa['name'],
                'slug' => Str::slug($tefa['name']),
                'icon' => $tefa['icon'],
                'description' => $tefa['description'],
                'services' => $tefa['services'],
                'contact_person' => $tefa['contact_person'],
                'contact_number' => $tefa['contact_number'],
                'contact_email' => $tefa['contact_email'],
                'whatsapp_url' => $tefa['whatsapp_url'],
                'is_active' => true,
                'order' => $order++,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ ' . Tefa::count() . ' TEFA berhasil dibuat!');
        $this->command->info('📋 Jurusan: AKL, MPLB, PM, KULINER, HOTEL, DKV, PPLG');
    }
}