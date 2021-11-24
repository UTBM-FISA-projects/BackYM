<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'email',
        'phone',
    ];

    protected $visible = [
        'id_user',
        'name',
        'description',
        'type',
        'email',
        'phone',
        'id_enterprise',
        'siret',
    ];

    protected $casts = [
        'id_user' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'type' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'token' => 'string',
        'token_gentime' => 'datetime',
        'id_enterprise' => 'integer',
        'siret' => 'integer',
    ];

    /**
     * Le nombre de chantiers en cours.
     * @return int
     */
    public function getYardCountAttribute(): int
    {
        return $this->yards()->where('archived', 'is not', true)->count();
    }

    /**
     * Un superviseur a une entreprise.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function enterprise(): HasOne
    {
        return $this->hasOne(User::class, 'id_user', 'id_enterprise');
    }

    /**
     * Les entreprises ont des disponibilitées.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function availabilities(): HasMany
    {
        return $this->hasMany(
            Availability::class,
            'id_user',
            'id_user'
        );
    }

    /**
     * Un utilisateur a des notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(
            Notification::class,
            'id_recipient',
            'id_user',
        );
    }

    /**
     * Un utilisateur a des chantiers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function yards(): HasMany
    {
        $fk = $this->attributes['type'] == 'project_owner' ? 'id_project_owner' : 'id_supervisor';

        return $this->hasMany(
            Yard::class,
            $fk,
            'id_user'
        );
    }
}
