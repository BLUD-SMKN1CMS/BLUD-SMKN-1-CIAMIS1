<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tefa;
use App\Models\Product;
use App\Models\Service;
use App\Models\Contact;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\Admin $admin */
        $admin = Auth::guard('admin')->user();

        // Jika admin-tefa, filter hanya untuk TEFA miliknya
        if ($admin->isAdminTefa()) {
            $activeTefahQuery = Tefa::where('is_active', true)->where('id', $admin->tefa_id);
        } else {
            // Superadmin: ambil semua
            $activeTefahQuery = Tefa::where('is_active', true);
        }

        // Ambil data untuk dashboard
        $stats = [
            'total_tefas' => $activeTefahQuery->count(),
            'total_products' => Product::when($admin->isAdminTefa(), function ($q) use ($admin) {
                return $q->whereHas('tefa', function ($q) use ($admin) {
                    $q->where('id', $admin->tefa_id);
                });
            })->where('status', 'active')->count(),
            'total_services' => Service::where('status', 'available')->count(),
            'total_contacts' => Contact::where('status', 'new')->count(),
        ];

        // Pesan terbaru
        $recentContacts = Contact::latest()->take(5)->get();

        // TEFA terbaru - sesuai dengan role admin
        $recentTefas = $admin->isAdminTefa()
            ? Tefa::where('id', $admin->tefa_id)->latest()->take(5)->get()
            : Tefa::latest()->take(5)->get();

        // Data tambahan untuk admin-tefa: produk & layanan terbaru milik TEFA-nya
        $recentProducts = $admin->isAdminTefa()
            ? Product::where('tefa_id', $admin->tefa_id)->latest()->take(5)->get()
            : collect();

        // Return view sesuai role
        if ($admin->isAdminTefa()) {
            $myTefa = Tefa::find($admin->tefa_id);
            return view('admin.dashboard.admin-tefa', compact('stats', 'recentContacts', 'myTefa', 'recentProducts'));
        }

        // Return view DENGAN LAYOUT ADMIN (superadmin)
        return view('admin.dashboard.index', compact('stats', 'recentContacts', 'recentTefas'));
    }
}
