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
            'diagnose',
            'description',
            'inputed_by',
        ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inputed_by');
    }
}
