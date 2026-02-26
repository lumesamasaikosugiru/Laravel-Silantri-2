<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ViolationDetail extends Model
{
    protected $fillable =
        [
            'santri_id',
            'violation_id',
            'date',
            'description',
            'inputed_by',
        ];

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }

    public function violation(): BelongsTo
    {
        return $this->belongsTo(Violation::class, 'violation_id');
    }

    public function userInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inputed_by');
    }
}
