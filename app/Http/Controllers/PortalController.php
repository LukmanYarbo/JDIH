<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AlatKelengkapan;
use App\Models\AnggotaDprd;
use App\Models\BeritaHukum;
use App\Models\Buletin;
use App\Models\DokumenHukum;
use App\Models\Galeri;
use App\Models\IkmVote;
use App\Models\JenisDokumen;
use App\Models\Profil;
use App\Models\Ranperda;
use App\Models\TimPengelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PortalController extends Controller
{
    public function home()
    {
        // 1. Agenda Ticker Items (Diurutkan dari tanggal terbaru)
        $tickerAgendas = Agenda::where('is_active_ticker', true)
            ->orderBy('waktu_mulai', 'desc')
            ->take(10)
            ->get();

        // 2. Statistics Quick Counters for 4 Main Types
        $countMonografi = DokumenHukum::where('tipe_dokumen', 'Monografi Hukum')->count();
        $countArtikel = DokumenHukum::where('tipe_dokumen', 'Artikel Hukum')->count();
        $countPeraturan = DokumenHukum::where('tipe_dokumen', 'Produk Hukum')->count();
        $countPutusan = DokumenHukum::where('tipe_dokumen', 'Putusan Pengadilan')->count();
        $totalDokumen = DokumenHukum::count();

        // 3. Document Categories for search dropdown
        $categories = JenisDokumen::withCount('dokumenHukums')->orderBy('urutan')->get();

        // 4. Latest Documents
        $recentDokumens = DokumenHukum::with('jenisDokumen')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // 5. Popular Documents (for footer / sidebar)
        $popularDokumens = DokumenHukum::with('jenisDokumen')
            ->orderBy('hits', 'desc')
            ->take(6)
            ->get();

        // 6. Latest News
        $recentNews = BeritaHukum::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // 7. Latest Ranperda (for footer & tracker summary)
        $recentRanperda = Ranperda::orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get();

        // 8. Gallery / Videos for homepage
        $recentVideos = Galeri::where('tipe', 'video')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        // 9. Profil data
        $profil = Profil::first();

        // 10. Years for search
        $years = DokumenHukum::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('portal.home', compact(
            'tickerAgendas',
            'countMonografi',
            'countArtikel',
            'countPeraturan',
            'countPutusan',
            'totalDokumen',
            'categories',
            'recentDokumens',
            'popularDokumens',
            'recentNews',
            'recentRanperda',
            'recentVideos',
            'profil',
            'years'
        ));
    }

    public function search(Request $request)
    {
        $query = DokumenHukum::with('jenisDokumen');

        // Kata Kunci / Judul
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('nomor', 'like', "%{$q}%")
                    ->orWhere('tahun', 'like', "%{$q}%")
                    ->orWhere('subjek', 'like', "%{$q}%")
                    ->orWhere('abstrak', 'like', "%{$q}%");
            });
        }

        // Tipe Dokumen Filter
        if ($request->filled('tipe_dokumen')) {
            $query->where('tipe_dokumen', $request->tipe_dokumen);
        }

        // Jenis Dokumen Filter
        if ($request->filled('jenis_dokumen_id')) {
            $query->where('jenis_dokumen_id', $request->jenis_dokumen_id);
        }

        // Nomor Filter
        if ($request->filled('nomor')) {
            $query->where('nomor', 'like', "%{$request->nomor}%");
        }

        // Tahun Filter
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('urutkan', 'terbaru');
        if ($sort === 'terlama') {
            $query->orderBy('tahun', 'asc')->orderBy('nomor', 'asc');
        } elseif ($sort === 'populer') {
            $query->orderBy('hits', 'desc');
        } elseif ($sort === 'unduhan') {
            $query->orderBy('downloads', 'desc');
        } else {
            $query->orderBy('tahun', 'desc')->orderBy('id', 'desc');
        }

        $documents = $query->paginate(12)->withQueryString();

        $categories = JenisDokumen::orderBy('urutan')->get();
        $years = DokumenHukum::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('portal.search', compact('documents', 'categories', 'years'));
    }

    public function getJenisDokumenByTipe(Request $request)
    {
        $tipe = $request->get('tipe');
        $query = JenisDokumen::query();
        if ($tipe) {
            $query->where('tipe_dokumen', $tipe);
        }
        $categories = $query->orderBy('urutan')->get();

        return response()->json($categories);
    }

    public function showDocument(DokumenHukum $document)
    {
        $document->increment('hits');

        $relatedDocuments = DokumenHukum::where('jenis_dokumen_id', $document->jenis_dokumen_id)
            ->where('id', '!=', $document->id)
            ->orderBy('tahun', 'desc')
            ->take(4)
            ->get();

        return view('portal.document-detail', compact('document', 'relatedDocuments'));
    }

    public function previewDocument(DokumenHukum $document)
    {
        $document->increment('hits');

        return view('portal.partials.modal-preview', compact('document'));
    }

    public function previewAbstract(DokumenHukum $document)
    {
        return view('portal.partials.modal-abstract', compact('document'));
    }

    public function downloadDocument(DokumenHukum $document)
    {
        $document->increment('downloads');

        if ($document->file_pdf && file_exists(public_path($document->file_pdf))) {
            return response()->download(public_path($document->file_pdf));
        }

        // Fallback dummy file response or back with notice
        return redirect()->back()->with('info', 'File dokumen dalam proses digitalisasi.');
    }

    public function about($slug = 'visi-misi')
    {
        $profil = Profil::first();
        $anggotaDprd = AnggotaDprd::active()->ordered()->get();
        $timPengelola = TimPengelola::active()->orderedHierarchy()->get();
        
        $pembinaList = $timPengelola->where('kategori_jabatan', 'pembina');
        $penanggungJawabList = $timPengelola->where('kategori_jabatan', 'penanggung_jawab');
        $ketuaList = $timPengelola->where('kategori_jabatan', 'ketua');
        $wakilKetuaList = $timPengelola->where('kategori_jabatan', 'wakil_ketua');
        $sekretarisList = $timPengelola->where('kategori_jabatan', 'sekretaris');
        $bidangGrouped = $timPengelola->where('kategori_jabatan', 'bidang')->groupBy(function($item) {
            return $item->divisi ?: 'Bidang Pengolahan & Pengelolaan JDIH';
        });

        $pimpinanAk = AlatKelengkapan::active()
            ->where('tipe', 'pimpinan')
            ->with('keanggotaans.anggotaDprd')
            ->first();
        $alatKelengkapan = AlatKelengkapan::active()
            ->where('tipe', '!=', 'pimpinan')
            ->with('keanggotaans.anggotaDprd')
            ->ordered()
            ->get();

        return view('portal.about', compact(
            'slug',
            'profil',
            'anggotaDprd',
            'timPengelola',
            'pembinaList',
            'penanggungJawabList',
            'ketuaList',
            'wakilKetuaList',
            'sekretarisList',
            'bidangGrouped',
            'pimpinanAk',
            'alatKelengkapan'
        ));
    }

    public function ranperda(Request $request)
    {
        $query = Ranperda::query();

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%");
        }

        $ranperdas = $query->orderBy('tahun', 'desc')->orderBy('tahap_terakhir', 'desc')->paginate(10);
        $years = Ranperda::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $tahapanLabels = Ranperda::getTahapanLabels();

        return view('portal.ranperda', compact('ranperdas', 'years', 'tahapanLabels'));
    }

    public function buletin(Request $request)
    {
        $query = Buletin::orderBy('tahun', 'desc')->orderBy('id', 'desc');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $buletins = $query->paginate(8);
        $years = Buletin::select('tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');

        return view('portal.buletin', compact('buletins', 'years'));
    }

    public function downloadBuletin(Buletin $buletin)
    {
        $buletin->increment('downloads');

        if ($buletin->file_pdf && file_exists(public_path($buletin->file_pdf))) {
            return response()->download(public_path($buletin->file_pdf));
        }

        return redirect()->back()->with('info', 'File buletin sedang dipersiapkan.');
    }

    public function statistics()
    {
        // 1. Dokumen per Tipe
        $byType = DokumenHukum::select('tipe_dokumen', DB::raw('count(*) as total'))
            ->groupBy('tipe_dokumen')
            ->get();

        // 2. Dokumen per Jenis
        $byCategory = JenisDokumen::withCount('dokumenHukums')
            ->having('dokumen_hukums_count', '>', 0)
            ->orderBy('dokumen_hukums_count', 'desc')
            ->take(10)
            ->get();

        // 3. Dokumen per Tahun
        $byYear = DokumenHukum::select('tahun', DB::raw('count(*) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->take(7)
            ->get()
            ->reverse();

        // 4. Dokumen per Status
        $byStatus = DokumenHukum::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $totalDokumen = DokumenHukum::count();
        $totalHits = DokumenHukum::sum('hits');
        $totalDownloads = DokumenHukum::sum('downloads');

        return view('portal.statistics', compact('byType', 'byCategory', 'byYear', 'byStatus', 'totalDokumen', 'totalHits', 'totalDownloads'));
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

    public function gallery(Request $request)
    {
        $query = Galeri::query();

        if ($request->filled('type') && in_array($request->type, ['foto', 'video'])) {
            $query->where('tipe', $request->type);
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul', 'like', "%{$request->q}%")
                  ->orWhere('keterangan', 'like', "%{$request->q}%");
            });
        }

        $items = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('portal.gallery', compact('items'));
    }

    public function video(Request $request)
    {
        $query = Galeri::where('tipe', 'video');
        if ($request->filled('q')) {
            $query->where('judul', 'like', "%{$request->q}%");
        }
        $videos = $query->orderBy('created_at', 'desc')->paginate(9);

        return view('portal.video', compact('videos'));
    }

    public function agenda(Request $request)
    {
        $query = Agenda::orderBy('waktu_mulai', 'desc');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $agendas = $query->paginate(10);

        return view('portal.agenda', compact('agendas'));
    }

    public function contact()
    {
        $profil = Profil::first();
        return view('portal.contact', compact('profil'));
    }

    public function voteIkm(Request $request)
    {
        $request->validate([
            'jawaban' => 'required|string|in:Sangat Informatif,Informatif,Biasa Saja,Kurang Informatif',
        ]);

        IkmVote::create([
            'jawaban' => $request->jawaban,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Terima kasih atas partisipasi dan penilaian Anda.',
        ]);
    }

    public function getIkmResult()
    {
        $votes = IkmVote::select('jawaban', DB::raw('count(*) as total'))
            ->groupBy('jawaban')
            ->pluck('total', 'jawaban')
            ->toArray();

        $labels = ['Sangat Informatif', 'Informatif', 'Biasa Saja', 'Kurang Informatif'];
        $data = [];
        $total = 0;

        foreach ($labels as $label) {
            $val = $votes[$label] ?? 0;
            $data[] = $val;
            $total += $val;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'total' => $total,
        ]);
    }
}
