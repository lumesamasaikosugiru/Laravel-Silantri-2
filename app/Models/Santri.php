<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Santri extends Model
{
    protected $fillable =
        [
            'nisn',
            'name',
            'gender',
            'date_birth',
            'address_street',
            'address_district',
            'address_city',
            'classroom_id',
            'status',
            'file_path',
        ];

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    //hasMANY

    public function santriSicks(): HasMany
    {
        return $this->hasMany(SantriSick::class, 'santri_id');
    }

    public function santriReqPermissions(): HasMany
    {
        return $this->hasMany(SantriPermission::class, 'santri_id');
    }

    public function violationDetails(): HasMany
    {
        return $this->hasMany(ViolationDetail::class, 'santri_id');
    }

    public function santris(): HasMany
    {
        return $this->hasMany(ReportMonthDetail::class, 'santri_id');
    }
}
