<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
   public function index()
{
    $settings = Setting::orderBy('group')->orderBy('order')->get();
    $groups = $settings->groupBy('group');
    
    return view('admin.settings.index', compact('groups'));
}
    
    public function update(Request $request)
    {
        $data = $request->except('_token', '_method');
        
        foreach ($data as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }
        
        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan berhasil diperbarui!');
    }
}