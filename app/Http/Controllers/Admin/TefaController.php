<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tefa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TefaController extends Controller
{
    public function index()
    {
        $tefas = Tefa::orderBy('order')->get();
        return view('admin.tefas.index', compact('tefas'));
    }

    public function create()
    {
        return view('admin.tefas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:tefas,code',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        Tefa::create($data);

        return redirect()->route('admin.tefas.index')
            ->with('success', 'TEFA berhasil ditambahkan');
    }

    public function show($id)
    {
        $tefa = Tefa::findOrFail($id);
        return view('admin.tefas.show', compact('tefa'));
    }

    public function edit($id)
    {
        $tefa = Tefa::findOrFail($id);
        return view('admin.tefas.edit', compact('tefa'));
    }

    public function update(Request $request, $id)
    {
        $tefa = Tefa::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:tefas,code,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
            'services_json' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        $tefa->update($data);

        return redirect()->route('admin.tefas.index')
            ->with('success', 'TEFA berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tefa = Tefa::findOrFail($id);
        $tefa->delete();
        
        return redirect()->route('admin.tefas.index')
            ->with('success', 'TEFA berhasil dihapus');
    }
}