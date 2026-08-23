<?php

namespace App\Http\Controllers;

use App\Models\AlatKelengkapan;
use App\Models\AnggotaDprd;
use App\Models\BeritaHukum;
use App\Models\DokumenHukum;
use App\Models\Galeri;
use App\Models\JenisDokumen;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function home()
    {
        $categories = JenisDokumen::withCount('dokumenHukums')->get();
        $totalDokumen = DokumenHukum::count();
        $recentDokumens = DokumenHukum::with('jenisDokumen')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $recentNews = BeritaHukum::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('portal.home', compact('categories', 'totalDokumen', 'recentDokumens', 'recentNews'));
    }

    public function search(Request $request)
    {
        $query = DokumenHukum::with('jenisDokumen');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('nomor', 'like', "%{$q}%")
                    ->orWhere('tahun', 'like', "%{$q}%")
                    ->orWhere('abstrak', 'like', "%{$q}%");
            });
        }

        if ($request->filled('jenis_dokumen_id')) {
            $query->where('jenis_dokumen_id', $request->jenis_dokumen_id);
        }

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->orderBy('tahun', 'desc')
            ->orderBy('nomor', 'desc')
            ->paginate(12);

        $categories = JenisDokumen::all();
        $years = DokumenHukum::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('portal.search', compact('documents', 'categories', 'years'));
    }

    public function showDocument(DokumenHukum $document)
    {
        // Increment hits counter
        $document->increment('hits');

        return view('portal.document-detail', compact('document'));
    }

    public function downloadDocument(DokumenHukum $document)
    {
        if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
            return response()->download(public_path($document->file_pdf));
        }

        return abort(404, 'File PDF tidak ditemukan.');
    }

    public function newsList(Request $request)
    {
        $query = BeritaHukum::orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%")
                ->orWhere('konten', 'like', "%{$request->q}%");
        }

        $news = $query->paginate(6);

        return view('portal.news-list', compact('news'));
    }

    public function newsDetail($slug)
    {
        $news = BeritaHukum::where('slug', $slug)->firstOrFail();
        $recentNews = BeritaHukum::where('id', '!=', $news->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('portal.news-detail', compact('news', 'recentNews'));
    }

    public function profile()
    {
        $anggotaDprd = AnggotaDprd::active()->ordered()->get();
        $pimpinanAk = AlatKelengkapan::active()
            ->where('tipe', 'pimpinan')
            ->with('keanggotaans.anggotaDprd')
            ->first();
        $alatKelengkapan = AlatKelengkapan::active()
            ->where('tipe', '!=', 'pimpinan')
            ->with('keanggotaans.anggotaDprd')
            ->ordered()
            ->get();

        return view('portal.profile', compact('anggotaDprd', 'pimpinanAk', 'alatKelengkapan'));
    }

    public function gallery(Request $request)
    {
        $query = Galeri::query();

        if ($request->filled('type')) {
            $query->where('tipe', $request->type);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%")
                ->orWhere('keterangan', 'like', "%{$request->q}%");
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('portal.gallery', compact('items'));
    }
}
