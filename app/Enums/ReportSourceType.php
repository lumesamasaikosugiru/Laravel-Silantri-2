<?php

namespace App\Enums;

enum ReportSourceType: string
{
    case Sick = 'santri_sicks';
    case Permission = 'santri_permissions';
    case Violation = 'violation_details';

    public function label(): string
    {
        return match ($this) {
            self::Sick => 'Sakit',
            self::Permission => 'Perizinan',
            self::Violation => 'Pelanggaran',
        };
    }
}