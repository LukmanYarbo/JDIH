<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $categories = \App\Models\JenisDokumen::withCount('dokumenHukums')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:jenis_dokumens,kode',
            'deskripsi' => 'nullable|string',
        ]);

        \App\Models\JenisDokumen::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil ditambahkan.');
    }

    public function edit(\App\Models\JenisDokumen $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, \App\Models\JenisDokumen $category)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:jenis_dokumens,kode,' . $category->id,
            'deskripsi' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil diperbarui.');
    }

    public function destroy(\App\Models\JenisDokumen $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil dihapus.');
    }
}
