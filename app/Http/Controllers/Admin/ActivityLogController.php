<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the activity logs with filters.
     */
    public function index(Request $request): View
    {
        $logs = ActivityLog::with('user')
            ->filter($request)
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $users = User::select('id', 'name', 'email')->orderBy('name')->get();
        $modules = ActivityLog::whereNotNull('module')->distinct()->orderBy('module')->pluck('module');
        $actions = ActivityLog::select('action')->distinct()->orderBy('action')->pluck('action');

        // Statistics
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', today())->count();
        $activeUsers7Days = ActivityLog::whereNotNull('user_id')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->distinct('user_id')
            ->count('user_id');

        $topUser = ActivityLog::select('user_name', 'user_id')
            ->whereNotNull('user_name')
            ->groupBy('user_name', 'user_id')
            ->selectRaw('count(*) as total')
            ->orderByDesc('total')
            ->first();

        return view('admin.activity-logs.index', compact(
            'logs',
            'users',
            'modules',
            'actions',
            'totalLogs',
            'todayLogs',
            'activeUsers7Days',
            'topUser'
        ));
    }

    /**
     * Display the specified activity log detail (JSON for modal).
     */
    public function show(ActivityLog $activityLog): JsonResponse
    {
        $activityLog->load('user');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $activityLog->id,
                'user_name' => $activityLog->user_name,
                'user_email' => $activityLog->user_email,
                'user_role' => $activityLog->user_role,
                'action' => $activityLog->action,
                'action_label' => $activityLog->action_label,
                'action_badge_class' => $activityLog->action_badge_class,
                'module' => $activityLog->module,
                'description' => $activityLog->description,
                'subject_id' => $activityLog->subject_id,
                'subject_type' => $activityLog->subject_type,
                'properties' => $activityLog->properties,
                'ip_address' => $activityLog->ip_address,
                'user_agent' => $activityLog->user_agent,
                'created_at' => $activityLog->created_at->translatedFormat('d F Y H:i:s'),
                'diff_for_humans' => $activityLog->created_at->diffForHumans(),
            ]
        ]);
    }

    /**
     * Remove the specified log from storage.
     */
    public function destroy(ActivityLog $activityLog): RedirectResponse
    {
        $activityLog->delete();

        return redirect()->route('admin.activity-logs.index')
            ->with('success', 'Catatan log aktivitas berhasil dihapus.');
    }

    /**
     * Clear or prune activity logs.
     */
    public function clear(Request $request): RedirectResponse
    {
        $period = $request->input('period', 'all');

        $query = ActivityLog::query();

        if ($period === 'older_than_30_days') {
            $deleted = $query->where('created_at', '<', now()->subDays(30))->delete();
            $message = "Berhasil menghapus {$deleted} riwayat log yang berusia lebih dari 30 hari.";
        } elseif ($period === 'older_than_90_days') {
            $deleted = $query->where('created_at', '<', now()->subDays(90))->delete();
            $message = "Berhasil menghapus {$deleted} riwayat log yang berusia lebih dari 90 hari.";
        } else {
            $deleted = ActivityLog::truncate();
            $message = 'Semua riwayat log aktivitas berhasil dibersihkan.';
        }

        return redirect()->route('admin.activity-logs.index')
            ->with('success', $message);
    }
}
