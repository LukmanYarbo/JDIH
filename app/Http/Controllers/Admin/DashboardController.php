<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDokumen = \App\Models\DokumenHukum::count();
        $totalBerita = \App\Models\BeritaHukum::count();
        $totalHits = \App\Models\DokumenHukum::sum('hits');
        $totalKategori = \App\Models\JenisDokumen::count();

        $dokumenPerKategori = \App\Models\JenisDokumen::withCount('dokumenHukums')->get();
        $recentDokumens = \App\Models\DokumenHukum::with('jenisDokumen')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalDokumen',
            'totalBerita',
            'totalHits',
            'totalKategori',
            'dokumenPerKategori',
            'recentDokumens'
        ));
    }
}
