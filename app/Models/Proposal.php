<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;

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

    /**
     * Une proposition fait référence à un chantier.
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function yard(): HasOne
    {
        return $this->hasOne(Yard::class, 'id_yard', 'id_yard');
    }
}
