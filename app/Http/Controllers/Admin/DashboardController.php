<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\AnggotaDprd;
use App\Models\BeritaHukum;
use App\Models\DokumenHukum;
use App\Models\JenisDokumen;
use App\Models\Ranperda;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Core Metrics
        $totalDokumen = DokumenHukum::count();
        $dokumenBerlaku = DokumenHukum::where('status', 'Berlaku')->count();
        $dokumenTidakBerlaku = DokumenHukum::where('status', '!=', 'Berlaku')->count();
        $totalBerita = BeritaHukum::count();
        $totalHits = (int) DokumenHukum::sum('hits');
        $totalDownloads = (int) DokumenHukum::sum('downloads');
        $totalKategori = JenisDokumen::count();
        $totalAgenda = Agenda::count();
        $totalRanperda = Ranperda::count();
        $totalAnggota = AnggotaDprd::count();
        $totalUsers = User::count();

        // Kategori & Distribusi Dokumen
        $dokumenPerKategori = JenisDokumen::withCount('dokumenHukums')
            ->orderBy('dokumen_hukums_count', 'desc')
            ->get();

        // Dokumen Terbaru
        $recentDokumens = DokumenHukum::with('jenisDokumen')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Activity Logs Terbaru (Safely fallback if empty)
        $recentActivities = collect();
        if (class_exists(ActivityLog::class)) {
            $recentActivities = ActivityLog::orderBy('created_at', 'desc')->take(6)->get();
        }

        // Tren Publikasi 6 Bulan Terakhir untuk Chart
        $chartLabels = [];
        $chartData = [];
        $indonesianMonths = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
            5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
            9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthNum = (int) $date->format('n');
            $yearNum = (int) $date->format('Y');
            $label = ($indonesianMonths[$monthNum] ?? $date->format('M')) . ' ' . $date->format('y');
            $chartLabels[] = $label;

            $count = DokumenHukum::whereYear('created_at', $yearNum)
                ->whereMonth('created_at', $monthNum)
                ->count();
            $chartData[] = $count;
        }

        // Distribusi Status Dokumen
        $statusCounts = [
            'Berlaku' => DokumenHukum::where('status', 'Berlaku')->count(),
            'Tidak Berlaku' => DokumenHukum::where('status', 'Tidak Berlaku')->count(),
            'Diubah' => DokumenHukum::where('status', 'Diubah')->count(),
            'Dicabut' => DokumenHukum::where('status', 'Dicabut')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalDokumen',
            'dokumenBerlaku',
            'dokumenTidakBerlaku',
            'totalBerita',
            'totalHits',
            'totalDownloads',
            'totalKategori',
            'totalAgenda',
            'totalRanperda',
            'totalAnggota',
            'totalUsers',
            'dokumenPerKategori',
            'recentDokumens',
            'recentActivities',
            'chartLabels',
            'chartData',
            'statusCounts'
        ));
    }
}

