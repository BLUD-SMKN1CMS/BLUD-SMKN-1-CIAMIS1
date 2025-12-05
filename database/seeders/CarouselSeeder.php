<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Carousel;

class CarouselSeeder extends Seeder
{
    public function run(): void
    {
        $carousels = [
            [
                'title' => 'Selamat Datang di TEFA SMKN 1 Ciamis',
                'description' => 'Teaching Factory untuk mengasah keterampilan siswa',
                'image' => 'carousels/banner1.jpg',
                'status' => 'active',
                'order' => 1,
                'button_text' => 'Lihat Jurusan',
                'button_url' => '/tefa',
            ],
            [
                'title' => '7 Jurusan Unggulan',
                'description' => 'AKL, PM, MPLB, HOTEL, KULINER, DKV, PPLG',
                'image' => 'carousels/banner2.jpg',
                'status' => 'active',
                'order' => 2,
                'button_text' => 'Lihat Produk',
                'button_url' => '/produk',
            ],
            [
                'title' => 'Produk & Layanan Berkualitas',
                'description' => 'Hasil karya siswa yang siap dipasarkan',
                'image' => 'carousels/banner3.jpg',
                'status' => 'active',
                'order' => 3,
                'button_text' => 'Hubungi Kami',
                'button_url' => '/kontak',
            ],
        ];
        
        foreach ($carousels as $carousel) {
            Carousel::create($carousel);
        }
        
        $this->command->info('✅ ' . Carousel::count() . ' carousel berhasil ditambahkan!');
    }
}