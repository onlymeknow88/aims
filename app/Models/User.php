<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasPermissions, HasRoles, HasUuids, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        // Microsoft SSO fields from aimsv1
        'microsoft_id',
        'microsoft_token',
        'avatar',
        'azure_tenant_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        // Microsoft SSO fields from aimsv1
        'microsoft_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_otp_expires_at' => 'datetime',
    ];

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'user_id');
    }

    public function department()
    {
        return $this->belongsToMany(Department::class, 'department_user')
            ->orderBy('department_user.created_at', 'asc')
            ->limit(1);
    }

    // Keep multi-department relationship for Filament Resource & Document System
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'department_user');
    }

    public function areaManager(): HasOne
    {
        return $this->hasOne(AreaManager::class, 'user_id');
    }

    public function getDepartmentAttribute()
    {
        return $this->departments()->orderBy('department_user.created_at', 'asc')->first();
    }

    public function getCompanyNamesAttribute()
    {
        return $this->departments
            ->pluck('company.company_name')
            ->unique()
            ->filter()
            ->values()
            ->all();
    }

    // Microsoft SSO helpers from aimsv1
    public function azureTenant(): BelongsTo
    {
        return $this->belongsTo(AzureTenant::class);
    }

    public function isMicrosoftUser(): bool
    {
        return ! is_null($this->microsoft_id);
    }

    /**
     * Cek apakah user punya akses ke guard tertentu
     */
    public function hasAccessToGuard(string $guard): bool
    {
        if (in_array($guard, ['web', 'admin', 'dashboard'])) {
            return true;
        }

        return $this->roles()->where('guard_name', $guard)->exists()
            || $this->permissions()->where('guard_name', $guard)->exists();
    }

    /**
     * Ambil semua guard yang bisa diakses user ini
     */
    public function accessibleGuards(): array
    {
        $roleGuards = $this->roles()->pluck('guard_name')->toArray();
        $permGuards = $this->permissions()->pluck('guard_name')->toArray();

        return array_unique(array_merge($roleGuards, $permGuards));
    }
}
