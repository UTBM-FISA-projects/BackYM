<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Yard extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'archived',
        'id_supervisor',
    ];

    protected $visible = [
        'id_yard',
        'name',
        'description',
        'deadline',
        'archived',
        'supervisor',
        'project_owner',
        'total_tasks',
        'done_tasks',
        'total_estimated_time',
        'total_time_spent',
    ];

    protected $casts = [
        'id_yard' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'deadline' => 'datetime',
        'archived' => 'boolean',
        'id_project_owner' => 'integer',
        'id_supervisor' => 'integer',
    ];

    protected $with = [
        'supervisor',
        'project_owner',
    ];

    protected $appends = [
        'total_tasks',
        'done_tasks',
        'total_estimated_time',
        'total_time_spent',
    ];

    /**
     * Récupère le nombre de missions total sur le chantier.
     * @return int
     */
    public function getTotalTasksAttribute(): int
    {
        return $this->tasks()->count();
    }

    /**
     * Récupère le nombre de missions éffectuées sur le chantier.
     * @return int
     */
    public function getDoneTasksAttribute(): int
    {
        return $this->tasks()->where('state', 'done')->count();
    }

    /**
     * Récupère le temps total estimé des missions.
     * @return string
     */
    public function getTotalEstimatedTimeAttribute(): string
    {
        $total = $this->tasks()->sum(DB::raw('TIME_TO_SEC(estimated_time)'));
        $h = floor($total / 3600);
        $m = $total / 60 % 60;
        return sprintf("%-2d:%-2d", $h, $m);
    }

    /**
     * Récupère le temps passé total des missions.
     * @return string
     */
    public function getTotalTimeSpentAttribute(): string
    {
        $total = $this->tasks()->sum(DB::raw('TIME_TO_SEC(time_spent)'));
        $h = floor($total / 3600);
        $m = $total / 60 % 60;
        return sprintf("%-2d:%-2d", $h, $m);
    }

    /**
     * Un chantier possède des missions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(
            Task::class,
            'id_yard',
            'id_yard'
        );
    }

    /**
     * Un chantier possède un maitre d'oeuvre (demandeur)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project_owner(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id_user',
            'id_project_owner'
        );
    }

    /**
     * Un chantier possède un conducteur de travaux
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supervisor(): HasOne
    {
        return $this->hasOne(
            User::class,
            'id_user',
            'id_supervisor'
        );
    }
}
