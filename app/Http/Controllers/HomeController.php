<?php

namespace App\Http\Controllers;

use App\Models\Tefa;
use App\Models\Product;
use App\Models\Service;
use App\Models\Carousel;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Statistic;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // 1. Carousels
            $carousels = Carousel::where('status', 'active')
                ->orderBy('order')
                ->get();
            
            // 2. Statistics
            $stats = [
                'total_tefas' => Tefa::where('is_active', true)->count(),
                'total_products' => Product::where('status', 'active')->count(),
                'total_services' => Service::where('status', 'available')->count(),
                'total_students' => Statistic::getValue('total_students', 1000),
            ];
            
            // 3. TEFA aktif dengan produk
            $tefas = Tefa::with(['products' => function($query) {
                    $query->where('status', 'active')->limit(3);
                }])
                ->where('is_active', true)
                ->orderBy('order')
                ->get();
            
            // 4. PRODUK UNGGULAN - SIMPLIFY
            $featuredProducts = Product::with('tefa')
                ->where('status', 'active')
                ->where('is_featured', true)
                ->orderBy('order')
                ->limit(8)
                ->get();
            
            // 5. Jika tidak ada featured, ambil terbaru
            if ($featuredProducts->isEmpty()) {
                $featuredProducts = Product::with('tefa')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->limit(8)
                    ->get();
            }
            
            // 6. Services
            $services = Service::where('status', 'available')
                ->orderBy('created_at', 'desc')
                ->limit(6)
                ->get();
            
            // 7. Settings
            $settings = Setting::getAllGrouped();
            
            $contactInfo = [
                'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
                'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
                'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
                'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
                'whatsapp_message' => $settings['contact']['whatsapp_message'] ?? 'Halo, saya tertarik dengan layanan BLUD SMKN 1 Ciamis',
                'opening_hours_weekdays' => $settings['hours']['opening_hours_weekdays'] ?? 'Senin - Jumat: 08:00 - 16:00',
                'opening_hours_saturday' => $settings['hours']['opening_hours_saturday'] ?? 'Sabtu: 08:00 - 14:00',
                'opening_hours_sunday' => $settings['hours']['opening_hours_sunday'] ?? 'Minggu & Hari Libur Nasional: Tutup',
            ];
            
            // 8. Social media
            $socialMedia = [
                'facebook' => $settings['social']['facebook_url'] ?? '#',
                'instagram' => $settings['social']['instagram_url'] ?? '#',
                'youtube' => $settings['social']['youtube_url'] ?? '#',
                'tiktok' => $settings['social']['tiktok_url'] ?? '#',
                'twitter' => $settings['social']['twitter_url'] ?? '#',
            ];
            
            // 9. DEBUG: Log untuk verifikasi
            Log::info('=== HOME PAGE LOADED ===');
            foreach ($featuredProducts as $product) {
                Log::info("Product: {$product->name}", [
                    'id' => $product->id,
                    'image_db' => $product->image,
                    'image_url' => $product->image_url,
                    'file_exists' => $product->image ? file_exists(public_path($product->image)) : false
                ]);
            }
            
            return view('home', compact(
                'carousels',
                'stats',
                'tefas', 
                'featuredProducts', 
                'services',
                'contactInfo',
                'socialMedia'
            ));
            
        } catch (\Exception $e) {
            Log::error('HomeController error: ' . $e->getMessage());
            
            return view('home', [
                'carousels' => collect(),
                'stats' => [],
                'tefas' => collect(),
                'featuredProducts' => collect(),
                'services' => collect(),
                'contactInfo' => [
                    'company_address' => 'Jl. Raya Ciamis No.123, Jawa Barat',
                    'company_phone' => '(0265) 123456',
                    'company_email' => 'blud@smkn1ciamis.sch.id',
                    'whatsapp_number' => '6281234567890',
                ],
                'socialMedia' => [
                    'facebook' => '#',
                    'instagram' => '#',
                    'youtube' => '#',
                    'tiktok' => '#',
                    'twitter' => '#',
                ],
            ]);
        }
    }
    
    // ========== ALL TEFA ==========
    public function allTefa()
    {
        $tefas = Tefa::withCount(['products' => function($query) {
                $query->where('status', 'active');
            }])
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('tefa.all', compact(
            'tefas', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== SHOW TEFA ==========
    public function showTefa($slug)
    {
        $tefa = Tefa::where('slug', $slug)->firstOrFail();
        
        $products = Product::where('tefa_id', $tefa->id)
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->through(function ($product) {
                $product->image_url = $product->image_url; // Use model accessor
                return $product;
            });
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('tefa.show', compact(
            'tefa', 
            'products', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== ALL PRODUCTS ==========
    public function allProducts(Request $request)
    {
        $query = Product::with('tefa')
            ->where('status', 'active');
        
        // Filter by TEFA jika ada
        if ($request->has('tefa') && $request->tefa != 'all') {
            $query->whereHas('tefa', function($q) use ($request) {
                $q->where('slug', $request->tefa);
            });
        }
        
        // Filter by category jika ada
        if ($request->has('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        // Filter by search keyword
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $products = $query->orderBy('created_at', 'desc')
            ->paginate(12);
        
        $tefas = Tefa::where('is_active', true)->get();
        $categories = Product::select('category')->distinct()->pluck('category');
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('product.all', compact(
            'products', 
            'tefas', 
            'categories', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== SHOW PRODUCT ==========
    public function showProduct($slug)
    {
        $product = Product::with('tefa')
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Related products (same TEFA, exclude current)
        $relatedProducts = Product::where('tefa_id', $product->tefa_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        $socialMedia = [
            'facebook' => $settings['social']['facebook_url'] ?? '#',
            'instagram' => $settings['social']['instagram_url'] ?? '#',
            'youtube' => $settings['social']['youtube_url'] ?? '#',
            'tiktok' => $settings['social']['tiktok_url'] ?? '#',
            'twitter' => $settings['social']['twitter_url'] ?? '#',
        ];
        
        return view('product.show', compact(
            'product', 
            'relatedProducts', 
            'contactInfo',
            'socialMedia',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== ALL SERVICES ==========
    public function allServices(Request $request)
    {
        $query = Service::where('status', 'available');
        
        // Filter by search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }
        
        $services = $query->orderBy('created_at', 'desc')
            ->paginate(12);
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('service.all', compact(
            'services', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== SHOW SERVICE ==========
    public function showService($slug)
    {
        $service = Service::where('slug', $slug)->firstOrFail();
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('service.show', compact(
            'service', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== CONTACT PAGE ==========
    public function contact()
    {
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
            'opening_hours_weekdays' => $settings['hours']['opening_hours_weekdays'] ?? 'Senin - Jumat: 08:00 - 16:00',
            'opening_hours_saturday' => $settings['hours']['opening_hours_saturday'] ?? 'Sabtu: 08:00 - 14:00',
            'opening_hours_sunday' => $settings['hours']['opening_hours_sunday'] ?? 'Minggu & Hari Libur Nasional: Tutup',
        ];
        
        $socialMedia = [
            'facebook' => $settings['social']['facebook_url'] ?? '#',
            'instagram' => $settings['social']['instagram_url'] ?? '#',
            'youtube' => $settings['social']['youtube_url'] ?? '#',
            'tiktok' => $settings['social']['tiktok_url'] ?? '#',
            'twitter' => $settings['social']['twitter_url'] ?? '#',
        ];
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        return view('contact', compact(
            'contactInfo', 
            'socialMedia',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== SEARCH PAGE ==========
    public function search(Request $request)
    {
        $keyword = $request->input('q');
        
        if (empty($keyword)) {
            return redirect()->back()->with('error', 'Masukkan kata kunci pencarian');
        }
        
        // Search products
        $products = Product::with('tefa')
            ->where('status', 'active')
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%')
                      ->orWhere('category', 'like', '%' . $keyword . '%');
            })
            ->limit(10)
            ->get();
        
        // Search services
        $services = Service::where('status', 'available')
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->limit(10)
            ->get();
        
        // Search TEFA
        $tefas = Tefa::where('is_active', true)
            ->where(function($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                      ->orWhere('description', 'like', '%' . $keyword . '%')
                      ->orWhere('code', 'like', '%' . $keyword . '%');
            })
            ->limit(10)
            ->get();
        
        // FIX: Tambahkan footer data
        $footerServices = Service::where('status', 'available')->limit(3)->get();
        $footerTefas = Tefa::where('is_active', true)->orderBy('order')->get();
        
        // Settings untuk kontak
        $settings = Setting::getAllGrouped();
        
        $contactInfo = [
            'company_address' => $settings['contact']['company_address'] ?? 'Jl. Raya Ciamis No.123, Jawa Barat',
            'company_phone' => $settings['contact']['company_phone'] ?? '(0265) 123456',
            'company_email' => $settings['contact']['company_email'] ?? 'blud@smkn1ciamis.sch.id',
            'whatsapp_number' => $settings['contact']['whatsapp_number'] ?? '6281234567890',
        ];
        
        return view('search.results', compact(
            'products', 
            'services', 
            'tefas', 
            'keyword', 
            'contactInfo',
            'footerTefas',
            'footerServices'
        ));
    }
    
    // ========== API ENDPOINTS ==========
    public function getFeaturedProducts()
    {
        $products = Product::with('tefa')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('order')
            ->limit(8)
            ->get();
        
        return response()->json($products);
    }
    
    public function getLatestProducts()
    {
        $products = Product::with('tefa')
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();
        
        return response()->json($products);
    }
}