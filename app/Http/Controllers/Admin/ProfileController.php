<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Tefa;
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
        $adminTefa = null;

        if ($admin && $admin->isAdminTefa() && $admin->tefa_id) {
            $adminTefa = Tefa::find($admin->tefa_id);
        }

        return view('admin.profile.edit', compact('admin', 'adminTefa'));
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
            'tefa_contact_phone' => 'nullable|string|max:50',
            'tefa_contact_email' => 'nullable|email|max:255',
            'tefa_whatsapp_number' => 'nullable|string|max:30',
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

        // Simpan pengaturan kontak halaman jurusan khusus admin TEFA.
        if ($admin->isAdminTefa() && $admin->tefa_id) {
            $tefa = Tefa::find($admin->tefa_id);

            if ($tefa) {
                $rawWhatsapp = (string) $request->input('tefa_whatsapp_number', '');
                $normalizedWhatsapp = preg_replace('/\D+/', '', $rawWhatsapp);

                // Normalisasi: 08xx -> 628xx untuk link wa.me
                if ($normalizedWhatsapp !== '' && str_starts_with($normalizedWhatsapp, '0')) {
                    $normalizedWhatsapp = '62' . substr($normalizedWhatsapp, 1);
                }

                $tefa->update([
                    'contact_number' => $request->input('tefa_contact_phone'),
                    'contact_email' => $request->input('tefa_contact_email'),
                    'whatsapp_url' => $normalizedWhatsapp !== '' ? 'https://wa.me/' . $normalizedWhatsapp : null,
                ]);
            }
        }

        return redirect()->route($this->getRoutePrefix() . '.profile.edit')
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

        return redirect()->route($this->getRoutePrefix() . '.profile.change-password')
            ->with('success', 'Password berhasil diubah!');
    }
}
