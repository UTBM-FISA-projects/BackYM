<?php

namespace App\Models;

class Task extends BaseModel
{
    protected $fillable = [
        'title',
        'description',
        'state',
        'estimated_time',
        'start_planned_date',
        'end_planned_date',
    ];

    protected $visible = [
        'id_mission',
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
        'estimated_time' => 'datetime:H:i',
        'time_spent' => 'datetime:H:i',
        'start_planned_date' => 'date',
        'end_planned_date' => 'date',
        'supervisor_validated' => 'boolean',
        'executor_validated' => 'boolean',
        'id_executor' => 'integer',
        'id_yard' => 'integer',
    ];
}
