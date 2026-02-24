<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::with('tefa')
            ->adminTefa()
            ->latest()
            ->paginate(10);

        return view('admin.admin-management.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tefas = Tefa::where('is_active', true)->orderBy('name')->get();
        return view('admin.admin-management.create', compact('tefas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
            'tefa_id' => 'required|exists:tefas,id',
        ], [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'tefa_id.required' => 'TEFA harus dipilih',
            'tefa_id.exists' => 'TEFA tidak valid',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'admin-tefa';

        Admin::create($validated);

        return redirect()
            ->route('admin.admin-management.index')
            ->with('success', 'Admin TEFA berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $adminManagement)
    {
        $adminManagement->load('tefa');
        return view('admin.admin-management.show', compact('adminManagement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $adminManagement)
    {
        $tefas = Tefa::where('is_active', true)->orderBy('name')->get();
        return view('admin.admin-management.edit', compact('adminManagement', 'tefas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $adminManagement)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('admins')->ignore($adminManagement->id)],
            'email' => ['required', 'email', Rule::unique('admins')->ignore($adminManagement->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'tefa_id' => 'required|exists:tefas,id',
        ], [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah digunakan',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'tefa_id.required' => 'TEFA harus dipilih',
            'tefa_id.exists' => 'TEFA tidak valid',
        ]);

        // Jika password diisi, update password
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $adminManagement->update($validated);

        return redirect()
            ->route('admin.admin-management.index')
            ->with('success', 'Admin TEFA berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $adminManagement)
    {
        // Pastikan tidak menghapus super admin
        if ($adminManagement->isSuperAdmin()) {
            return redirect()
                ->route('admin.admin-management.index')
                ->with('error', 'Super Admin tidak dapat dihapus!');
        }

        $adminManagement->delete();

        return redirect()
            ->route('admin.admin-management.index')
            ->with('success', 'Admin TEFA berhasil dihapus!');
    }
}
