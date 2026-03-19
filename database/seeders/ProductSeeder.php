<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tefa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $hasIsFeatured = Schema::hasColumn('products', 'is_featured');
        $hasOrder = Schema::hasColumn('products', 'order');
        $hasUnit = Schema::hasColumn('products', 'unit');

        $tefas = Tefa::query()->orderBy('order')->get();
        $created = 0;

        foreach ($tefas as $tefa) {
            $legacyServices = [];

            if (is_array($tefa->services)) {
                $legacyServices = $tefa->services;
            } elseif (is_string($tefa->services) && trim($tefa->services) !== '') {
                $decoded = json_decode($tefa->services, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $legacyServices = $decoded;
                } else {
                    $legacyServices = preg_split('/\r\n|\r|\n|,/', $tefa->services);
                }
            }

            $legacyServices = collect($legacyServices)
                ->filter(fn($name) => is_string($name) && trim($name) !== '')
                ->map(fn($name) => trim($name))
                ->unique(fn($name) => strtolower($name))
                ->values();

            $order = 1;
            foreach ($legacyServices as $serviceName) {
                $payload = [
                    'description' => 'Layanan jurusan ' . $tefa->name . ': ' . $serviceName,
                    'price' => 0,
                    'category' => 'jasa',
                    'stock' => 0,
                    'status' => 'active',
                ];

                if ($hasUnit) {
                    $payload['unit'] = 'layanan';
                }

                if ($hasIsFeatured) {
                    $payload['is_featured'] = false;
                }

                if ($hasOrder) {
                    $payload['order'] = $order++;
                }

                Product::updateOrCreate(
                    [
                        'tefa_id' => $tefa->id,
                        'name' => $serviceName,
                    ],
                    $payload
                );

                $created++;
            }
        }

        $this->command?->info('✅ ' . $created . ' produk layanan (kategori jasa) berhasil dibuat dari data TEFA.');
    }
}
