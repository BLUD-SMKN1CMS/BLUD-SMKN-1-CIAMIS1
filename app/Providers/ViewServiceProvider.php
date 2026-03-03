<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share $routePrefix ke semua view admin
        // superadmin → 'superadmin', admin-tefa → 'admin'
        view()->composer('*', function ($view) {
            /** @var \App\Models\Admin|null $admin */
            $admin = Auth::guard('admin')->user();
            if ($admin) {
                $routePrefix = $admin->isSuperAdmin() ? 'superadmin' : 'admin';
            } else {
                $routePrefix = 'admin';
            }
            $view->with('routePrefix', $routePrefix);
        });
    }
}
