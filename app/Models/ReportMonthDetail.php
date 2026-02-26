<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMonthDetail extends Model
{
    protected $fillable =
        [
            'report_month_id',
            'santri_id',
            'type',
            'source_table',
            'source_id',
            'date',
            'summary_text',
        ];

    public function reportMonth(): BelongsTo
    {
        return $this->belongsTo(ReportMonth::class, 'report_month_id');

    }
}
