<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
