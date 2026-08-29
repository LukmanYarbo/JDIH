<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenHukum;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class DokumenHukumController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenHukum::with('jenisDokumen');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('nomor', 'like', "%{$search}%")
                    ->orWhere('tahun', 'like', "%{$search}%")
                    ->orWhere('subjek', 'like', "%{$search}%");
            });
        }

        if ($request->filled('tipe_dokumen')) {
            $query->where('tipe_dokumen', $request->tipe_dokumen);
        }

        if ($request->filled('jenis_dokumen_id')) {
            $query->where('jenis_dokumen_id', $request->jenis_dokumen_id);
        }

        $documents = $query->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        $categories = JenisDokumen::orderBy('urutan')->get();

        return view('admin.documents.index', compact('documents', 'categories'));
    }

    public function create()
    {
        $categories = JenisDokumen::orderBy('urutan')->get();
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
            'tanggal_pengundangan' => 'nullable|date',
            'penandatangan' => 'nullable|string',
            'pemrakarsa' => 'nullable|string',
            'tempat_terbit' => 'nullable|string',
            'sumber' => 'nullable|string',
            'subjek' => 'nullable|string',
            'bidang_hukum' => 'nullable|string',
            'bahasa' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:30720', // max 30MB
            'abstrak' => 'nullable|string',
            'status' => 'required|string|in:Berlaku,Mengubah,Diubah,Dicabut,Mencabut,Tidak Berlaku',
            'keterangan_status' => 'nullable|string',
        ]);

        $data = $request->except(['file_pdf', 'file_abstrak', 'file_lampiran']);

        // Set tipe_dokumen automatically from selected category if not provided
        $category = JenisDokumen::find($request->jenis_dokumen_id);
        $data['tipe_dokumen'] = $category ? $category->tipe_dokumen : 'Produk Hukum';

        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $sizeInBytes = $file->getSize();
            $data['file_size'] = round($sizeInBytes / (1024 * 1024), 2) . ' MB';

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $data['file_pdf'] = 'uploads/documents/' . $filename;
        }

        DokumenHukum::create($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil ditambahkan.');
    }

    public function edit(DokumenHukum $document)
    {
        $categories = JenisDokumen::orderBy('urutan')->get();
        return view('admin.documents.edit', compact('document', 'categories'));
    }

    public function update(Request $request, DokumenHukum $document)
    {
        $request->validate([
            'jenis_dokumen_id' => 'required|exists:jenis_dokumens,id',
            'judul' => 'required|string',
            'nomor' => 'required|string',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'tanggal_ditetapkan' => 'nullable|date',
            'tanggal_pengundangan' => 'nullable|date',
            'penandatangan' => 'nullable|string',
            'pemrakarsa' => 'nullable|string',
            'tempat_terbit' => 'nullable|string',
            'sumber' => 'nullable|string',
            'subjek' => 'nullable|string',
            'bidang_hukum' => 'nullable|string',
            'bahasa' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:30720', // max 30MB
            'abstrak' => 'nullable|string',
            'status' => 'required|string|in:Berlaku,Mengubah,Diubah,Dicabut,Mencabut,Tidak Berlaku',
            'keterangan_status' => 'nullable|string',
        ]);

        $data = $request->except(['file_pdf', 'file_abstrak', 'file_lampiran']);

        $category = JenisDokumen::find($request->jenis_dokumen_id);
        $data['tipe_dokumen'] = $category ? $category->tipe_dokumen : 'Produk Hukum';

        if ($request->hasFile('file_pdf')) {
            if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
                @unlink(public_path($document->file_pdf));
            }

            $file = $request->file('file_pdf');
            $sizeInBytes = $file->getSize();
            $data['file_size'] = round($sizeInBytes / (1024 * 1024), 2) . ' MB';

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $data['file_pdf'] = 'uploads/documents/' . $filename;
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil diperbarui.');
    }

    public function destroy(DokumenHukum $document)
    {
        if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
            @unlink(public_path($document->file_pdf));
        }

        $document->delete();
        return redirect()->route('admin.documents.index')->with('success', 'Dokumen Hukum berhasil dihapus.');
    }
}
