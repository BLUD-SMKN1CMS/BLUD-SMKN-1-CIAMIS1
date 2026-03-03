<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminTefaOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\Admin|null $user */
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login')
                ->withErrors(['message' => 'Silakan login sebagai admin terlebih dahulu.']);
        }

        // Super admin tidak boleh akses rute admin-tefa
        if ($user->isSuperAdmin()) {
            return redirect()->route('superadmin.dashboard')
                ->withErrors(['message' => 'Akses ditolak. Super Admin gunakan panel super-admin.']);
        }

        return $next($request);
    }
}
