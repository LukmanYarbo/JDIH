<?php

namespace App\Traits;

use App\Services\ActivityLogger;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    /**
     * Boot the trait and hook into Eloquent events
     */
    public static function bootLogsActivity(): void
    {
        static::created(function (Model $model) {
            if (!auth()->check()) {
                return;
            }

            $title = ActivityLogger::getModelTitle($model);
            $moduleName = class_basename($model);
            $cleanAttributes = self::filterSensitiveAttributes($model->getAttributes());

            ActivityLogger::log(
                action: 'create',
                description: "Menambahkan data {$moduleName}: \"{$title}\"",
                subject: $model,
                properties: [
                    'attributes' => $cleanAttributes,
                ]
            );
        });

        static::updated(function (Model $model) {
            if (!auth()->check()) {
                return;
            }

            $changes = $model->getChanges();
            unset($changes['updated_at']);

            if (empty($changes)) {
                return;
            }

            $old = [];
            $new = [];
            foreach (array_keys($changes) as $key) {
                if (in_array($key, ['password', 'remember_token'])) {
                    $old[$key] = '******';
                    $new[$key] = '******';
                } else {
                    $old[$key] = $model->getOriginal($key);
                    $new[$key] = $model->getAttribute($key);
                }
            }

            $title = ActivityLogger::getModelTitle($model);
            $moduleName = class_basename($model);

            ActivityLogger::log(
                action: 'update',
                description: "Memperbarui data {$moduleName}: \"{$title}\"",
                subject: $model,
                properties: [
                    'old' => $old,
                    'new' => $new,
                ]
            );
        });

        static::deleted(function (Model $model) {
            if (!auth()->check()) {
                return;
            }

            $title = ActivityLogger::getModelTitle($model);
            $moduleName = class_basename($model);
            $cleanAttributes = self::filterSensitiveAttributes($model->getOriginal());

            ActivityLogger::log(
                action: 'delete',
                description: "Menghapus data {$moduleName}: \"{$title}\"",
                subject: $model,
                properties: [
                    'attributes' => $cleanAttributes,
                ]
            );
        });
    }

    /**
     * Strip sensitive keys from properties
     */
    protected static function filterSensitiveAttributes(array $attributes): array
    {
        $sensitive = ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'];
        foreach ($sensitive as $key) {
            if (isset($attributes[$key])) {
                $attributes[$key] = '******';
            }
        }
        return $attributes;
    }
}
