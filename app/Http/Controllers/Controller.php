<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

abstract class Controller
{
    /**
     * Returns 'superadmin' or 'admin' based on current admin role.
     * Used for dynamic redirects that work for both route groups.
     */
    protected function getRoutePrefix(): string
    {
        /** @var \App\Models\Admin|null $admin */
        $admin = Auth::guard('admin')->user();
        return ($admin && $admin->isSuperAdmin()) ? 'superadmin' : 'admin';
    }
}
