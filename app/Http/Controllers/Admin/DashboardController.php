<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tefa;
use App\Models\Product;
use App\Models\Service;
use App\Models\Contact;
use App\Models\Carousel;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data untuk dashboard
        $stats = [
            'total_tefas' => Tefa::where('is_active', true)->count(),
            'total_products' => Product::where('status', 'active')->count(),
            'total_services' => Service::where('status', 'available')->count(),
            'total_contacts' => Contact::where('status', 'new')->count(),
        ];
        
        // Return view DENGAN LAYOUT ADMIN
        return view('admin.dashboard.index', compact('stats'));
    }
}
