<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Violation extends Model
{
    protected $fillable =
        [
            'code',
            'name',
            'category',
            'point',
        ];

    public function violationDetails(): HasMany
    {
        return $this->hasMany(ViolationDetail::class, 'violation_id');
    }
}
