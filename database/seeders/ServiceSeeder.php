<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        $services = [
            [
                'name' => 'Sewa Gedung',
                'description' => 'Gedung serbaguna dengan kapasitas besar, cocok untuk acara pernikahan, seminar, workshop, dan berbagai kegiatan lainnya. Dilengkapi dengan AC, sound system, proyektor, dan tempat parkir luas.',
                'price_per_hour' => 500000,
                'price_per_day' => 3500000,
                'capacity' => 500,
                'unit' => 'orang',
                'status' => 'available',
            ],
            [
                'name' => 'Sewa Ruang Meeting',
                'description' => 'Ruang meeting lengkap dengan AC, proyektor, dan sound system',
                'price_per_hour' => 150000,
                'price_per_day' => 1000000,
                'capacity' => 30,
                'unit' => 'orang',
                'status' => 'available',
            ],
            [
                'name' => 'Sewa Transportasi Sekolah',
                'description' => 'Bus sekolah dengan kapasitas 45 orang plus driver',
                'price_per_hour' => 300000,
                'price_per_day' => 2000000,
                'capacity' => 45,
                'unit' => 'bus',
                'status' => 'available',
            ],
            [
                'name' => 'Sewa Peralatan Kantor',
                'description' => 'Peralatan kantor lengkap: printer, komputer, meja kursi',
                'price_per_hour' => 50000,
                'price_per_day' => 300000,
                'capacity' => 10,
                'unit' => 'set',
                'status' => 'available',
            ],
            [
                'name' => 'Sewa Laboratorium Komputer',
                'description' => 'Lab komputer dengan 30 unit PC lengkap',
                'price_per_hour' => 200000,
                'price_per_day' => 1200000,
                'capacity' => 30,
                'unit' => 'lab',
                'status' => 'available',
            ],
            [
                'name' => 'Sewa Alat Musik',
                'description' => 'Berbagai alat musik untuk acara sekolah',
                'price_per_hour' => 100000,
                'price_per_day' => 600000,
                'capacity' => 15,
                'unit' => 'set',
                'status' => 'available',
            ],
        ];
        
        foreach ($services as $service) {
            Service::create([
                'name' => $service['name'],
                'slug' => Str::slug($service['name']),
                'description' => $service['description'],
                'price_per_hour' => $service['price_per_hour'],
                'price_per_day' => $service['price_per_day'],
                'capacity' => $service['capacity'],
                'unit' => $service['unit'],
                'image' => 'services/service-' . rand(1, 5) . '.jpg',
                'status' => $service['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('✅ ' . Service::count() . ' layanan berhasil ditambahkan!');
    }
}