<?php

namespace App\Models;

class Availability extends BaseModel
{
    protected $fillable = [
        'start',
        'end',
    ];

    protected $visible = [
        'id_availability',
        'start',
        'end',
        'id_user',
    ];

    protected $casts = [
        'id_availability' => 'integer',
        'start' => 'datetime',
        'end' => 'datetime',
        'id_user' => 'integer',
    ];
}
