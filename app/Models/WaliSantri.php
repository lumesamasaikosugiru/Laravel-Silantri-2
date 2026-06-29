<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WaliSantri extends Model
{
    protected $fillable = [
        'name',
        'phone',
    ];

    /**
     * Relasi many-to-many ke Santri lewat pivot wali_santri_santri
     */
    public function santris(): BelongsToMany
    {
        return $this->belongsToMany(Santri::class, 'wali_santri_santri', 'wali_santri_id', 'santri_id')
            ->withPivot('relation')
            ->withTimestamps();
    }

    /**
     * Helper: format nomor HP ke 628xx (konsisten dengan FonnteService)
     */
    public function getFormattedPhoneAttribute(): string
    {
        $phone = preg_replace('/\D/', '', $this->phone);

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }

        if (!str_starts_with($phone, '62')) {
            $phone = '62' . $phone;
        }

        return $phone;
    }
}