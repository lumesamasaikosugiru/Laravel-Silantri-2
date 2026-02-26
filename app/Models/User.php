<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_path',
        'is_actve',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function santriSicks(): HasMany
    {
        return $this->hasMany(SantriSick::class, 'user_id');
    }

    public function santriViolationDetails(): HasMany
    {
        return $this->hasMany(ViolationDetail::class, 'user_id');
    }

    public function santriPermissionInputs(): HasMany
    {
        return $this->hasMany(SantriPermission::class, 'user_id');
    }

    public function santriPermissionApproveds(): HasMany
    {
        return $this->hasMany(SantriPermission::class, 'approved_by');
    }

    public function reportMonthInputs(): HasMany
    {
        return $this->hasMany(ReportMonth::class, 'created_by');
    }

    public function reportMonthValidates(): HasMany
    {
        return $this->hasMany(ReportMonth::class, 'validated_by');
    }
}
