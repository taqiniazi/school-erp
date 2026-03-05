<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (static::getEventsToLog() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getEventsToLog()
    {
        return ['created', 'updated', 'deleted'];
    }

    protected function recordActivity($event)
    {
        // Don't log if not authenticated (except maybe login/logout if handled elsewhere)
        // But for model events, usually we want to know WHO did it.
        // If system action, user_id is null.
        
        $oldValues = null;
        $newValues = null;

        if ($event === 'updated') {
            $oldValues = $this->getOriginal();
            $newValues = $this->getChanges();
        } elseif ($event === 'created') {
            $newValues = $this->getAttributes();
        } elseif ($event === 'deleted') {
            $oldValues = $this->getAttributes();
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'event' => $event,
            'auditable_type' => get_class($this),
            'auditable_id' => $this->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'url' => request()->fullUrl(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
