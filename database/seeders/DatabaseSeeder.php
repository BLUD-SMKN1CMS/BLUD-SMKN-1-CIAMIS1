<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Matikan foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Tambah tabel baru ke list truncate
        $tables = ['admins', 'tefas', 'products', 'services', 'contacts', 'carousels', 'settings', 'statistics'];

        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->command->info("Truncated table: {$table}");
        }

        // Hidupkan kembali foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Jalankan seeders - URUTAN PENTING!
        $this->call([
            TefaSeeder::class,       // 1. TEFA jurusan
            AdminSeeder::class,      // 2. Admin user (super admin + admin tefa)
            SettingsSeeder::class,   // 3. Settings (butuh setelah TEFA)
            StatisticsSeeder::class, // 4. Statistics (butuh setelah TEFA & Settings)
            ServiceSeeder::class,    // 5. Services
            ProductSeeder::class,    // 6. Products (seed dari layanan jurusan legacy)
            // ContactSeeder::class,  // 7. Contacts (NONAKTIFKAN - auto dari form)
            // CarouselSeeder::class, // 8. Carousels (NONAKTIFKAN - siap ditambah via admin)
        ]);

        $this->command->info('✅ Semua data seed berhasil ditambahkan!');
        $this->command->info('📋 Data yang ditambahkan:');
        $this->command->info('   • Admin: superadmin + admin tiap TEFA');
        $this->command->info('   • TEFA: 7 jurusan');
        $this->command->info('   • Settings: Kontak, sosial media, jam operasional');
        $this->command->info('   • Statistics: Counter dinamis');
        $this->command->info('   • Services: 3 layanan sewa umum (tanpa TEFA)');
        $this->command->info('   • Products: layanan jurusan (kategori jasa) dari data TEFA');
        $this->command->info('   • Carousels: KOSONG (siap ditambah via admin)');
    }
}
