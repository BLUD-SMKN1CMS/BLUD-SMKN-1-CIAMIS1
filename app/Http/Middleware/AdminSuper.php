<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminSuper
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is authenticated
        /** @var \App\Models\Admin|null $user */
        $user = Auth::guard("admin")->user();

        if (!$user) {
            return redirect()->route("admin.login")
                ->withErrors(["message" => "Silakan login sebagai admin terlebih dahulu."]);
        }

        // Check if admin is super admin
        if (!$user->isSuperAdmin()) {
            return redirect()->route("admin.dashboard")
                ->withErrors(["message" => "Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini."]);
        }

        return $next($request);
    }
}
