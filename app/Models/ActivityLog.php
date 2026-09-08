<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'user_role',
        'action',
        'module',
        'description',
        'subject_id',
        'subject_type',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'properties' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope for advanced query filtering
     */
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('user_email', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }

    /**
     * Badge CSS class based on action
     */
    public function getActionBadgeClassAttribute(): string
    {
        return match (strtolower($this->action)) {
            'create', 'tambah' => 'bg-success text-white',
            'update', 'ubah', 'edit' => 'bg-warning text-dark',
            'delete', 'hapus' => 'bg-danger text-white',
            'login' => 'bg-info text-dark',
            'logout' => 'bg-secondary text-white',
            'download', 'unduh' => 'bg-primary text-white',
            default => 'bg-light text-dark border',
        };
    }

    /**
     * Indonesian action label
     */
    public function getActionLabelAttribute(): string
    {
        return match (strtolower($this->action)) {
            'create' => 'Tambah Data',
            'update' => 'Perbarui Data',
            'delete' => 'Hapus Data',
            'login' => 'Login Masuk',
            'logout' => 'Logout Keluar',
            'download' => 'Unduh Dokumen',
            default => ucfirst($this->action),
        };
    }

    /**
     * Action Icon
     */
    public function getActionIconAttribute(): string
    {
        return match (strtolower($this->action)) {
            'create' => 'bi-plus-circle-fill text-success',
            'update' => 'bi-pencil-square text-warning',
            'delete' => 'bi-trash3-fill text-danger',
            'login' => 'bi-box-arrow-in-right text-info',
            'logout' => 'bi-box-arrow-right text-secondary',
            'download' => 'bi-download text-primary',
            default => 'bi-activity text-secondary',
        };
    }
}
