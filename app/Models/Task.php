<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'state',
        'estimated_time',
        'time_spent',
        'start_planned_date',
        'end_planned_date',
        'supervisor_validated',
        'executor_validated',
        'id_executor',
    ];

    protected $visible = [
        'id_task',
        'title',
        'description',
        'state',
        'estimated_time',
        'time_spent',
        'start_planned_date',
        'end_planned_date',
        'supervisor_validated',
        'executor_validated',
        'id_executor',
        'id_yard',
    ];

    protected $casts = [
        'id_mission' => 'integer',
        'title' => 'string',
        'description' => 'string',
        'state' => 'string',
        'estimated_time' => 'string',
        'time_spent' => 'string',
        'start_planned_date' => 'date',
        'end_planned_date' => 'date',
        'supervisor_validated' => 'boolean',
        'executor_validated' => 'boolean',
        'id_executor' => 'integer',
        'id_yard' => 'integer',
    ];

    /**
     * Une mission appartient à un chantier.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function yard(): BelongsTo
    {
        return $this->belongsTo(Yard::class, 'id_yard', 'id_yard');
    }

    public function getEstimatedTimeAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        $times = explode(':', $value);
        return "$times[0]:$times[1]";
    }

    public function getTimeSpentAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        $times = explode(':', $value);
        return "$times[0]:$times[1]";
    }
}
