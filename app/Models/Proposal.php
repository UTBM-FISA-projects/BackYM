<?php

namespace App\Models;

class Proposal extends BaseModel
{
    protected $fillable = [
        'accepted',
    ];

    protected $visible = [
        'id_proposal',
        'id_yard',
        'id_recipient',
        'accepted',
    ];

    protected $casts = [
        'id_proposal' => 'integer',
        'id_yard' => 'integer',
        'id_recipient' => 'integer',
        'accepted' => 'boolean',
    ];
}
