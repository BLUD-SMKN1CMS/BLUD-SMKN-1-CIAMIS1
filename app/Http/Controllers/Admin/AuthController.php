<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('admin.auth.login');
    }
    
    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        // Coba login dengan guard 'admin'
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login berhasil! Selamat datang di Admin Panel.');
        }
        
        // Jika login gagal
        return back()->withErrors([
            'error' => 'Username atau password salah!',
        ])->withInput($request->except('password'));
    }
    
    // Logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')
            ->with('success', 'Anda telah logout dari sistem.');
    }
}