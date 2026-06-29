<?php

namespace App\Events;

use App\Models\SantriPermission;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SantriPermissionStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public readonly SantriPermission $permission,
        public readonly string $triggerBy, // 'created' | 'approved' | 'rejected'
    ) {
    }
}