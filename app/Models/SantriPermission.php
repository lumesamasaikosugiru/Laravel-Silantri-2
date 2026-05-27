<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SantriPermission extends Model
{
    protected $fillable =
        [
            'santri_id',
            'type_permission',
            'date_started',
            'ticket_permission',//pulang,keluar,lainnya
            'date_ended',
            'reason',
            'submitted_by',
            'wali_name',
            'wali_phone',
            'wali_relation',
            'status',
            'inputed_by',
            'approved_by',
            'date_approved',
        ];


    protected $casts = [
        'date_started' => 'datetime',
        'date_ended' => 'datetime',
        'date_approved' => 'datetime',
    ];


    public function santriReqPermission(): BelongsTo
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
    public function santriPermissionInput(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inputed_by');
    }
    public function santriPermissionApproved(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
