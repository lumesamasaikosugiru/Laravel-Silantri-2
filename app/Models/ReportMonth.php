<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReportMonth extends Model
{
    protected $fillable =
        [
            'month',
            'year',
            'created_by',
            'status',
            'note_validation',
            'validated_by',
            'validated_date',
        ];

    public function reportMonthInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reportMonthValidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    public function reportMonthSummary(): HasOne
    {
        return $this->hasOne(ReportMonthSummary::class, 'report_month_id');
    }

    public function reportMonthItems(): HasMany
    {
        return $this->hasMany(ReportMonthDetail::class, 'report_month_id');
    }

    public function getMonthNameAttribute()
    {
        return Carbon::create()->month($this->month)->translatedFormat('F');
    }
}
