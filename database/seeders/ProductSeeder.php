<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Tefa;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua TEFA
        $tefas = Tefa::all();
        
        if ($tefas->isEmpty()) {
            $this->command->warn('⚠️ Tidak ada data TEFA. Jalankan TefaSeeder terlebih dahulu!');
            return;
        }
        
        $baseProducts = [
            [
                'name' => 'Jasa Akuntansi UKM',
                'price' => 500000,
                'stock' => 10,
                'category' => 'Jasa',
                'status' => 'active',
                'is_featured' => true,
                'order' => 1,
                'description' => 'Jasa pembukuan dan akuntansi untuk UKM',
            ],
            [
                'name' => 'Laporan Keuangan',
                'price' => 300000,
                'stock' => 20,
                'category' => 'Dokumen',
                'status' => 'active',
                'is_featured' => false,
                'order' => 2,
                'description' => 'Pembuatan laporan keuangan bulanan',
            ],
            [
                'name' => 'Website Company Profile',
                'price' => 3500000,
                'stock' => 5,
                'category' => 'Website',
                'status' => 'active',
                'is_featured' => true,
                'order' => 1,
                'description' => 'Pembuatan website company profile responsif',
            ],
        ];
        
        $productCount = 0;
        
        foreach ($tefas as $tefaIndex => $tefa) {
            // Untuk setiap TEFA, buat 2-3 produk
            $productsPerTefa = min(3, count($baseProducts));
            
            for ($i = 0; $i < $productsPerTefa; $i++) {
                $baseProduct = $baseProducts[$i];
                
                // Buat nama produk dengan TEFA
                $productName = $baseProduct['name'] . ' - ' . $tefa->name;
                
                // Buat deskripsi dengan nama TEFA
                $description = $baseProduct['description'] . ' oleh ' . $tefa->name;
                
                // Buat slug unik dengan timestamp
                $slug = Str::slug($productName) . '-' . time() . '-' . $productCount;
                
                Product::create([
                    'tefa_id' => $tefa->id,
                    'name' => $productName,
                    'slug' => $slug,
                    'price' => $baseProduct['price'] + ($tefaIndex * 100000),
                    'stock' => $baseProduct['stock'],
                    'category' => $baseProduct['category'],
                    'status' => $baseProduct['status'],
                    'is_featured' => $baseProduct['is_featured'],
                    'order' => $baseProduct['order'] + $tefaIndex,
                    'description' => $description,
                    'image' => 'products/default-product-' . (($productCount % 3) + 1) . '.jpg',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $productCount++;
                $this->command->info("Created product: {$productName}");
            }
        }
        
        $this->command->info('✅ ' . $productCount . ' produk berhasil ditambahkan!');
    }
}