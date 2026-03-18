<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SantriSick extends Model
{
    protected $fillable =
        [
            'santri_id',
            'date_sick',
            'date_recovered',
            'confirmed_by',
            'diagnose',
            'description',
            'inputed_by',
        ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function confirmed_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inputed_by');
    }
}
