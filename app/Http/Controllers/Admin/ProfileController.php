<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the admin profile.
     */
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }

    /**
     * Update the admin profile.
     */
    public function update(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show the change password form.
     */
    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update the admin password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
            'new_password_confirmation' => 'required',
        ]);

        $admin = Auth::guard('admin')->user();

        // Check current password
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini salah!'])
                ->withInput();
        }

        // Update password
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('admin.profile.changePassword')
            ->with('success', 'Password berhasil diubah!');
    }
}