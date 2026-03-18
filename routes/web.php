<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TefaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CarouselController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BookingController;

// ==================== PUBLIC ROUTES ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tefa', [HomeController::class, 'allTefa'])->name('tefa.all');
Route::get('/tefa/{slug}', [HomeController::class, 'showTefa'])->name('tefa.show');
Route::get('/produk', [HomeController::class, 'allProducts'])->name('products.all');
Route::get('/produk/{slug}', [HomeController::class, 'showProduct'])->name('products.show');
Route::get('/layanan', [HomeController::class, 'allServices'])->name('services.all');
Route::get('/layanan/{slug}', [HomeController::class, 'showService'])->name('service.show');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.submit');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/api/featured-products', [HomeController::class, 'getFeaturedProducts'])->name('api.featured-products');
Route::get('/api/latest-products', [HomeController::class, 'getLatestProducts'])->name('api.latest-products');

// Booking Routes
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{transactionId}', [BookingController::class, 'success'])->name('booking.success');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->group(function () {
    // Public Admin Routes (No auth required)
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    // Shared logout
    Route::middleware(['auth:admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Protected Admin-TEFA Routes (Auth required + AdminTefaOnly)
    Route::middleware(['auth:admin', \App\Http\Middleware\AdminTefaOnly::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // TEFA Management (Admin TEFA can only edit their own TEFA)
        Route::get('/tefas/{tefa}/edit', [TefaController::class, 'edit'])->name('tefas.edit');
        Route::put('/tefas/{tefa}', [TefaController::class, 'update'])->name('tefas.update');

        // Products
        Route::resource('products', ProductController::class);

        // Services
        Route::resource('services', ServiceController::class);

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

        // Payments
        Route::resource('payments', PaymentController::class);
        Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
        Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

        // Stats
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');

        // Export/Import
        Route::get('/export/products', [ProductController::class, 'export'])->name('export.products');
        Route::get('/export/services', [ServiceController::class, 'export'])->name('export.services');
        Route::post('/import/products', [ProductController::class, 'import'])->name('import.products');
    });
});

// ==================== SUPER ADMIN ROUTES ====================
Route::prefix('super-admin')->name('superadmin.')->group(function () {
    // Protected Super Admin Routes (Auth required + AdminSuper)
    Route::middleware(['auth:admin', \App\Http\Middleware\AdminSuper::class])->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Logout (superadmin also needs this)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // Products
        Route::resource('products', ProductController::class);

        // Services
        Route::resource('services', ServiceController::class);

        // TEFAs
        Route::resource('tefas', TefaController::class);

        // TEFA Content Management (Edit detail konten TEFA: about, vision, mission, dll)
        Route::get('/tefas-content', [TefaController::class, 'contentIndex'])->name('tefas.content.index');
        Route::get('/tefas-content/{tefa}/edit', [TefaController::class, 'contentEdit'])->name('tefas.content.edit');
        Route::put('/tefas-content/{tefa}', [TefaController::class, 'contentUpdate'])->name('tefas.content.update');

        // Contacts
        Route::resource('contacts', AdminContactController::class)->except(['create', 'store']);
        Route::post('/contacts/{contact}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
        Route::post('/contacts/{contact}/mark-as-read', [AdminContactController::class, 'markAsRead'])->name('contacts.markAsRead');
        Route::post('/contacts/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('contacts.bulkDelete');

        // Carousels
        Route::resource('carousels', CarouselController::class);
        Route::post('/carousels/{carousel}/set-active', [CarouselController::class, 'setActive'])->name('carousels.setActive');
        Route::post('/carousels/{carousel}/toggle-status', [CarouselController::class, 'toggleStatus'])->name('carousels.toggle-status');
        Route::post('/carousels/update-order', [CarouselController::class, 'updateOrder'])->name('carousels.update-order');

        // Admin Management
        Route::resource('admin-management', AdminManagementController::class);

        // Profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
        Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

        // Payments
        Route::resource('payments', PaymentController::class);
        Route::post('/payments/{payment}/confirm', [PaymentController::class, 'confirm'])->name('payments.confirm');
        Route::post('/payments/{payment}/cancel', [PaymentController::class, 'cancel'])->name('payments.cancel');

        // Stats & Export
        Route::get('/stats', [DashboardController::class, 'getStats'])->name('stats');
        Route::get('/export/tefas', [TefaController::class, 'export'])->name('export.tefas');
        Route::get('/export/products', [ProductController::class, 'export'])->name('export.products');
        Route::get('/export/services', [ServiceController::class, 'export'])->name('export.services');
        Route::post('/import/tefas', [TefaController::class, 'import'])->name('import.tefas');
        Route::post('/import/products', [ProductController::class, 'import'])->name('import.products');
        Route::get('/backup', [SettingsController::class, 'backup'])->name('backup');
        Route::post('/backup/download', [SettingsController::class, 'downloadBackup'])->name('backup.download');
    });
});

// ==================== API ROUTES ====================
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/tefas', [HomeController::class, 'getTefas'])->name('tefas');
    Route::get('/products/latest', [HomeController::class, 'getLatestProducts'])->name('products.latest');
    Route::get('/services/featured', [HomeController::class, 'getFeaturedServices'])->name('services.featured');
    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard-stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');
        Route::get('/recent-activities', [DashboardController::class, 'getRecentActivities'])->name('dashboard.activities');
    });
});

// ==================== FALLBACK ROUTES ====================
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});

// ==================== REDIRECT FOR OLD LOGIN ====================
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

Route::post('/login', function () {
    return redirect()->route('admin.login');
});
