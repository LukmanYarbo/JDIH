<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Galeri::query();

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|string|in:foto,video',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120', // max 5MB
            'video_url' => 'nullable|url',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except('file_path');

        if ($request->tipe === 'foto') {
            if ($request->hasFile('file_path')) {
                $file = $request->file('file_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/gallery'), $filename);
                $data['file_path'] = 'uploads/gallery/' . $filename;
            } else {
                return back()->withErrors(['file_path' => 'File foto wajib diunggah untuk tipe Foto.'])->withInput();
            }
        } else {
            if (!$request->filled('video_url')) {
                return back()->withErrors(['video_url' => 'Link video wajib diisi untuk tipe Video.'])->withInput();
            }
        }

        \App\Models\Galeri::create($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    public function edit(\App\Models\Galeri$gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, \App\Models\Galeri$gallery)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required|string|in:foto,video',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|url',
            'keterangan' => 'nullable|string',
        ]);

        $data = $request->except('file_path');

        if ($request->tipe === 'foto') {
            if ($request->hasFile('file_path')) {
                // Delete old file if exists
                if ($gallery->file_path && file_exists(public_path($gallery->file_path))) {
                    @unlink(public_path($gallery->file_path));
                }

                $file = $request->file('file_path');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/gallery'), $filename);
                $data['file_path'] = 'uploads/gallery/' . $filename;
                $data['video_url'] = null; // Clear video URL if switching to photo
            } else {
                $data['file_path'] = $gallery->file_path;
                $data['video_url'] = null;
            }
        } else {
            // If switching to video, delete old photo file
            if ($gallery->file_path && file_exists(public_path($gallery->file_path))) {
                @unlink(public_path($gallery->file_path));
            }
            $data['file_path'] = null;
            if (!$request->filled('video_url')) {
                return back()->withErrors(['video_url' => 'Link video wajib diisi untuk tipe Video.'])->withInput();
            }
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    public function destroy(\App\Models\Galeri$gallery)
    {
        if ($gallery->file_path && file_exists(public_path($gallery->file_path))) {
            @unlink(public_path($gallery->file_path));
        }

        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
