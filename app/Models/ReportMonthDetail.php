<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function PHPUnit\Framework\returnArgument;

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

    public function santri(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
    public function getSantriNameAttribute(): string
    {
        return $this->santri->name;
    }
}
