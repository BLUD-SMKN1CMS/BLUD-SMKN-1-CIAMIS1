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
            AdminSeeder::class,      // 1. Admin user dulu
            TefaSeeder::class,       // 2. TEFA jurusan
            SettingsSeeder::class,   // 3. Settings (butuh setelah TEFA)
            StatisticsSeeder::class, // 4. Statistics (butuh setelah TEFA & Settings)
            ServiceSeeder::class,    // 5. Services
            // ProductSeeder::class,  // 6. Products (NONAKTIFKAN - siap ditambah via admin)
            // ContactSeeder::class,  // 7. Contacts (NONAKTIFKAN - auto dari form)
            // CarouselSeeder::class, // 8. Carousels (NONAKTIFKAN - siap ditambah via admin)
        ]);
        
        $this->command->info('✅ Semua data seed berhasil ditambahkan!');
        $this->command->info('📋 Data yang ditambahkan:');
        $this->command->info('   • Admin: 1 user (admin / kita ini admin cuy)');
        $this->command->info('   • TEFA: 7 jurusan');
        $this->command->info('   • Settings: Kontak, sosial media, jam operasional');
        $this->command->info('   • Statistics: Counter dinamis');
        $this->command->info('   • Services: 6 layanan sewa');
        $this->command->info('   • Products: KOSONG (siap ditambah via admin)');
        $this->command->info('   • Carousels: KOSONG (siap ditambah via admin)');
    }
}