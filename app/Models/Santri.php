<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
            'description',
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

    public function reportMonthDetails(): HasMany
    {
        return $this->hasMany(ReportMonthDetail::class, 'santri_id');
    }

    //belongsMany
    public function waliSantris(): BelongsToMany
    {
        return $this->belongsToMany(WaliSantri::class, 'wali_santri_santri', 'santri_id', 'wali_santri_id')
            ->withPivot('relation')
            ->withTimestamps();
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }
}
