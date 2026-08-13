<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokumenHukumController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\DokumenHukum::with('jenisDokumen');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('nomor', 'like', "%{$search}%")
                  ->orWhere('tahun', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis_dokumen_id')) {
            $query->where('jenis_dokumen_id', $request->jenis_dokumen_id);
        }

        $documents = $query->orderBy('tahun', 'desc')
            ->orderBy('nomor', 'desc')
            ->paginate(10);

        $categories = \App\Models\JenisDokumen::all();

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = \App\Models\JenisDokumen::all();
        return view('admin.documents.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumens,id',
            'judul' => 'required|string',
            'nomor' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tanggal_ditetapkan' => 'nullable|date',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480', // max 20MB
            'abstrak' => 'nullable|string',
            'status' => 'required|string|in:Berlaku,Tidak Berlaku,Diubah,Mencabut',
        ]);

        $data = $request->except('file_pdf');

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $data['file_pdf'] = 'uploads/documents/' . $filename;
        }

        \App\Models\DokumenHukum::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil ditambahkan.');
    }

    public function edit(\App\Models\DokumenHukum $document)
    {
        $categories = \App\Models\JenisDokumen::all();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, \App\Models\DokumenHukum $document)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumens,id',
            'judul' => 'required|string',
            'nomor' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tanggal_ditetapkan' => 'nullable|date',
            'file_pdf' => 'nullable|file|mimes:pdf|max:20480', // max 20MB
            'abstrak' => 'nullable|string',
            'status' => 'required|string|in:Berlaku,Tidak Berlaku,Diubah,Mencabut',
        ]);

        $data = $request->except('file_pdf');

        if ($request->hasFile('file_pdf')) {
            // Delete old file
            if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
                @unlink(public_path($document->file_pdf));
            }

            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $data['file_pdf'] = 'uploads/documents/' . $filename;
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil diperbarui.');
    }

    public function destroy(\App\Models\DokumenHukum $document)
    {
        // Delete file
        if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
            @unlink(public_path($document->file_pdf));
        }

        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil dihapus.');
    }
}
