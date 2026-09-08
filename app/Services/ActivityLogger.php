<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ActivityLogger
{
    /**
     * Map model classes to human readable module names
     */
    protected static array $moduleMap = [
        'DokumenHukum' => 'Dokumen Hukum',
        'JenisDokumen' => 'Kategori Dokumen',
        'BeritaHukum' => 'Berita Hukum',
        'Agenda' => 'Agenda Kegiatan',
        'Ranperda' => 'Alur Ranperda',
        'Galeri' => 'Galeri & Video',
        'AnggotaDprd' => 'Anggota DPRD',
        'AlatKelengkapan' => 'Alat Kelengkapan',
        'KeanggotaanAlatKelengkapan' => 'Keanggotaan AKD',
        'TimPengelola' => 'Tim Pengelola',
        'Profil' => 'Profil Lembaga',
        'User' => 'Pengguna & Akun',
        'Role' => 'Role & Hak Akses',
        'Permission' => 'Permission',
        'Buletin' => 'Buletin JDIH',
    ];

    /**
     * Log a user activity
     */
    public static function log(
        string $action,
        string $description,
        ?Model $subject = null,
        ?string $module = null,
        array $properties = [],
        ?User $user = null
    ): ?ActivityLog {
        try {
            $currentUser = $user ?? Auth::user();

            // Determine module name
            if (!$module && $subject) {
                $baseClass = class_basename($subject);
                $module = self::$moduleMap[$baseClass] ?? $baseClass;
            }

            $userRole = null;
            if ($currentUser && method_exists($currentUser, 'getRoleNames')) {
                $userRole = $currentUser->getRoleNames()->implode(', ');
            }

            return ActivityLog::create([
                'user_id' => $currentUser?->id,
                'user_name' => $currentUser?->name ?? 'Tamu / Sistem',
                'user_email' => $currentUser?->email,
                'user_role' => $userRole ?: ($currentUser ? 'User' : 'Sistem'),
                'action' => strtolower($action),
                'module' => $module ?? 'Umum',
                'description' => $description,
                'subject_id' => $subject?->getKey(),
                'subject_type' => $subject ? get_class($subject) : null,
                'properties' => !empty($properties) ? $properties : null,
                'ip_address' => request()?->ip() ?? '127.0.0.1',
                'user_agent' => request()?->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Log to Laravel logger silently without failing the main request
            Log::error("Failed to write activity log: " . $e->getMessage(), [
                'action' => $action,
                'description' => $description,
                'exception' => $e,
            ]);
            return null;
        }
    }

    /**
     * Resolve model title / label for logs
     */
    public static function getModelTitle(Model $model): string
    {
        return $model->judul 
            ?? $model->nama 
            ?? $model->name 
            ?? $model->title 
            ?? ('#' . $model->getKey());
    }
}
