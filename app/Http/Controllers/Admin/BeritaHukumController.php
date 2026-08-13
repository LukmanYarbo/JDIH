<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeritaHukumController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\BeritaHukum::with('user');

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%")
                  ->orWhere('konten', 'like', "%{$request->search}%");
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // max 2MB
        ]);

        $data = $request->except('gambar');
        $data['slug'] = \Illuminate\Support\Str::slug($request->judul);
        $data['user_id'] = auth()->id();

        // Check if slug is unique
        $count = \App\Models\BeritaHukum::where('slug', $data['slug'])->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $data['gambar'] = 'uploads/news/' . $filename;
        }

        \App\Models\BeritaHukum::create($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita Hukum berhasil diterbitkan.');
    }

    public function edit(\App\Models\BeritaHukum $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, \App\Models\BeritaHukum $news)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('gambar');
        $data['slug'] = \Illuminate\Support\Str::slug($request->judul);

        // Check slug uniqueness
        $count = \App\Models\BeritaHukum::where('slug', $data['slug'])->where('id', '!=', $news->id)->count();
        if ($count > 0) {
            $data['slug'] = $data['slug'] . '-' . time();
        }

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($news->gambar && file_exists(public_path($news->gambar))) {
                @unlink(public_path($news->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/news'), $filename);
            $data['gambar'] = 'uploads/news/' . $filename;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')->with('success', 'Berita Hukum berhasil diperbarui.');
    }

    public function destroy(\App\Models\BeritaHukum $news)
    {
        // Delete image
        if ($news->gambar && file_exists(public_path($news->gambar))) {
            @unlink(public_path($news->gambar));
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita Hukum berhasil dihapus.');
    }
}
