<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class JenisDokumenController extends Controller
{
    public function index()
    {
        $categories = JenisDokumen::withCount('dokumenHukums')->orderBy('tipe_dokumen')->orderBy('urutan')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_dokumen' => 'required|string|in:Produk Hukum,Monografi Hukum,Artikel Hukum,Putusan Pengadilan',
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:jenis_dokumens,kode',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        JenisDokumen::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil ditambahkan.');
    }

    public function edit(JenisDokumen $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, JenisDokumen $category)
    {
        $request->validate([
            'tipe_dokumen' => 'required|string|in:Produk Hukum,Monografi Hukum,Artikel Hukum,Putusan Pengadilan',
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:50|unique:jenis_dokumens,kode,' . $category->id,
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer',
        ]);

        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil diperbarui.');
    }

    public function destroy(JenisDokumen $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori Dokumen berhasil dihapus.');
    }
}
