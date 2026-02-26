<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMonthSummary extends Model
{
    protected $fillable =
        [
            'report_month_id',
            'total_sicks',
            'total_violations',
            'total_permissions',
            'total_points',
        ];

    public function reportMonth(): BelongsTo
    {
        return $this->belongsTo(ReportMonth::class, 'report_month_id');
    }
}
