<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $hasFacilities = Schema::hasColumn('services', 'facilities');
        $hasTermsConditions = Schema::hasColumn('services', 'terms_conditions');
        $hasPanoramaImage = Schema::hasColumn('services', 'panorama_image');

        $generalServices = [
            [
                'name' => 'Sewa Aula Serbaguna',
                'description' => 'Layanan sewa aula untuk seminar, pelatihan, dan pertemuan komunitas.',
                'facilities' => "Kursi & meja\nSound system standar\nKebersihan ruangan",
                'terms_conditions' => "Durasi minimal 4 jam\nJadwal sesuai ketersediaan",
                'price_per_day' => 1200000,
                'capacity' => 200,
                'unit' => 'hari',
                'icon' => 'fas fa-building',
            ],
            [
                'name' => 'Sewa Peralatan Multimedia',
                'description' => 'Penyewaan proyektor, layar, dan perangkat audio untuk kegiatan presentasi.',
                'facilities' => "Proyektor\nLayar\nKabel & adaptor",
                'terms_conditions' => "Wajib deposit\nPenggunaan di area sekolah",
                'price_per_hour' => 100000,
                'unit' => 'jam',
                'icon' => 'fas fa-video',
            ],
            [
                'name' => 'Sewa Ruang Meeting',
                'description' => 'Ruang meeting kapasitas kecil-menengah untuk diskusi tim dan briefing.',
                'facilities' => "AC\nWi-Fi\nWhiteboard",
                'terms_conditions' => "Reservasi minimal H-1",
                'price_per_hour' => 75000,
                'capacity' => 20,
                'unit' => 'jam',
                'icon' => 'fas fa-users',
            ],
        ];

        foreach ($generalServices as $service) {
            $payload = [
                'name' => $service['name'],
                'description' => $service['description'],
                'price_per_hour' => $service['price_per_hour'] ?? null,
                'price_per_day' => $service['price_per_day'] ?? null,
                'capacity' => $service['capacity'] ?? null,
                'unit' => $service['unit'] ?? null,
                'icon' => $service['icon'] ?? 'fas fa-concierge-bell',
                'status' => 'available',
                'tefa_id' => null,
            ];

            if ($hasFacilities) {
                $payload['facilities'] = $service['facilities'] ?? null;
            }

            if ($hasTermsConditions) {
                $payload['terms_conditions'] = $service['terms_conditions'] ?? null;
            }

            if ($hasPanoramaImage) {
                $payload['panorama_image'] = null;
            }

            Service::create($payload);
        }

        $this->command?->info('✅ ' . count($generalServices) . ' layanan sewa dummy (super admin) berhasil dibuat.');
    }
}
