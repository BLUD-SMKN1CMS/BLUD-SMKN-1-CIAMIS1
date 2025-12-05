<?php

namespace Database\Seeders;

use App\Models\Statistic;
use Illuminate\Database\Seeder;

class StatisticsSeeder extends Seeder
{
    public function run()
    {
        $statistics = [
            [
                'name' => 'total_tefas',
                'label' => 'TEFA Jurusan',
                'value' => 7,
                'icon' => 'fas fa-graduation-cap',
                'suffix' => '',
                'is_auto' => true,
                'auto_source' => 'tefas',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'total_products',
                'label' => 'Produk',
                'value' => 0,
                'icon' => 'fas fa-box-open',
                'suffix' => '+',
                'is_auto' => true,
                'auto_source' => 'products',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'total_services',
                'label' => 'Layanan Sewa',
                'value' => 3,
                'icon' => 'fas fa-handshake',
                'suffix' => '',
                'is_auto' => true,
                'auto_source' => 'services',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'total_students',
                'label' => 'Siswa',
                'value' => 1000,
                'icon' => 'fas fa-users',
                'suffix' => '+',
                'is_auto' => false,
                'auto_source' => null,
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($statistics as $statistic) {
            // Gunakan updateOrCreate untuk menghindari duplicate error
            Statistic::updateOrCreate(
                ['name' => $statistic['name']], // Cari berdasarkan name
                $statistic // Update atau create dengan data ini
            );
        }
        
        $this->command->info('✅ Statistics seeder berhasil dijalankan!');
        $this->command->info('   Total statistics: ' . Statistic::count());
    }
}